<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-14 13:56
 */
namespace Notadd\Member\Listeners;

use Notadd\Member\Middleware\Group;
use Notadd\Member\Middleware\Permission;
use Notadd\Member\Middleware\FrontPermission;
use Notadd\Foundation\Member\Middleware\AdminPermission;
use Notadd\Member\Controllers\Api\GroupController as ApiGroupController;
use Notadd\Member\Controllers\Api\MemberController as ApiMemberController;
use Notadd\Foundation\Routing\Abstracts\RouteRegister as AbstractRouteRegister;
use Notadd\Member\Controllers\Api\PermissionController as ApiPermissionController;
use Notadd\Member\Controllers\Api\ActionPointsController as ApiActionPointsController;

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
            // 用户
            $this->router->post('members/index', ApiMemberController::class . '@index');
            $this->router->post('members/{member_id}/show', ApiMemberController::class . '@show');
            $this->router->patch('members/{member_id}/update', ApiMemberController::class . '@update');
            // 用户组
            $this->router->post('groups/index', ApiGroupController::class . '@index');
            $this->router->post('groups/{group_id}/show', ApiGroupController::class . '@show');
            $this->router->patch('groups/store', ApiGroupController::class . '@store');
            // 权限
            $this->router->post('permissions/index', ApiPermissionController::class . '@index');
            $this->router->post('permissions/{perm_id}/show', ApiPermissionController::class . '@show');
            $this->router->patch('permissions/store', ApiPermissionController::class . '@store');
            // 行为积分
            $this->router->post('points/index', ApiActionPointsController::class . '@index');
            $this->router->post('points/{points_id}/show', ApiActionPointsController::class . '@show');
        });

        $this->router->aliasMiddleware('group', Group::class);
        $this->router->aliasMiddleware('permission', Permission::class);
        $this->router->aliasMiddleware('permission.admin', AdminPermission::class);
        $this->router->aliasMiddleware('permission.front', FrontPermission::class);
    }
}
