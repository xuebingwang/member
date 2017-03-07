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
use Notadd\Foundation\Member\MemberManagement;
use Notadd\Foundation\Module\Abstracts\Module;
use Notadd\Member\Listeners\RouteRegister;

/**
 * Class Extension.
 */
class ModuleServiceProvider extends Module
{
    /**
     * Boot service provider.
     */
    public function boot()
    {
        $manager = new Manager($this->app['events'], $this->app['router']);
        $this->app->make(Dispatcher::class)->subscribe(RouteRegister::class);
        $this->app->make(MemberManagement::class)->registerManager($manager);
    }

    /**
     * Install module.
     *
     * @return bool
     */
    public function install()
    {
        return true;
    }

    /**
     * Uninstall module.
     *
     * @return mixed
     */
    public function uninstall()
    {
        return true;
    }
}
