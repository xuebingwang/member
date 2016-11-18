<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-14 13:59
 */
namespace Notadd\Member\Controllers;

use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class MemberController.
 */
class MemberController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->view('');
    }
}
