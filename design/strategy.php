<?php
/**
 * Created by PhpStorm.
 * User: eddie
 * Date: 2018/3/8
 * Time: 下午9:36
 */

//  用户策略模式
//  接口 interface
interface UserStrategy
{
    function showAd();
    function showCategory();
}

class male implements UserStrategy
{
    function showAd()
    {
        echo 'this is show to male';
        // TODO: Implement showAd() method.
    }

    function showCategory()
    {
        echo 'this is show category to male';
        // TODO: Implement showCategory() method.
    }
}

class female implements UserStrategy
{
    function showAd()
    {
        echo 'this is show to female';
        // TODO: Implement showAd() method.
    }

    function showCategory()
    {
        echo 'this is show category to female';
        // TODO: Implement showCategory() method.
    }
}