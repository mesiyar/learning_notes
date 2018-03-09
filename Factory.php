<?php

class Factory
{
    static function getA()
    {
        return new A();
    }

    static function getB()
    {
        return new B();
    }
}

class A
{
    function test()
    {
        echo 'this is the a class';
    }

}

class B
{
    function test()
    {
        echo 'this is the b class';
    }
}

$A = Factory::getA();
$A->test();
echo '<hr>';
$B = Factory::getB();
$B->test();