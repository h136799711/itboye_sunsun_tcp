<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-10
 * Time: 13:37
 */

namespace sunsun\decoder;


use sunsun\helper\Des;
use sunsun\po\TdsPo;

/**
 * Class SunsunTDS
 * 加解密
 * TODO： 需要根据设备、设备版本 来进行处理
 * @package sunsun\decoder
 */
class SunsunTDS
{


    /**
     * 加密
     * @param $data
     * @param $pwd
     * @return string
     */
    public static function encode($data, $pwd)
    {
        $jsonData = json_encode($data);
        $encryptData = Des::encrypt($jsonData, $pwd);
//        echo $encryptData.'--';
        $hexEncryptData = self::toHex($encryptData);
//        for($i=0;$i < strlen($hexEncryptData) ;$i+=2){
//            echo substr($hexEncryptData,$i,2).' ';
//        }
//        echo '--';
        $msgType = "0001";
        $hexDataLength = strlen($hexEncryptData);
        $dataLength = ($hexDataLength + 16) / 2;
        //补6位
        $hexTotalLength = str_pad(dechex($dataLength), 8, "0", STR_PAD_LEFT);
        $hexEncodeData = $hexTotalLength . $msgType;
        $sum = self::sum($hexEncodeData);
        $sum = $sum + self::sum($hexEncryptData);
        //补4位
        $hexSum = str_pad(dechex($sum), 4, "0", STR_PAD_LEFT);
        $hexEncodeData .= $hexSum . $hexEncryptData;
//        for($i=0;$i < strlen($hexEncodeData) ;$i+=2){
//            echo substr($hexEncodeData,$i,2).' ';
//        }

        return (self::toAscii($hexEncodeData));
    }

    /**
     * 字节序号    名称    对齐方式    内容
     *  0 - 3    消息长度    大端    整个数据包长度，包括数据包头和数据包内容，范围8~UINT32_MAX
     *  4 - 5    消息类型    大端    标注该消息类型
     *           0x0001：DES加密后经过BASE64编码的JSON数据
     *  6 - 7    数据包校验    大端    采用和校验，校验范围包括整个数据包0-N字节，主要验证报文完整性，一旦出现校验错误需要断开连接，重新尝试连接再传输数据
     *  9 - N    数据内容    无    任意字节数据
     * @param $data
     * @param $pwd  string 解密密钥
     * @return TdsPo
     */
    public static function decode($data, $pwd)
    {
        $strLen = strlen($data);
        if ($strLen < 8) {
            return null;
        }
        $encryptData = substr($data, 8, $strLen - 8);
        $data = self::toHex($data);
        $lenHex = substr($data, 0, 8);//4位消息长度
        $dataLength = self::pow($lenHex);
        $msgTypeHex = substr($data, 8, 4);//2位消息类型
        $sumChkHex = substr($data, 12, 4);//2位数据包校验
        $minus_sum_chk = self::sum($sumChkHex);
        $sumChkHex = self::pow($sumChkHex);
        $cal_sum = self::sum($data);
        $cal_sum = $cal_sum - $minus_sum_chk;
        $cal_sum = $cal_sum % (65536);
        //校验和 判断
        $isValidSum = ($cal_sum == $sumChkHex ? 1 : 0);
        $tds_origin_data = self::originData($encryptData, $pwd, $msgTypeHex);
        $po = new TdsPo();
        $po->setTdsData($encryptData);
        $po->setTdsOriginData($tds_origin_data);
        $po->setTdsType($msgTypeHex);
        $po->setTdsValid($isValidSum);
        return $po;
    }

    private static function originData($data, $pwd, $msgTypeHex)
    {
        //$msgTypeHex == 0001
        return Des::decrypt($data, $pwd);
    }

    private static function toAscii($hex)
    {
        $len = strlen($hex);
        $ascii = "";
        for ($i = 0; $i < $len; $i += 2) {
            $one = chr(hexdec(substr($hex, $i, 2)));
            $ascii .= $one;
        }
        return $ascii;
    }

    private static function toHex($ascii)
    {
        $len = strlen($ascii);
        $hex = "";
        for ($i = 0; $i < $len; $i++) {
            $one = dechex(ord(substr($ascii, $i, 1)));
            $hex .= str_pad($one, 2, "0", STR_PAD_LEFT);
        }
        return $hex;
    }

    private static function getPow16($i)
    {
        //0 1 2 3 4 5 6 7
        static $pow16 = [1, 16, 256, 4096, 65536, 1048576, 16777216, 268435456];
        if ($i < 8) {
            return $pow16[$i];
        }

        return pow(16, $i);
    }

    private static function pow($hex)
    {
        $dataLength = 0;
        $strLen = strlen($hex);
//        echo "strlen= ".$strLen.' ';
        for ($i = 0; $i < $strLen; $i++) {
            $pow16 = self::getPow16($strLen - $i - 1);
            $dec = hexdec(substr($hex, $i, 1));
            $dataLength += ($dec * $pow16);
//            echo '  datalength= '.$dataLength.' dec= '.$dec.'  pow='.$pow16;
        }
        return $dataLength;
    }

    private static function sum($hex)
    {
        $len = strlen($hex);
        $sum = 0;
//        echo "hex= ".$hex.' ';
        for ($i = 0; $i < $len;) {

            $one = substr($hex, $i, 2);
            $sum += hexdec($one);
            $i += 2;
        }

        return $sum;
    }

    /**
     * 判断是否合法密码
     * 例子：
     * 密文： gigw+DAcMITN4SuEe6JmkA==
     * 明文： P:12345678
     * @param $pwd string 加密过的密码
     * @param $decodePwd string 解密密钥
     * @return string
     */
    public static function isLegalPwd($pwd, $decodePwd)
    {
        $originPwd = Des::decrypt($pwd, $decodePwd);
        if ($originPwd === false) return "";

        if (strpos($originPwd, "P:") === 0) {
            return substr($originPwd, 2, strlen($originPwd) - 2);
        } else {
            return false;
        }
    }
}