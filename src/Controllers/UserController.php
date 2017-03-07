<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-02-08 18:17
 */

namespace Notadd\Member\Controllers;

use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Member\Events\CheckIn;

class UserController extends Controller
{
    public function sign()
    {
        // \Auth::loginUsingId(1, true);

        $user = $this->request->user();

        $this->events->fire(new CheckIn($user));

        return redirect('/');
    }
}
