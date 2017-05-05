<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-31
 * Time: 14:30
 */
$a = [
    ['a1', 'a2', 'a3'],
    ['b1', 'b2', 'b3'],
    ['c1', 'c2', 'c3'],
    ['d1', 'd2', 'd3']
];

function aa1($arr, $curRow = 0, &$findStr)
{

    if ($curRow == count($arr)) {
        echo $findStr . '   ';
        $findStr = "";
        return;
    }

    $col = count($arr[$curRow]);
    for ($i = 0; $i < $col; $i++) {
        $tmp = $findStr . $arr[$curRow][$i];
        aa1($arr, $curRow + 1, $tmp);
    }

}

$str = "";
aa1($a, 0, $str);