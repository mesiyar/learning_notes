<?php

$info = $argv[1];


require "./DelayList.php";
if(!empty($info)) {
    $delayList = new DelayList();
    $delayList->push($info);
}
