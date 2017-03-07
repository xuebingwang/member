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
use Notadd\Member\Listeners\RouteMatched;
use Notadd\Member\Commands\PointsCommand;
use Notadd\Member\Listeners\RouteRegistrar;
use Notadd\Foundation\Member\MemberManagement;
use Notadd\Member\Listeners\UserMetadataUpdater;

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

        $this->loadAdminConfig();
        $this->loadAuthConfig();

        $this->app['events']->subscribe(RouteMatched::class);

        $this->app['events']->subscribe(UserMetadataUpdater::class);

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'admin');

        $this->loadMigrationsFrom(__DIR__ . '/../databases/migrations');

        // 注册用户相关权限文件路径
        $this->app['permission']->registerFilePath('user', __DIR__ . '/../config/permission.php');

        // 注册用户模块相关行为积分数据文件
        $this->app['points']->registerFilePath('user', __DIR__ . '/../config/action-points.php');
    }

    public function register()
    {
        $this->app->bind('points', function ($app) {
            return new PointsManager;
        });

        $this->app->singleton('notifier', function ($app) {
            return new Notifier;
        });

        $this->registerCommands();
    }

    public function loadAuthConfig()
    {
        $this->app['config']->set('auth', require __DIR__ . '/../config/auth.php');
    }

    protected function loadAdminConfig()
    {
        $this->app['config']->set('admin', require __DIR__ . '/../config/admin.php');
    }

    public function registerCommands()
    {
        $this->commands([
            PointsCommand::class,
        ]);
    }
}
