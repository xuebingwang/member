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
use Notadd\Foundation\Passport\Abstracts\Handler;
use Notadd\Foundation\Permission\Permission;
use Notadd\Foundation\Permission\PermissionGroup;
use Notadd\Foundation\Permission\PermissionManager;
use Notadd\Foundation\Permission\PermissionType;
use Notadd\Foundation\Permission\PermissionTypeManager;
use Notadd\Member\Models\MemberGroup;

/**
 * Class GetHandler.
 */
class GetHandler extends Handler
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
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {

        $data = new Collection();
        $data->put('groups', MemberGroup::all());
        $permissions = new Collection();
        $this->permission->groups()->each(function (PermissionGroup $group) use ($permissions) {
            $attributes = $group->attributes();
            $list = new Collection();
            $group->permissions()->each(function (Permission $permission) use ($list) {
                $list->push($permission->attributes());
            });
            $permissions->push([
                'attributes'  => $attributes,
                'permissions' => $list,
            ]);
        });
        $data->put('permissions', $permissions->toArray());
        $types = new Collection();
        $this->type->types()->transform(function (PermissionType $type) use ($types) {
            $types->push([
                'attributes' => $type->attributes(),
                'has'        => $type->has(),
            ]);
        });
        $data->put('types', $types->toArray());
        $this->success()->withData($data->toArray())->withMessage('');
    }
}
