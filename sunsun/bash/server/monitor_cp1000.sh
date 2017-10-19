#!/bin/bash
#@author hebidu <email:346551990@qq.com>
#监控加热棒gateway、worker是否存活,定时执行该代码通过crontab
mainString="workerman"
gateway="server_cp1000_gateway"

#echo `ps -fe | grep ${mainString}  | grep ${gateway}  | grep -v grep`
gatewayFindStr=$(ps -fe | grep ${gateway}  | grep -v grep)
#ret=`echo $?`
if [ "${gatewayFindStr}" == "" ]
then
timestamp=`date '+%Y-%m-%d %H:%M:%S'`
echo "cp1000 gateway is need restart process....."
echo -e "$timestamp""cp1000 workerman gateway and worker restart\n" >> ./cp1000.log

./stop_cp1000.sh && ./start_cp1000.sh

else
    echo "cp1000 gateway is runing....."
fi