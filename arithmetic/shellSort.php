<?php
/**
 * Created by PhpStorm.
 * User: eddie
 * Date: 2019/10/31
 * Time: 上午8:26
 */

/**
 * @param array $arr
 * @return array
 */
function shellSort(array $arr)
{
    $len = count($arr);
    if ($len <= 1) return $arr;
    $inc = $len;
    do {
        $inc = ceil($inc / 2);

        for ($i = $inc; $i < $len; $i++) {
            $temp = $arr[$i];
            for ($j = $i - $inc; $j >= 0 && $arr[$j + $inc] < $arr[$j]; $j -= $inc) {
                $arr[$j + $inc] = $arr[$j];
            }
            $arr[$j + $inc] = $temp;
        }
    }while($inc > 1);
    return $arr;
}

$arr = [1, 20, 39, 33, 22, 10, 8, 90];
var_dump(shellSort($arr));
