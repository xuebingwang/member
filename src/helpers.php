<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-02-10 10:34
 */

if (! function_exists('randomPhoneNumber')) {

    function randomPhoneNumber() {
        return '1' . collect(['3', '4', '5', '7', '8'])->random() . mb_substr(str_shuffle('0123456789'), 0, 9);
    }
}

if (! function_exists('sex_trans')) {
    function sex_trans($sex, $sex_arr = [0 => '保密', 1 => '男', 2 => '女']) {
        if (array_key_exists($sex, $sex_arr)) {
            return $sex_arr[$sex];
        }

        return $sex_arr[0];
    }
}

if (! function_exists('current_action')) {
    /**
     * 获取当前路由的控制器和控制器方法
     *
     * @return array
     */
    function current_action() {
        $action = app('router')->current()->getActionName();
        list($class, $method) = explode('@', $action);

        return ['controller' => $class, 'method' => $method];
    }
}
