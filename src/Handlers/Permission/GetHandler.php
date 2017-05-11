<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-05 20:48
 */
namespace Notadd\Member\Handlers\Permission;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Notadd\Foundation\Passport\Abstracts\DataHandler;
use Notadd\Foundation\Permission\PermissionManager;
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
     * GetHandler constructor.
     *
     * @param \Illuminate\Container\Container                 $container
     * @param \Notadd\Foundation\Permission\PermissionManager $permission
     */
    public function __construct(Container $container, PermissionManager $permission)
    {
        parent::__construct($container);
        $this->permission = $permission;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        $data = new Collection();
        $data->put('groups', MemberGroup::all());
        $data->put('permissions', $this->permission->groups());

        return $data->toArray();
    }
}
