#!/bin/bash
#@author hebidu <email:346551990@qq.com>
#监控过滤桶gateway、worker是否存活,定时执行该代码通过crontab
mainString="workerman"
gateway="feeder_gateway"
worker="feeder_worker"
register="start_feeder_register.php"

#echo `ps -fe | grep ${mainString}  | grep ${gateway}  | grep -v grep`
registerFindStr=$(ps -fe | grep ${register}  | grep -v grep)
gatewayFindStr=$(ps -fe | grep ${gateway}  | grep -v grep)
workerFindStr=$(ps -fe | grep ${worker}  | grep -v grep)
#ret=`echo $?`
#echo ${gatewayFindStr}
#echo ${workerFindStr}
if [ "${registerFindStr}" == "" -o "${gatewayFindStr}" == "" -o "${workerFindStr}" == "" ]
then
timestamp=`date '+%Y-%m-%d %H:%M:%S'`
echo "feeder gateway and worker is need restart process....."
echo -e "$timestamp""feeder workerman gateway and worker restart\n" >> ./feeder.log

./stop.sh && ./start.sh

else
    echo "feeder gateway and worker is runing....."
fi