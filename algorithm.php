<?php
/**
 * Created by PhpStorm.
 * User: eddie
 * Date: 2018/3/9
 * Time: 上午9:29
 */

// question 1 实现一个方法,判断一个正整数是都为2的乘方 要求新能尽可能高
/**
 * 思路一 拿这个数跟2的乘方相比  时间复杂度为 O(logN)
 * @param int $number
 * @return bool
 */
function isPowerOf2_1(int $number):bool
{
    $tmp = 1;
    while ($tmp <= $number) {
        if ($tmp == $number) return true;
        $tmp *= 2;
    }
    return false;
}

/**
 * 改进 : 通过位运算
 * @param int $number
 * @return bool
 */
function isPowerOf2_2(int $number):bool
{
    $tmp = 1;
    while ($tmp <= $number) {
        if ($tmp == $number) return true;
        $tmp = $tmp << 1;
    }
    return false;
}

/**
 * 最终实现
 * @param int $number
 * @return bool
 */
function isPowerOf2(int $number):bool
{
    return ($number & $number-1) == 0 ? true : false;
}

function msTime()
{
    list($msec, $sec) = explode(' ', microtime());
    $msTime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    return $msTime;
}
$num = 212221212122121212;
echo "test1<hr>";
$t = msTime();
$res = isPowerOf2_1($num);
var_dump($res);
echo "spend ".($t - msTime()).'s<hr>';
echo "test2<hr>";
$t = msTime();
$res = isPowerOf2_2($num);
var_dump($res);
echo "spend ".($t - msTime()).'s<hr>';
echo "test3<hr>";
$t = msTime();
$res = isPowerOf2($num);
var_dump($res);
echo "spend ".($t-msTime()).'s<hr>';




