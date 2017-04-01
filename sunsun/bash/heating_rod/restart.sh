#!/usr/bin/env bash
php ../../src/heating_rod/start_gateway.php restart
php ../../src/heating_rod/start_businessworker.php restart
php ../../src/heating_rod/start_heating_rod_register.php restart
