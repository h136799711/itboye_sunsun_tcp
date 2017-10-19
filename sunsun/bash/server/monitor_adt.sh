#!/bin/bash
#@author hebidu <email:346551990@qq.com>
#监控加热棒gateway、worker是否存活,定时执行该代码通过crontab
mainString="workerman"
gateway="server_adt_gateway"

#echo `ps -fe | grep ${mainString}  | grep ${gateway}  | grep -v grep`
gatewayFindStr=$(ps -fe | grep ${gateway}  | grep -v grep)
#ret=`echo $?`
if [ "${gatewayFindStr}" == "" ]
then
timestamp=`date '+%Y-%m-%d %H:%M:%S'`
echo "adt gateway is need restart process....."
echo -e "$timestamp""adt workerman gateway and worker restart\n" >> ./adt.log

./stop_adt.sh && ./start_adt.sh

else
    echo "adt gateway is runing....."
fi