#!/bin/bash
#@author hebidu <email:346551990@qq.com>
#监控加热棒gateway、worker是否存活,定时执行该代码通过crontab
mainString="workerman"
gateway="server_filter_gateway"

#echo `ps -fe | grep ${mainString}  | grep ${gateway}  | grep -v grep`
gatewayFindStr=$(ps -fe | grep ${gateway}  | grep -v grep)
#ret=`echo $?`
if [ "${gatewayFindStr}" == "" ]
then
timestamp=`date '+%Y-%m-%d %H:%M:%S'`
echo "filter gateway is need restart process....."
echo -e "$timestamp""filter workerman gateway and worker restart\n" >> ./filter.log

./stop_filter.sh && ./start_filter.sh

else
    echo "filter gateway is runing....."
fi