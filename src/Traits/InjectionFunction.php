<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-03-31 16:58
 */

namespace Notadd\Member\Traits;

trait InjectionFunction
{
    /**
     * The loaded functions for injected.
     *
     * @var array
     */
    protected static $injectedFunctions = [];

    /**
     * Is there a function of name
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasInjectedFunction(string $name)
    {
        return isset(static::$injectedFunctions[$name]);
    }

    /**
     * Injection a function of name
     *
     * @param string   $name
     * @param \Closure $handle
     *
     * @return void
     */
    public static function injectionFunction(string $name, \Closure $handle)
    {
        static::$injectedFunctions[$name] = $handle;
    }

    public function __call($method, $parameters)
    {
        if ($this->hasInjectedFunction($method)) {
            return call_user_func(static::$injectedFunctions[$method], $this, $parameters);
        }

        return parent::__call($method, $parameters);
    }
}
