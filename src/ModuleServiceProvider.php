<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-14 13:49
 */
namespace Notadd\Member;

use Illuminate\Events\Dispatcher;
use Notadd\Member\Injections\Installer;
use Notadd\Member\Commands\PointsCommand;
use Notadd\Member\Injections\Uninstaller;
use Notadd\Member\Listeners\RouteRegister;
use Notadd\Member\Listeners\CsrfTokenRegister;
use Notadd\Foundation\Member\MemberManagement;
use Notadd\Foundation\Module\Abstracts\Module;

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
        $this->app->make(MemberManagement::class)->registerManager($manager);
        $this->commands([
            PointsCommand::class,
        ]);
        $this->loadMigrationsFrom(realpath(__DIR__ . '/../databases/migrations'));
        $this->loadViewsFrom(realpath(__DIR__ . '/../resources/views'), 'member');
        $this->loadTranslationsFrom(realpath(__DIR__ . '/../resources/translations'), 'member');

        $this->publishes([
            realpath(__DIR__ . '/../resources/mixes/administration/dist/assets/member/administration') => public_path('assets/member/administration'),
        ], 'public');

        $this->app->make('setting')->set('member.user.create.rules', collect([
            'name'     => 'required|unique:members,name',
            'email'    => 'required|unique:members,email',
            'birthday' => 'nullable|date',
        ])->toJson());

        $this->app->make('setting')->set('member.user.update.rules', collect([
            'name'     => 'required|unique:members,name',
            'email'    => 'required|unique:members,email',
            'birthday' => 'nullable|date',
        ])->toJson());
    }

    /**
     * Description of module
     *
     * @return string
     */
    public static function description()
    {
        return 'Notadd 用户管理模块';
    }

    /**
     * Install module.
     *
     * @return string
     */
    public static function install()
    {
        return Installer::class;
    }

    /**
     * Name of module.
     *
     * @return string
     */
    public static function name()
    {
        return '用户中心';
    }

    /**
     * Register module extra providers.
     */
    public function register()
    {
        $this->app->bind('points', function ($app) {
            return new PointsManager;
        });

        $this->app->singleton('notifier', function ($app) {
            return new Notifier;
        });

        $this->app->bind('email.verification', function ($app) {
            return new EmailVerification($app['mailer'], $app['db']->connection());
        });

        $this->app->alias('email.verification', EmailVerification::class);
    }

    /**
     * Get script of extension.
     *
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function script()
    {
        return asset('assets/member/administration/js/module.min.js');
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
            asset('assets/member/administration/css/module.min.css'),
        ];
    }

    /**
     * Uninstall module.
     *
     * @return string
     */
    public static function uninstall()
    {
        return Uninstaller::class;
    }

    /**
     * Version of module.
     *
     * @return string
     */
    public static function version()
    {
        return '1.0.0';
    }
}
