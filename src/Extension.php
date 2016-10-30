<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-14 13:49
 */
namespace Notadd\Member;
use Notadd\Foundation\Extension\Abstracts\ExtensionRegistrar;
use Notadd\Member\Foundation\Driver;
use Notadd\Member\Listeners\RouteRegistrar;
/**
 * Class Extension
 * @package Notadd\Member
 */
class Extension extends ExtensionRegistrar {
    /**
     * @return string
     */
    public function getExtensionName() {
        return 'notadd/member';
    }
    /**
     * @return string
     */
    public function getExtensionPath() {
        return realpath(__DIR__ . '/../');
    }
    /**
     * @return void
     */
    public function register() {
        $this->events->subscribe(RouteRegistrar::class);
        $this->container->make('member')->extend('notadd', function($app) {
            return new Driver($app, $app['events']);
        });
    }
}