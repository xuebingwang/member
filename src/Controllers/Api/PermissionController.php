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

    public function show($perm_id)
    {
        $perm = Permission::find(intval($perm_id));

        if (! $perm || ! $perm->exists) {
            return $this->errorNotFound();
        }

        return $this->respondWithItem($perm, function (Permission $list) {
            return [
                'id'           => $list->id,
                'name'         => $list->name,
                'display_name' => $list->display_name,
                'description'  => $list->description,
                'group'        => $list->groups->implode('display_name', '|'),
            ];
        });
    }

    /**
     * 权限添加和编辑方法
     *
     * @return mixed
     */
    public function store()
    {
        $validator = $this->getValidationFactory()->make(
            $this->request->all(),
            [
                'name'         => 'required',
                'display_name' => 'required',
            ],
            [
                'name.required'         => '请输入名称.',
                'display_name.required' => '请输入显示名称.',
            ]
        );

        if ($validator->fails()) {
            return $this->errorValidate($validator->getMessageBag()->toArray());
        }

        Permission::addPermission(
            $this->request->name,
            $this->request->display_name,
            $this->request->input('description', null)
        );

        return $this->noContent();
    }
}
