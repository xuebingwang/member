<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-05-05 20:48
 */
namespace Notadd\Member\Handlers\Permission;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Notadd\Foundation\Passport\Abstracts\DataHandler;
use Notadd\Foundation\Permission\Permission;
use Notadd\Foundation\Permission\PermissionGroup;
use Notadd\Foundation\Permission\PermissionManager;
use Notadd\Foundation\Permission\PermissionTypeManager;
use Notadd\Member\Models\MemberGroup;

/**
 * Class GetHandler.
 */
class GetHandler extends DataHandler
{
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
     * @param \Illuminate\Container\Container                     $container
     * @param \Notadd\Foundation\Permission\PermissionManager     $permission
     * @param \Notadd\Foundation\Permission\PermissionTypeManager $type
     */
    public function __construct(Container $container, PermissionManager $permission, PermissionTypeManager $type)
    {
        parent::__construct($container);
        $this->permission = $permission;
        $this->type = $type;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        $permissions = $this->permission->groups();
        $permissions->transform(function (PermissionGroup $group) {
            $attributes = $group->attributes();
            $permissions = $group->permissions()->transform(function (Permission $permission) {
                return $permission->attributes();
            })->toArray();

            return [
                'attributes'  => $attributes,
                'permissions' => $permissions,
            ];
        });
        $data = new Collection();
        $data->put('groups', MemberGroup::all());
        $data->put('permissions', $permissions->toArray());
        $data->put('types', $this->type->types());

        return $data->toArray();
    }
}
