<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime      2016-11-18 14:23
 */
namespace Notadd\Member\Controllers;

use Notadd\Member\Abstracts\AbstractAdminController;

/**
 * Class HomeController.
 */
class HomeController extends AbstractAdminController
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // return $this->container->make('files')->get(public_path('index.html'));
        return $this->view('index');
    }

    public function clearCache()
    {
        $this->getCache()->flush();

        return $this->redirector->back()->withMessages('缓存清除成功.');
    }
}
