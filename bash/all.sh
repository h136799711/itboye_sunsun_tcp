#!/bin/sh
if [ -n "$1" ]; then
   cmd="$1"
else
   cmd="status"
fi

if [ -n "$2" ]; then
  cmd="$1 $2"
fi

./bwgw.sh aq806 ${cmd};
./bwgw.sh adt ${cmd};
./bwgw.sh aph300 ${cmd};
./bwgw.sh aq118 ${cmd};
./bwgw.sh cp1000 ${cmd};
./bwgw.sh filter_vat ${cmd};
./bwgw.sh heating_rod ${cmd};
./bwgw.sh water_pump ${cmd};

