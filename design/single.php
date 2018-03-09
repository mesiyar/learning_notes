<?php

//单例模式 实验
class single
{
    //创建静态私有的变量保存该类对象
    static private $instance;
    //参数
    private $config;

    //防止直接创建对象
    private function __construct($config)
    {
        $this->config = $config;
        echo "我被实例化了";
    }

    //防止克隆对象
    private function __clone()
    {

    }

    static  function getInstance($config)
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self($config);
        }
        return self::$instance;

    }

    public function getName()
    {
        echo $this->config;
    }
}

$db1 = single::getInstance(1);
$db1->getName();
echo "<br>";
$db2 = single::getInstance(4);
$db2->getName();
