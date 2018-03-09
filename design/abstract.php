<?php
/**
 * Created by PhpStorm.
 * User: eddie
 * Date: 2018/3/8
 * Time: 下午11:54
 */
// 抽象类
abstract class Test
{
    abstract function getvalue();
}

abstract class test2
{
    abstract function setVal();
}

class eddie extends test2
{
    function setVal()
    {
        // TODO: Implement setVal() method.
    }
}

//类名 可以是中文
class 测试
{
    static function eddie()
    {
        echo 123;
    }
}

测试::eddie();