#!/bin/sh

#all worker and gateway
if [ -n "$2" ]; then
    cmd="$2"
else
    cmd="status"
fi

if [ -n "$3" ]; then
   cmd="$2 $3"
fi

if [ -n "$1" ]; then
   device="$1"
else
   echo "need param device"
   exit 1
fi
echo "${device} ${cmd}"
cd /home/git/itboye_sunsun_tcp/sunsun/src/${device} && php ./${device}_bworker_master.php ${cmd} && php ${device}_gw_master.php ${cmd}


