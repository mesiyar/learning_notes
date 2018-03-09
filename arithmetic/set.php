<?php
/**
 * Created by PhpStorm.
 * User: eddie
 * Date: 2018/3/8
 * Time: 下午4:18
 */
// 两个顺序排列的数组A和B 求B数组是否为A的子集(数组内肯定有重复的数字)
$a = array(1, 2, 3, 2, 2, 3, 3, 4, 5);
$b = array(1, 2, 3, 2, 3);

//初始化 数组
function init(array $arr)
{
    $return = [];
    foreach ($arr as $v) {
        if (isset($return[$v])) {
            $return[$v] += 1;
        } else {
            $return[$v] = 0;
        }
    }
    return $return;
}

//实际用的方法
function inSet($a, $b)
{
    $a = init($a);
    $b = init($b);
    $flag = true;
    foreach ($b as $k => $v) {
        if (isset($a[$k]) && $a[$k] >= $v) {
            continue;
        } else {
            $flag = false;
            break;
        }
    }
    return $flag;

}

var_dump(inSet($a, $b));