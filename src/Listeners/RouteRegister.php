<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-14 13:56
 */
namespace Notadd\Member\Listeners;

use Notadd\Member\Controllers\Api\BanController;
use Notadd\Member\Controllers\Api\EmailVerifyController;
use Notadd\Member\Controllers\Api\GroupController;
use Notadd\Member\Controllers\Api\InformationController;
use Notadd\Member\Controllers\Api\InformationGroupController;
use Notadd\Member\Controllers\Api\TagController;
use Notadd\Member\Controllers\Api\UserController;
use Notadd\Member\Middleware\Group;
use Notadd\Member\Middleware\Permission;
use Notadd\Member\Middleware\FrontPermission;
use Notadd\Member\Middleware\AdminPermission;
use Notadd\Foundation\Routing\Abstracts\RouteRegister as AbstractRouteRegister;
use Notadd\Member\Controllers\Api\PermissionController as ApiPermissionController;
use Notadd\Member\Controllers\Api\ActionPointsController as ApiActionPointsController;
use Notadd\Member\Controllers\Api\NotificationController as ApiNotificationController;
use Notadd\Member\Controllers\Api\UploadController;

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
        $this->router->group(['middleware' => ['api'], 'prefix' => 'api/member'], function () {
            // 发送邮件激活和验证
            $this->router->post('members/email-verification/send/{email}', EmailVerifyController::class . '@sendEmailVerify');
            $this->router->get('members/email-verification/check/{token}', EmailVerifyController::class . '@activeEmail');

            // 权限
            $this->router->post('permissions/index', ApiPermissionController::class . '@index');
            $this->router->post('permissions/{perm_id}/show', ApiPermissionController::class . '@show');
            $this->router->patch('permissions/store', ApiPermissionController::class . '@store');
            $this->router->delete('permissions/{perm_id}/delete', ApiPermissionController::class . '@destroy');
            // 行为积分
            $this->router->post('points/index', ApiActionPointsController::class . '@index');
            $this->router->post('points/{points_id}/show', ApiActionPointsController::class . '@show');
            // 发送系统通知
            $this->router->post('notifies/system_notify', ApiNotificationController::class . '@systemNotify');
            // 批量发送系统通知
            $this->router->post('notifies/batch_system_notify', ApiNotificationController::class . '@batchSystemNotify');
        });

        $this->router->group(['middleware' => ['auth:api', 'cross', 'web'], 'prefix' => 'api/member'], function () {
            $this->router->post('ban/create', BanController::class . '@create');
            $this->router->post('ban/ip', BanController::class . '@ip');
            $this->router->post('ban/list', BanController::class . '@list');
            $this->router->post('ban/remove', BanController::class . '@remove');
            $this->router->post('group', GroupController::class . '@group');
            $this->router->post('group/create', GroupController::class . '@create');
            $this->router->post('group/edit', GroupController::class . '@edit');
            $this->router->post('group/list', GroupController::class . '@list');
            $this->router->post('group/remove', GroupController::class . '@remove');
            $this->router->post('information', InformationController::class . '@information');
            $this->router->post('information/create', InformationController::class . '@create');
            $this->router->post('information/edit', InformationController::class . '@edit');
            $this->router->post('information/list', InformationController::class . '@list');
            $this->router->post('information/group/create', InformationGroupController::class . '@create');
            $this->router->post('information/group/edit', InformationGroupController::class . '@edit');
            $this->router->post('information/group/list', InformationGroupController::class . '@list');
            $this->router->post('tag', TagController::class . '@tag');
            $this->router->post('tag/create', TagController::class . '@create');
            $this->router->post('tag/edit', TagController::class . '@edit');
            $this->router->post('tag/list', TagController::class . '@list');
            $this->router->post('upload', UploadController::class . '@handle');
            $this->router->post('user', UserController::class . '@user');
            $this->router->post('user/ban', UserController::class . '@ban');
            $this->router->post('user/create', UserController::class . '@create');
            $this->router->post('user/edit', UserController::class . '@edit');
            $this->router->post('user/group', UserController::class . '@group');
            $this->router->post('user/list', UserController::class . '@list');
        });

        $this->router->aliasMiddleware('group', Group::class);
        $this->router->aliasMiddleware('permission', Permission::class);
        $this->router->aliasMiddleware('permission.admin', AdminPermission::class);
        $this->router->aliasMiddleware('permission.front', FrontPermission::class);
    }
}
