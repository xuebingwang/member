<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-01-23 11:07
 */

namespace Notadd\Member\Middleware;

abstract class AbstractAuthenticate
{
    protected $auth;

    /**
     * Creates a new instance of the middleware.
     *
     * @param Guard $auth
     */
    public function __construct()
    {
        $this->auth = app('auth');
    }

    protected function wantsJson()
    {
        return (app('request')->ajax() || app('request')->wantsJson()) ? true : false;
    }
}
