php ../../src/heating_rod/start_gateway.php stop
php ../../src/heating_rod/start_businessworker.php stop
php ../../src/heating_rod/start_heating_rod_register.php stop
ps -ef | grep heating_rod | grep -v grep | cut -c 9-15 | xargs kill -9
