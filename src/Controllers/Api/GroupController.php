<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-03-08 18:09
 */

namespace Notadd\Member\Controllers\Api;

use Notadd\Member\Models\Group;
use Notadd\Member\Abstracts\AbstractApiController;

class GroupController extends AbstractApiController
{
    public function index()
    {
        $query = Group::query();

        $lists = $query->paginate(intval($this->request->get('limit', 20)));

        return $this->respondWithPaginator($lists, function (Group $list) {
            return [
                'id'           => $list->id,
                'name'         => $list->name,
                'display_name' => $list->display_name,
                'permission'   => $list->cachedPermissions()->implode('display_name', '|'),
            ];
        });
    }

    public function show($group_id)
    {
        $group = Group::find(intval($group_id));

        if (! $group || ! $group->exists) {
            return $this->errorNotFound();
        }

        return $this->respondWithItem($group, function (Group $list) {
            return [
                'id'           => $list->id,
                'name'         => $list->name,
                'display_name' => $list->display_name,
                'permission'   => $list->cachedPermissions()->implode('display_name', '|'),
            ];
        });
    }
}
