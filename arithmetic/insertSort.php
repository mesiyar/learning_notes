<?php
/**
 * Created by PhpStorm.
 * User: eddie
 * Date: 2019/10/31
 * Time: 上午8:13
 */

/**
 * 插入排序
 * @param array $arr
 * @return array
 */
function insertSort(array $arr)
{
    $len = count($arr);
    if ($len <= 1) return $arr;

    for($i=0; $i < $len; $i++){
        // 需要插入的值
        $temp = $arr[$i];
        //将该值与前面的值进行比较
        for ($j= $i-1; $j > 0 && $arr[$j]>$temp;$j--){
            $arr[$j+1] = $arr[$j];//后移
        }
        // 插入到正确的位置
        $arr[$j+1]=$temp;
    }
    return $arr;
}

$arr = [1,20,39,33,22,10,8,90];
var_dump(insertSort($arr));