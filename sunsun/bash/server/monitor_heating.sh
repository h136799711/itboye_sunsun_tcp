#!/bin/bash
#@author hebidu <email:346551990@qq.com>
#监控加热棒gateway、worker是否存活,定时执行该代码通过crontab
mainString="workerman"
gateway="server_heating_gateway"

#echo `ps -fe | grep ${mainString}  | grep ${gateway}  | grep -v grep`
gatewayFindStr=$(ps -fe | grep ${gateway}  | grep -v grep)
#ret=`echo $?`
if [ "${gatewayFindStr}" == "" ]
then
timestamp=`date '+%Y-%m-%d %H:%M:%S'`
echo "heating gateway is need restart process....."
echo -e "$timestamp""heating workerman gateway and worker restart\n" >> ./heating.log

./stop_heating.sh && ./start_heating.sh

else
    echo "heating gateway is runing....."
fi