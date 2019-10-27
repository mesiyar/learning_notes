<?php

/**
 * Created by PhpStorm.
 * User: eddie
 * Date: 2018/2/27
 * Time: 上午1:18
 */
class MyRedis
{
    /**
     * @var Redis
     */
    private static $handler;

    /**
     * 获取实例
     * @return Redis
     */
    static function getInstance()
    {
        return self::$handler;
    }
    /**
     * 获取 redis 连接句柄
     * @return Redis
     */
    private static function handler()
    {
        if (!self::$handler) {
            self::$handler = new Redis();
            self::$handler->connect('127.0.0.1', 6379);
            self::$handler->auth('eddie');
        }
        return self::$handler;
    }

    /**
     * 获取值
     * @param $key
     * @return bool|mixed|string
     */
    public static function get($key)
    {
        $value = self::handler()->get($key);
        $value_serl = @unserialize($value);
        if (is_object($value_serl) || is_array($value_serl)) {
            return $value_serl;
        }
        return $value;
    }

    /**
     * 设置值
     * @param $key
     * @param $value
     * @param int $exp
     * @return boolean
     */
    public static function set($key, $value,int $exp):bool
    {
        if (is_object($value) || is_array($value)) {
            $value = serialize($value);
        }

        return self::handler()->set($key, $value, $exp);
    }
}