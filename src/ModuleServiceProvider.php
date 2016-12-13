<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-14 13:49
 */
namespace Notadd\Member;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Notadd\Foundation\Member\MemberManagement;
use Notadd\Member\Listeners\RouteRegistrar;

/**
 * Class Extension.
 */
class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Boot service provider.
     *
     * @param \Notadd\Foundation\Member\MemberManagement $management
     */
    public function boot(MemberManagement $management)
    {
        $manager = new Manager($this->app['events'], $this->app['router']);
        $management->registerManager($manager);
        $this->app->make(Dispatcher::class)->subscribe(RouteRegistrar::class);
    }
}
