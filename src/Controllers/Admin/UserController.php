<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime      2016-08-02 16:42
 */
namespace Notadd\Member\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Notadd\Member\Models\Group;
use Notadd\Member\Models\Member;
use Illuminate\Support\Facades\DB;
use Notadd\Member\Models\Permission;
use Notadd\Member\Abstracts\AbstractAdminController;

/**
 * Class UserController
 *
 * @package App\Admin\Controllers
 */
class UserController extends AbstractAdminController
{
    protected $indexRoute = 'admin/user';

    public function index()
    {
        // \Auth::loginUsingId(1, true);

        // $user = $this->request->user();
        // dd($user, $user->hasAdminPermission('admin*'), $user->hasPermission('create-user'));

        $query = Member::query();

        if ($name = $this->request->offsetGet('name')) {
            $query->where('name', 'like', "%{$name}%");
        }

        if ($email = $this->request->offsetGet('email')) {
            $query->where('email', 'like', "%{$email}%");
        }

        $query->orderBy('created_at', 'desc');

        $lists = $query->paginate(20);

        $this->share('lists', $lists);
        $this->share('name', $name);
        $this->share('email', $email);

        return $this->view('user.user.index');
    }

    public function create()
    {
        $user = new Member();

        $groups = Group::all()->toArray();
        $permissions = Permission::all();

        return $this->view('user.user.create', compact('user', 'groups', 'permissions'));
    }

    public function store(Request $request)
    {
        $user        = new Member($request->except('password'));
        $user->email = $request->get('email') ?: $user->name;
        $user->phone = $user->name;

        if ($request->offsetGet('password')) {
            $user->setPassword($request->offsetGet('password'));
        }
        $user->save();

        $groups = Group::whereIn('id', $request->input('groups', []))
            ->get()
            ->pluck('id')
            ->toArray();

        $permissions = Permission::whereIn('id', $this->request->input('permissions', []))
            ->get()
            ->pluck('id')
            ->toArray();

        // 给用户添加用户组
        $user->groups()->sync($groups);
        $user->permissions()->sync($permissions);

        return redirect('admin/user/users');
    }

    public function edit($id)
    {
        $user = Member::findOrFail($id);

        $groups = Group::all()->toArray();
        $permissions = Permission::all();

        return $this->view('user.user.update', compact('user', 'groups', 'permissions'));
    }

    public function update(Request $request, $id = null)
    {
        $user = Member::findOrFail($id);

        $user->fill($request->except('password'));
        if ($request->offsetGet('password')) {
            $user->setPassword($request->offsetGet('password'));
        }
        $user->save();

        $groups = Group::whereIn('id', $request->input('groups', []))
            ->get()
            ->pluck('id')
            ->toArray();

        $permissions = Permission::whereIn('id', $this->request->input('permissions', []))
            ->get()
            ->pluck('id')
            ->toArray();

        // 给用户添加用户组
        $user->groups()->sync($groups);
        $user->permissions()->sync($permissions);

        return redirect('admin/user/users');
    }

    public function destroy($id)
    {
        $user = Member::findOrFail($id);
        if (! $user->delete()) {
            return redirect()->to($this->indexRoute)->withErrors("删除失败.");
        }

        return redirect()->to($this->indexRoute)->withMessages("删除成功.");
    }

    public function statistics()
    {
        $query = Member::query();

        $query->select(DB::raw('COUNT(*) as member_count'));

        if ($startOfDay = request()->get('day_start')) {
            $query->where('created_at', '>=', Carbon::parse($startOfDay)->startOfDay());
        }

        if ($endOfDay = request()->get('day_end')) {
            $query->where('created_at', '<=', Carbon::parse($endOfDay)->endOfDay());
        }

        if ($startOfMonth = request()->get('month_start')) {
            $query->where('created_at', '>=', Carbon::parse($startOfMonth)->startOfMonth());
        }

        if ($endOfMonth = request()->get('month_end')) {
            $query->where('created_at', '<=', Carbon::parse($endOfMonth)->endOfMonth());
        }

        $memberCount = $query
            ->first()
            ->member_count ?: 0;

        return $memberCount;
    }
}
 