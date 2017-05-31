<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-05-05 20:48
 */
namespace Notadd\Member\Handlers\Permission;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Permission\Permission;
use Notadd\Foundation\Permission\PermissionGroup;
use Notadd\Foundation\Permission\PermissionGroupManager;
use Notadd\Foundation\Permission\PermissionManager;
use Notadd\Foundation\Permission\PermissionModule;
use Notadd\Foundation\Permission\PermissionModuleManager;
use Notadd\Foundation\Permission\PermissionType;
use Notadd\Foundation\Permission\PermissionTypeManager;
use Notadd\Member\Models\MemberGroup;

/**
 * Class GetHandler.
 */
class GetHandler extends Handler
{
    /**
     * @var \Notadd\Foundation\Permission\PermissionGroupManager
     */
    protected $group;

    /**
     * @var \Notadd\Foundation\Permission\PermissionModuleManager
     */
    protected $module;

    /**
     * @var \Notadd\Foundation\Permission\PermissionManager
     */
    protected $permission;

    /**
     * @var \Notadd\Foundation\Permission\PermissionTypeManager
     */
    protected $type;

    /**
     * GetHandler constructor.
     *
     * @param \Illuminate\Container\Container                       $container
     * @param \Notadd\Foundation\Permission\PermissionGroupManager  $group
     * @param \Notadd\Foundation\Permission\PermissionModuleManager $module
     * @param \Notadd\Foundation\Permission\PermissionManager       $permission
     * @param \Notadd\Foundation\Permission\PermissionTypeManager   $type
     */
    public function __construct(Container $container, PermissionGroupManager $group, PermissionModuleManager $module, PermissionManager $permission, PermissionTypeManager $type)
    {
        parent::__construct($container);
        $this->group = $group;
        $this->module = $module;
        $this->permission = $permission;
        $this->type = $type;
    }

    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $data = new Collection();
        $data->put('groups', MemberGroup::all());
        $modules = new Collection();
        $this->module->list()->each(function (PermissionModule $module) use ($modules) {
            $attributes = $module->attributes();
            $groups = new Collection();
            $this->group->groupsForModule($module->identification())->each(function (PermissionGroup $group) use ($groups, $module) {
                $attributes = $group->attributes();
                $permissions = new Collection();
                $this->permission->permissionsForGroup($module->identification() . '::' . $group->identification())->each(function (Permission $permission) use ($permissions) {
                    $permissions->push($permission->attributes());
                });
                $groups->push([
                    'attributes'  => $attributes,
                    'permissions' => $permissions,
                ]);
            });
            $modules->push([
                'attributes' => $attributes,
                'groups'     => $groups,
            ]);
        });
        $data->put('modules', $modules->toArray());
        $types = new Collection();
        $this->type->types()->each(function (PermissionType $type) use ($types) {
            $types->push([
                'attributes' => $type->attributes(),
                'has'        => $type->has(),
            ]);
        });
        $data->put('types', $types->toArray());
        $this->success()->withData($data->toArray())->withMessage('');
    }
}
