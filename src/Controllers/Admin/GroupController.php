<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime      2016-08-01 18:32
 */

namespace Notadd\Member\Controllers\Admin;

use Illuminate\Http\Request;
use Notadd\Member\Models\Group;
use Notadd\Member\Models\Permission;
use Notadd\Member\Abstracts\AbstractAdminController;

/**
 * Class RoleController
 *
 * @package App\Admin\Controllers
 */
class GroupController extends AbstractAdminController
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $lists = Group::paginate(20);
        $this->share('lists', $lists);

        return $this->view('user.group.index');
    }

    public function create()
    {
        $group = new Group();

        $permissions       = Permission::all();

        $this->share('group', $group);
        $this->share('permissions', $permissions);

        return $this->view('user.group.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required|max:255',
            'display_name' => 'required|max:255',
        ]);

        // 添加或更新用户组
        $group = Group::addGroup($request->name, $request->display_name, $request->description);
        // // 判断权限是否存在
        $requestPermissions = $this->request->input('permissions', []);
        $permissions        = Permission::whereIn('id', $requestPermissions)->get()->pluck('id')->toArray();

        // 给用户组添加权限
        $group->permissions()->sync($permissions);

        return redirect('admin/user/groups');
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $group = Group::findOrFail($id);

        $permissions       = Permission::all();

        $this->share('group', $group);
        $this->share('permissions', $permissions);

        return $this->view('user.group.update');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required|max:255',
            'display_name' => 'required|max:255',
        ]);

        // 添加或更新用户组
        $group = Group::addGroup($request->name, $request->display_name, $request->description);
        // 判断权限是否存在
        $requestPermissions = $request->input('permissions', []);
        $permissions        = Permission::whereIn('id', $requestPermissions)->get()->pluck('id')->toArray();

        // 更新用户组添加权限, 并删除不在当前权限数组中的权限关系
        $group->permissions()->sync($permissions);

        return redirect('admin/user/groups');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        // 删除该角色的所有权限
        $group->delete();

        return back();
    }
}
