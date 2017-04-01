#!/usr/bin/env bash

#监控过滤桶gateway、worker是否存活,定时执行该代码通过crontab
mainString="workerman"
gateway="filter_vat_gateway"
worker="filter_vat_worker"
register="start_filter_vat_register.php"

#echo `ps -fe | grep ${mainString}  | grep ${gateway}  | grep -v grep`
registerFindStr=$(ps -fe | grep ${register}  | grep -v grep)
gatewayFindStr=$(ps -fe | grep ${gateway}  | grep -v grep)
workerFindStr=$(ps -fe | grep ${worker}  | grep -v grep)
#ret=`echo $?`
#echo ${gatewayFindStr}
#echo ${workerFindStr}
if [ ${registerFindStr} == "" -o ${gatewayFindStr} == "" -o ${workerFindStr} == "" ]
then
timestamp=`date '+%Y-%m-%d %H:%M:%S'`
echo "filter_vat gateway and worker is need restart process....."
echo -e "$timestamp""filter_vat workerman gateway and worker restart\n" >> ./filter_vat.log

./stop.sh
sleep 3s
./start.sh

else
    echo "filter_vat gateway and worker is runing....."
fi