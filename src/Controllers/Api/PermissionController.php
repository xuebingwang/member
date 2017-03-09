<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-03-09 10:45
 */

namespace Notadd\Member\Controllers\Api;

use Notadd\Member\Models\Permission;
use Notadd\Member\Abstracts\AbstractApiController;

class PermissionController extends AbstractApiController
{
    public function index()
    {
        $query = Permission::query()->with('groups');

        $lists = $query->paginate(intval($this->request->get('limit', 20)));

        return $this->respondWithPaginator($lists, function (Permission $list) {
            return [
                'id'           => $list->id,
                'name'         => $list->name,
                'display_name' => $list->display_name,
                'description'  => $list->description,
                'group'        => $list->groups->implode('display_name', '|'),
            ];
        });
    }
}
