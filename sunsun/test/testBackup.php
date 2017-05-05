<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-18
 * Time: 19:03
 */
$firstDay = date("Y-m-01", time());
echo $firstDay;
$lastYm = date("Ym", strtotime($firstDay) - 1);
echo $lastYm;
echo strtotime($firstDay);
