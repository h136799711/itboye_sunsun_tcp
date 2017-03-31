<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
#declare(ticks=1);

define("SUNSUN_ENV","debug");//debug模式
define("SUNSUN_WORKER_HOST","101.37.37.167");
define("SUNSUN_WORKER_PORT","3306");
define("SUNSUN_WORKER_USER","sunsun");
define("SUNSUN_WORKER_PASSWORD","poiuyTREWQ123456");
define("SUNSUN_WORKER_DB_NAME","sunsun_xiaoli");

require_once __DIR__ . '/../../../statistics/Clients/StatisticClient.php';
use \GatewayWorker\Lib\Gateway;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{

    public   static  $db;
    //通用密码
    private  static  $commonPwd = "1234bcda";

    //tcp通道无数据传输的最大时间
    public  static  $inactiveTimeInterval = 120;

    public   static  $tcpClientDal;

    public   static  $clientDal;

    //接收到数据的最近一次时间
    private static  $activeTime;

    public static function onWorkerStart($businessWorker)
    {

        self::$db = new \Workerman\MySQL\Connection(SUNSUN_WORKER_HOST, SUNSUN_WORKER_PORT, SUNSUN_WORKER_USER, SUNSUN_WORKER_PASSWORD, SUNSUN_WORKER_DB_NAME);
        //记录Worker启动信息
        self::log($businessWorker->id,'heating_rod WorkerStart ');
        //清空首登设备
        self::getTcpClientDal()->clearAll();
        //清空日志
//        (new \sunsun\heating_rod\dal\HeatingRodTcpLogDal(self::$db))->clearAll();
        $time_interval = 30;
        \Workerman\Lib\Timer::add($time_interval, function(){
            $allSessions = Gateway::getAllClientSessions();
            $nowTime = time();
            foreach ($allSessions as $clientId=>$session){
                $lastActiveTime = $session['last_active_time'];
                if($nowTime - $lastActiveTime > self::$inactiveTimeInterval){
                    $msg = "tcp server waiting for more than ".self::$inactiveTimeInterval." seconds";
                    self::closeChannel($clientId,$msg);
                }
            }
        });
    }

    /**
     * 获取 tcp_client 日志
     * @return \sunsun\heating_rod\dal\HeatingRodTcpClientDal
     */
    public static function getTcpClientDal(){
        if(self::$tcpClientDal == null){
            self::$tcpClientDal = new \sunsun\heating_rod\dal\HeatingRodTcpClientDal(self::$db);
        }
        return self::$tcpClientDal;
    }

    /**
     * 获取设备dal类
     * @return \sunsun\heating_rod\dal\HeatingRodDeviceDal
     */
    public static function getClientDal(){
        if(self::$clientDal == null){
            self::$clientDal = new \sunsun\heating_rod\dal\HeatingRodDeviceDal(self::$db);
        }
        return self::$clientDal;
    }

    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * 
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
        // 向当前client_id发送数据
        self::log($client_id,'onConnect');
        self::getTcpClientDal()->insert($client_id);

    }


    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param $message
     */
   public static function onMessage($client_id, $message)
   {
       try{

            self::log($client_id,$message,"origin_message");
            self::$activeTime = time();
            $_SESSION['last_active_time'] = self::$activeTime;
            $_SESSION['last_recv_message'] = gmdate("Y/m/d H:i:s",self::$activeTime);
            //非字符串消息
            if(!is_string($message)) {
                self::jsonError($client_id,'invalid message format',[]);
                return ;
            }

            // 0. 记录日志信息
            self::log($client_id,$message);
            //TODO： 需要根据设备、设备版本 来进行处理
            // -1. 更新client
            $result = self::getTcpClientDal()->getInfo($client_id);

            if($result === false) {
               self::jsonError($client_id,"tcp channel closed",[]);
               return ;
            }
            $client_id = $result['client_id'];
            $cnt = $result['cnt'];
            $pwd = "";
            if($cnt == 0) {
                 self::log($client_id,"login start");
                //第一次请求
                $pwd = self::$commonPwd;
                $result = self::login($client_id,$message,$pwd);

                self::log($client_id,"login complete");
           }else{
               self::log($client_id,"other process");
               //其它请求
               // 1. 获取密钥
               $result = self::getEncryptPwd($result);
               if($result === false) {
                   self::jsonError($client_id,"get encrypt password failed",null);
                   return ;
               }
               $pwd = $result['pwd'];
               $did = $result['did'];
               $result = \sunsun\decoder\SunsunTDS::decode($message,$pwd);
               if(empty($result)){
                   self::jsonError($client_id,'fail decode the data ',[]);
                   return ;
               }
               if(!$result->isValid()){
                   self::jsonError($client_id,'the data format is invalid',[]);
                   return ;
               }
               self::log($client_id,$result->getTdsOriginData(),"decode_message");
               // 3. 处理业务逻辑
               $result = self::process($did,$client_id,$result->getTdsOriginData());

           }

           if(empty($result)){
               self::reportStatics(3,"null result");
               return ;
           }

           if($result instanceof  \Exception) {
               self::closeChannel($client_id,$result->getTraceAsString());
               self::reportStatics(3,$result->getTraceAsString());
               return ;
           }

           self::log($client_id,json_encode($result),"return");
           if(method_exists($result,"toDataArray")){
               // 4. 加密数据
               $encodeData = \sunsun\decoder\SunsunTDS::encode($result->toDataArray(),$pwd);
               self::jsonSuc($client_id,'success return',$encodeData);

           }else{
               self::jsonError($client_id,'fail',[]);
           }



       }catch (Exception $ex){
           self::log($client_id,$ex->getTraceAsString(),"exception");
           self::jsonError($client_id,$ex->getMessage(),[]);
       }
       return ;
   }


   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id)
   {
       self::closeChannel($client_id,"tcp client close the channel");
   }

    //============================帮助方法


    private static function reportStatics($code=0,$msg=''){
        StatisticClient::tick("HeatingRod", 'message');
        // 统计的产生，接口调用的时间

        $success = true;
        if($code != 0){
            $success = false;
        }
        // 上报结果
        StatisticClient::report('HeatingRod', 'message', $success, $code, $msg);
    }

    /**
     * 处理业务逻辑
     * @param $did
     * @param $clientId
     * @param $originData
     * @return mixed
     * @internal param $client_id
     * @internal param \sunsun\po\TdsPo $tdsPo
     * @internal param $json
     */
    private static function process($did,$clientId,$originData){
        //处理请求
        self::log($clientId,$originData,'origin_data');
        $jsonDecode = json_decode($originData,JSON_OBJECT_AS_ARRAY);
        //1. Device 这里替换成具体设备的process类
        $resp = (new \sunsun\heating_rod\action\HeatingRodProcessAction())->process($did,$clientId,$jsonDecode);
        return $resp;
    }

    /**
     * 设备登录
     * @param $client_id
     * @param $message
     * @param $pwd
     * @return bool|\sunsun\heating_rod\resp\HeatingRodLoginResp
     */
    private static function login($client_id,$message,&$pwd){

        $result = \sunsun\decoder\SunsunTDS::decode($message,$pwd);
        if($result == null){
            self::jsonError($client_id,'decode fail',[]);
            return false;
        }
        if(!$result->isValid()){
            self::jsonError($client_id,'the data format is invalid',[]);
            return false;
        }
        //{"reqType": "1","sn": "0","did": "10000001","ver": "V1.0","pwd": "gigw+DAcMITN4SuEe6JmkA=="}
        $dal = self::getClientDal();
        $originData = $result->getTdsOriginData();

        $data = json_decode($originData,JSON_OBJECT_AS_ARRAY);

        //2. Device 这里替换成具体设备的请求工厂类
        $req  = \sunsun\heating_rod\req\HeatingRodReqFactory::create(\sunsun\heating_rod\req\HeatingRodReqType::Login,$data);
        $did = $req->getDid();
        if(empty($did)){
            self::jsonError($client_id,'which did is empty',[]);
            return false;
        }
        $result = $dal->getInfoByDid($did);
        if(empty($result)){
            self::jsonError($client_id,'which did='.$did.'is not exists',[]);
            return false;
        }

        $id = $result['id'];
        $pwd = $result['pwd'];
        $hb = $result['hb'];//心跳周期（单位：秒）
        $originPwd = \sunsun\decoder\SunsunTDS::isLegalPwd($data['pwd'],$pwd);
        if(empty($originPwd)){
            self::jsonError($client_id,'the control password decode fail',[]);
            return false;
        }

        $data['origin_pwd'] = $originPwd;

        //更新控制密码
        $entity = [
            'ctrl_pwd'=>$originPwd,
            'last_login_time'=>self::$activeTime,
            'update_time'=>self::$activeTime,
            'last_login_ip'=>self::getClientIp(),
            'tcp_client_id'=>$client_id
        ];
        $dal->update($id,$entity);
        //更新
        self::getTcpClientDal()->update($client_id);
        //设置返回响应包

        //3. Device 这里替换成具体设备的登录响应类
        $resp = new \sunsun\heating_rod\resp\HeatingRodLoginResp();
        $resp->setSn($req->getSn());
        $resp->setLoginSuccess();
        $resp->setHb($hb);
        //绑定did 和 client_id
        Gateway::bindUid($client_id,$did);
        return  $resp;
    }

    /**
     * 获取加密密钥
     * @param $result
     * @return array|bool
     */
    private static function getEncryptPwd($result){
       $client_id = $result['client_id'];
       $result = self::getClientDal()->loginByTcpClientId($client_id,self::getClientIp());
       if($result === false) return false;
       return $result;
    }


    /**
     * 获取客服端ip
     * @return string
     */
    private static function getClientIp(){

       if($_SERVER && array_key_exists("REMOTE_ADDR",$_SERVER)){
            return $_SERVER['REMOTE_ADDR'];
        }

        return "";
    }

    private static function jsonError($client_id,$msg,$data){
        self::log($client_id,$msg,\sunsun\consts\LogType::Error);
        Gateway::closeClient($client_id);
        self::reportStatics(3,$msg);
    }

    private static function jsonSuc($client_id,$msg,$data){
        self::log($client_id,$msg.','.$data,\sunsun\consts\LogType::Success);
        Gateway::sendToClient($client_id,$data);
        self::reportStatics();
    }


    /**
     * 关闭
     * @param $clientId
     * @param $closeMsg
     */
    private static function closeChannel($clientId,$closeMsg){
        //1. tcp_client 删除记录
        self::getTcpClientDal()->delete($clientId);
        //2. client 登出记录
        self::getClientDal()->logoutByClientId($clientId);
        //3. tcp通道关闭
        Gateway::closeClient($clientId);
        //4. 日志记录
        self::log($clientId,$closeMsg,\sunsun\consts\LogType::CloseChannel);
    }


    /**
     * 日志记录
     * @param string $client_id  通道编号
     * @param string $message  日志内容
     * @param string $type 日志类型
     */
    public static function log($client_id,$message,$type='common'){
        \sunsun\helper\LogHelper::log(self::$db,$client_id,$message,$type);
    }
}
