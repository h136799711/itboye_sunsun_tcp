php ../../src/filter_vat/start_gateway.php stop
php ../../src/filter_vat/start_businessworker.php stop
php ../../src/filter_vat/start_filter_vat_register.php stop
ps -ef | grep filter_vat | grep -v grep | cut -c 9-15 | xargs kill -9