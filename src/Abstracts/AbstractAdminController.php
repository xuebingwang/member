<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime      2016-11-18 14:08
 */
namespace Notadd\Member\Abstracts;

use Illuminate\Support\Str;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class AbstractAdminController.
 */
abstract class AbstractAdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->share('admin_theme', $this->request->cookie('admin-theme'));
    }

    /**
     * @param       $template
     * @param array $data
     * @param array $mergeData
     *
     * @return \Illuminate\Contracts\View\View
     */
    protected function view($template, array $data = [], $mergeData = [])
    {
        if (Str::contains($template, '::')) {
            return $this->view->make($template, $data, $mergeData);
        } else {
            return $this->view->make('admin::' . $template, $data, $mergeData);
        }
    }
}
