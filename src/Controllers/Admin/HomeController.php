<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-02-10 10:00
 */

namespace Notadd\Member\Controllers\Admin;

use Carbon\Carbon;
use Notadd\Member\Models\Member;
use Notadd\Member\Abstracts\AbstractAdminController;

class HomeController extends AbstractAdminController
{
    public function index()
    {
        $now = Carbon::now();

        $todayUsersCount = Member::where('created_at', '>=', $now->startOfDay())
            ->where('created_at', '<=', $now->endOfDay())
            ->count();


    }
}
