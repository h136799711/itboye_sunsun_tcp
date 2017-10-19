#!/bin/bash
#@author hebidu <email:346551990@qq.com>
#监控加热棒gateway、worker是否存活,定时执行该代码通过crontab
mainString="workerman"
gateway="server_aq806_gateway"

#echo `ps -fe | grep ${mainString}  | grep ${gateway}  | grep -v grep`
gatewayFindStr=$(ps -fe | grep ${gateway}  | grep -v grep)
#ret=`echo $?`
if [ "${gatewayFindStr}" == "" ]
then
timestamp=`date '+%Y-%m-%d %H:%M:%S'`
echo "aq806 gateway is need restart process....."
echo -e "$timestamp""aq806 workerman gateway and worker restart\n" >> ./aq806.log

./stop_aq806.sh && ./start_aq806.sh

else
    echo "aq806 gateway is runing....."
fi