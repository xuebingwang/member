<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-01-23 11:07
 */
namespace Notadd\Member\Middleware;

/**
 * Class AbstractAuthenticate.
 */
abstract class AbstractAuthenticate
{
    protected $auth;

    /**
     * AbstractAuthenticate constructor.
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
