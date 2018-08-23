#!/bin/sh
if [ -n "$1" ]; then
    echo "$1 the $2 register"
    device="$1"
else
    echo "need param (adt,aph300,aq806,aq118,heating,filter,water,cp1000,feeder)"
    exit 1
fi

if [ -n "$2" ]; then
   cmd="$2"
else
  #  echo "need param (adt,aph300,aq806,aq118,heating,filter,water,cp1000,feeder)"
   cmd="status"
fi

if [ -n "$3" ]; then
  cd /home/git/itboye_sunsun_tcp/sunsun/src/${device} && php ./${device}_register.php ${cmd} -d;
else
  cd /home/git/itboye_sunsun_tcp/sunsun/src/${device} && php ./${device}_register.php ${cmd};
fi
