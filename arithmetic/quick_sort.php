<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/30 0030
 * Time: 18:51
 */

/**
 * 快速排序
 * @param array $arr
 * @return array
 */
function quick_sort(array $arr = [])
{
    $len = count($arr);
    if ($len <= 1) {
        return $arr;
    }

    $middle = $arr[0];

    $left = [];
    $right = [];


    for ($i=1; $i < $len; $i++) {
        if ($middle < $arr[$i]) {
            $right[] = $arr[$i];
        } else {
            $left[] = $arr[$i];
        }
    }

    $left = quick_sort($left);
    $right = quick_sort($right);

    return array_merge($left, [$middle], $right);
}