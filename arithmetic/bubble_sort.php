<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/30 0030
 * Time: 18:43
 */

/**
 * 快排
 * @param array $arr
 * @return array
 */
function bubble_sort(array $arr = [])
{
    $len = count($arr);
    if($len <= 1) {
        return $arr;
    }

    for($i = 0; $i< $len; $i++) {
        for ($j = $i+1; $j < $len; $j++){
            if($arr[$i] > $arr[$j]) {
                $tmp = $arr[$j];
                $arr[$j] = $arr[$i];
                $arr[$i] = $tmp;
            }
        }
    }
    return $arr;

}
