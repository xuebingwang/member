<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-14 13:56
 */
namespace Notadd\Member\Listeners;

use Notadd\Foundation\Member\Middleware\AdminPermission;
use Notadd\Foundation\Routing\Abstracts\RouteRegister as AbstractRouteRegister;
use Notadd\Member\Controllers\Admin\HomeController;
use Notadd\Member\Controllers\MemberController;
use Notadd\Member\Controllers\Admin\UserController;
use Notadd\Member\Controllers\Admin\GroupController;
use Notadd\Member\Controllers\Admin\TopicController;
use Notadd\Member\Controllers\Admin\PermissionController;
use Notadd\Member\Controllers\Admin\ActionPointsController;
use Notadd\Member\Controllers\UserController as FrontendUserController;
use Notadd\Member\Middleware\Group;
use Notadd\Member\Middleware\Permission;

/**
 * Class RouteRegistrar.
 */
class RouteRegister extends AbstractRouteRegister
{
    /**
     * Handle Route Registrar.
     */
    public function handle()
    {
//        $this->router->group(['middleware' => 'web', 'prefix' => 'member'], function () {
//            $this->router->resource('/', MemberController::class);
//        });
//
//        // 前台
//        $this->router->group(['middleware' => 'web'], function () {
//            $this->router->get('users/sign', FrontendUserController::class . '@sign')->name('users.sign');
//        });
//
//        // 后台
//        $this->router->group(['middleware' => 'web', 'prefix' => 'admin'], function () {
//            $this->router->post('theme', function () {
//                $default = request()->input('theme');
//                app()->make('cookie')->queue(app()->make('cookie')->forever('admin-theme', $default));
//            });
//
//            $this->router->get('clear_cache', HomeController::class . '@clearCache')->name('admin.clear_cache');
//
//            // 首页
//            $this->router->get('/', HomeController::class . '@index');
//
//            $this->router->group(['prefix' => 'user'], function () {
//                // 用户
//                $this->router->get('users', UserController::class . '@index');
//                $this->router->get('users/create', UserController::class . '@create');
//                $this->router->post('users', UserController::class . '@store');
//                $this->router->get('users/{user}/edit', UserController::class . '@edit');
//                $this->router->patch('users/{user}', UserController::class . '@update');
//                $this->router->delete('users/{user}', UserController::class . '@destroy');
//
//                // 用户角色
//                $this->router->get('groups', GroupController::class . '@index');
//                $this->router->get('groups/create', GroupController::class . '@create');
//                $this->router->post('groups', GroupController::class . '@store');
//                $this->router->get('groups/{id}/edit', GroupController::class . '@edit');
//                $this->router->patch('groups/{id}', GroupController::class . '@update');
//                $this->router->delete('groups/{id}', GroupController::class . '@destroy');
//
//                // 用户角色权限
//                $this->router->get('permissions', PermissionController::class . '@index');
//                // $this->router->get('permissions/{id}/edit', PermissionController::class . '@edit');
//                // $this->router->match(['post', 'put'], 'permissions', PermissionController::class . '@update');
//                // $this->router->delete('permissions/{id}', PermissionController::class . '@destroy');
//
//                // 行为积分
//                $this->router->get('action_points', ActionPointsController::class . '@index');
//                $this->router->get('action_points/create', ActionPointsController::class . '@create');
//                $this->router->post('action_points', ActionPointsController::class . '@store');
//                $this->router->get('action_points/{id}/edit', ActionPointsController::class . '@edit');
//                $this->router->patch('action_points/{id}', ActionPointsController::class . '@update');
//                $this->router->delete('action_points/{id}', ActionPointsController::class . '@destroy');
//            });
//
//            $this->router->group(['prefix' => 'topics'], function () {
//                $this->router->get('/', TopicController::class . '@index')->name('admin.topics.index');
//                $this->router->get('create', TopicController::class . '@create')->name('admin.topics.create');
//                $this->router->post('/', TopicController::class . '@store')->name('admin.topics.store');
//            });
//        });
//
        $this->router->aliasMiddleware('group', Group::class);
        $this->router->aliasMiddleware('permission', Permission::class);
        $this->router->aliasMiddleware('admin-permission', AdminPermission::class);
    }
}
