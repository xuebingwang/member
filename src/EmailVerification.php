<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-04-18 17:27
 */

namespace Notadd\Member;

use Illuminate\Support\Str;

class EmailVerification
{
    protected function generateToken()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }
}
