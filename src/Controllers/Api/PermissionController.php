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

/**
 * Class PermissionController.
 */
class PermissionController extends AbstractApiController
{
    public function index()
    {
        $query = Permission::query()->with('groups');
        $lists = $query->get()->groupBy(function ($item) {
            list($client, $module, $function, $action) = explode('.', $item['name']);

            return $action;
        });
        $results = [];
        $actionValues = ['create' => '创建', 'show' => '查看', 'update' => '编辑', 'delete' => '删除'];
        foreach ($lists as $key => $list) {
            foreach ($list as $item) {
                if (array_key_exists($key, $actionValues)) {
                    $key = $actionValues[$key];
                }
                $results[$key][] = [
                    'id'           => $item->id,
                    'name'         => $item->name,
                    'display_name' => $item->display_name,
                    'description'  => $item->description,
                    'group'        => $item->groups->implode('display_name', '|'),
                ];
            }
        }

        return $this->respondWithArray($results);
    }

    public function show($perm_id)
    {
        $perm = Permission::find(intval($perm_id));
        if (!$perm || !$perm->exists) {
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
