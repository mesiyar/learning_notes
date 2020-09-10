<?php


class Solution
{
    /**
     * 给定一个字符串，找到它的第一个不重复的字符，并返回它的索引。如果不存在，则返回 -1。
     *-------------------------------
     * | 示例：                     *
     * | s = "leetcode"             *
     * | 返回 0                     *
     * |                            *
     * | s = "loveleetcode"         *
     * |返回 2                      *
     * ------------------------------
     * @param String $s
     * @return Integer
     */
    function firstUniqChar_V1(string $s)
    {
        $len = strlen($s);
        $str_arr = [];
        for ($i = 0; $i < $len; $i++){
            $str = $s[$i];
            if(isset($str_arr[$str])) {
                $num = $str_arr[$str]['count'];
                $str_arr[$str]['count'] = $num +1;
            } else {
                $str_arr[$str] = [
                    'cur' => $i,
                    'count' => 1
                ];
            }
        }
        foreach ($str_arr as $value) {
            if ($value['count'] == 1) {
                return $value['cur'];
            }
        }
        return -1;
    }

    function firstUniqChar(string $s)
    {
        $n = strlen($s);
        if ($n == 0) return -1;
        $hash = [];
        for ($i = 0; $i < $n; ++$i) {
            $hash[$s[$i]][] = $i;
        }

        foreach ($hash as $v) {
            if (count($v) == 1) return reset($v);
        }

        return -1;

    }

    /**
     * 字符串转换整数 (atoi)
     *
     * @param String $str
     * @return Integer
     */
    function myAtoi($str) {
        $str= trim($str);
        $num = '';
        $len = strlen($str);
        if($len == 0) return 0;
        for ($i = 0; $i < $len; ++$i) {
            $s = $str[$i];
            $chr = ord($s);
            if(($chr >= 48 && $chr <= 57) || $s == '-' || $s == '+') {
                $num .= $s;
            } elseif($i == 0){
                return 0;
            }else {
                break;
            }
        }
        $num = (int)$num;
        $min = -pow(2, 31);
        $max =  pow(2, 31)-1;
        if($num > $max) {
            return $max;
        } elseif($num < $min) {
            return $min;
        } else {
            return $num;
        }
    }
}