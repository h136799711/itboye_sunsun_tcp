php ../../src/cp1000/timer_worker.php stop && php ../../src/cp1000/start_gateway.php stop && php ../../src/cp1000/start_businessworker.php stop && php ../../src/cp1000/start_cp1000_register.php stop && ps -ef | grep cp1000 | grep -v grep | cut -c 9-15 | xargs kill -9 && ps -ef | grep WorkerMan | grep 1243 | grep -v grep | cut -c 9-15 | xargs kill -9