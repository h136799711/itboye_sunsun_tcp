#!/bin/bash
#@author hebidu <email:346551990@qq.com>
#监控加热棒gateway、worker是否存活,定时执行该代码通过crontab
mainString="workerman"
gateway="server_aph300_gateway"

#echo `ps -fe | grep ${mainString}  | grep ${gateway}  | grep -v grep`
gatewayFindStr=$(ps -fe | grep ${gateway}  | grep -v grep)
#ret=`echo $?`
if [ "${gatewayFindStr}" == "" ]
then
timestamp=`date '+%Y-%m-%d %H:%M:%S'`
echo "aph300 gateway is need restart process....."
echo -e "$timestamp""aph300 workerman gateway and worker restart\n" >> ./aph300.log

./stop_aph300.sh && ./start_aph300.sh

else
    echo "aph300 gateway is runing....."
fi