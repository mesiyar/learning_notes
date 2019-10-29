<?php
#php 生成 二维码的时候的大小控制参数

$i = 250;
$j = floor($i / 33 * 100) / 100 + 0.01;//公式
QRcode::png('http://www.baidu.com', false, 0, $j);

