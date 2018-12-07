<?php

//$arr = ["AB", "CD", "1"];
//if (in_array("1", $arr)) {
//    echo "exists";
//} else {
//    echo "not exists";
//}

require_once  __DIR__. "/vendor/autoload.php";


\sunsun\server\business\DebugHelper::refreshDid("AB,CD,1");
var_dump(\sunsun\server\business\DebugHelper::$DebugDid);

\sunsun\server\business\DebugHelper::sendByDid("ABC", "nihao");