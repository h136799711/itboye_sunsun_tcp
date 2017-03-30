#监控过滤桶gateway、worker是否存活,定时执行该代码通过crontab
mainString="workerman"
gateway="heating_rod_gateway"
worker="heating_rod_worker"
register="start_heating_rod_register.php"

#echo `ps -fe | grep ${mainString}  | grep ${gateway}  | grep -v grep`
registerFindStr=$(ps -fe | grep ${register}  | grep -v grep)
gatewayFindStr=$(ps -fe | grep ${gateway}  | grep -v grep)
workerFindStr=$(ps -fe | grep ${worker}  | grep -v grep)
#ret=`echo $?`
#echo ${gatewayFindStr}
#echo ${workerFindStr}
if [ "${registerFindStr}" == "" ] || [ "${gatewayFindStr}" == "" ] || [ "${workerFindStr}" == "" ]
then
timestamp=`date '+%Y-%m-%d %H:%M:%S'`
echo "heating_rod gateway and worker is need restart process....."
echo -e "$timestamp"" heating_rod workerman gateway and worker restart\n" >> ./heating_rod.log

./stop.sh
sleep 3s
./start.sh

else
    echo "heating_rod gateway and worker is runing....."
fi