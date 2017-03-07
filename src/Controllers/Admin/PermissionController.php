<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime      2016-08-02 10:28
 */

namespace Notadd\Member\Controllers\Admin;

use Illuminate\Http\Request;
use Notadd\Member\Models\Permission;
use Notadd\Member\Abstracts\AbstractAdminController;

/**
 * Class PermissionController
 *
 * @package App\Admin\Controllers
 */
class PermissionController extends AbstractAdminController
{
    /**
     * @return mixed
     */
    public function index()
    {
        $lists = Permission::with('groups')->paginate(20);
        $this->share('lists', $lists);

        return $this->view('user.permission.index');
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function edit($id = 0)
    {
        if (! $id) {
            $permission = new Permission();
        } else {
            $permission = Permission::findOrFail($id);
        }
        $this->share('permission', $permission);
        if (! $id) {
            return $this->view('user.permission.create');
        }

        return $this->view('user.permission.update');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required|max:100',
            'display_name' => 'required|max:200',
        ]);
        Permission::addPermission($request->name, $request->display_name, $request->description);

        return $this->redirector->to('admin/user/permissions');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return back();
    }
}