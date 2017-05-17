<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-17 20:14
 */
namespace Notadd\Member;

use Illuminate\Container\Container;

/**
 * Class IntegralManager.
 */
class IntegralManager
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * IntegralManager constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
