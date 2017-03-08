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
use Notadd\Member\Commands\PointsCommand;
use Notadd\Member\Listeners\CsrfTokenRegister;
use Notadd\Member\Listeners\RouteRegister;
use Notadd\Member\Listeners\UserMetadataUpdater;

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
        $this->app->make(Dispatcher::class)->subscribe(CsrfTokenRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(RouteRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(UserMetadataUpdater::class);
        $this->app->make(MemberManagement::class)->registerManager($manager);
        $this->commands([
            PointsCommand::class,
        ]);
        $this->loadMigrationsFrom(realpath(__DIR__ . '/../databases/migrations'));
        $this->publishes([
            realpath(__DIR__ . '/../resources/mixes/administration/dist/assets/member/administration') => public_path('assets/member/administration')
        ], 'public');
        $this->app['permission']->registerFilePath('user', __DIR__ . '/../config/permission.php');
        $this->app['points']->registerFilePath('user', __DIR__ . '/../config/action-points.php');
    }

    /**
     * Description of module
     *
     * @return string
     */
    public function description()
    {
        return 'Notadd 用户管理模块';
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
     * Name of module.
     *
     * @return string
     */
    public function name()
    {
        return '用户管理模块';
    }

    /**
     * Register module extra providers.
     */
    public function register()
    {
        $this->app->bind('points', function ($app) {
            return new PointsManager;
        });
    }

    /**
     * Get script of extension.
     *
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function script()
    {
        return asset('assets/member/administration/js/module.js');
    }

    /**
     * Get stylesheet of extension.
     *
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function stylesheet()
    {
        return [
            asset('assets/member/administration/css/module.css'),
        ];
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
