<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-03-31 16:58
 */

namespace Notadd\Member\Traits;

use Closure;

trait InjectionFunction
{
    /**
     * The injected string functions.
     *
     * @var array
     */
    protected static $injectedFunctions = [];

    /**
     * Injection a custom function.
     *
     * @param string   $name
     * @param callable $handle
     *
     * @return void
     */
    public static function injectionFunction(string $name, callable $handle)
    {
        static::$injectedFunctions[$name] = $handle;
    }

    /**
     * Checks if function is injected.
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
     * Dynamically handle calls to the class.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if ($this->hasInjectedFunction($method)) {

            if (static::$injectedFunctions[$method] instanceof Closure) {
                return call_user_func(static::$injectedFunctions[$method]->bindTo($this, static::class), $parameters);
            }

            return call_user_func(static::$injectedFunctions[$method], $this, $parameters);
        }

        return parent::__call($method, $parameters);
    }
}
