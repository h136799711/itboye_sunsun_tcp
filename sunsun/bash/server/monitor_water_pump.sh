#!/bin/bash
#@author hebidu <email:346551990@qq.com>
#监控变频水泵gateway、worker是否存活,定时执行该代码通过crontab
mainString="workerman"
gateway="water_pump_gateway_8286"

#echo `ps -fe | grep ${mainString}  | grep ${gateway}  | grep -v grep`
gatewayFindStr=$(ps -fe | grep ${gateway}  | grep -v grep)
#ret=`echo $?`
if [ "${gatewayFindStr}" == ""]
then
timestamp=`date '+%Y-%m-%d %H:%M:%S'`
echo "water_pump gateway is need restart process....."
echo -e "$timestamp""water_pump workerman gateway and worker restart\n" >> ./water_pump.log

./stop_water_pump.sh && ./start_water_pump.sh

else
    echo "water_pump gateway is runing....."
fi