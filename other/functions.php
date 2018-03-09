<?php
/**
 * Created by PhpStorm.
 * User: eddie
 * Date: 2018/3/9
 * Time: 上午11:03
 */

/**
 * php 中没有毫秒级的函数
 * 作用  返回 毫秒级别的时间戳
 * @return float
 */
function msTime()
{
    list($msec, $sec) = explode(' ', microtime());
    $msTime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    return $msTime;
}
