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
