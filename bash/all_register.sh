#!/bin/sh
if [ -n "$1" ]; then
   cmd="$1"
else
   cmd="status"
fi

if [ -n "$2" ]; then
  cmd="$1 $2"
fi

./register.sh aq806 ${cmd};
./register.sh adt ${cmd};
./register.sh aph300 ${cmd};
./register.sh aq118 ${cmd};
./register.sh cp1000 ${cmd};
./register.sh filter_vat ${cmd};
./register.sh heating_rod ${cmd};
./register.sh water_pump ${cmd};

