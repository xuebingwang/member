<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-03-08 12:00
 */

namespace Notadd\Member\Controllers\Api;

use Notadd\Member\Models\Group;
use Notadd\Member\Models\Member;
use Notadd\Member\Models\Permission;
use Notadd\Member\Abstracts\AbstractApiController;

/**
 * Class MemberController.
 */
class MemberController extends AbstractApiController
{
    protected $form_rules = [
        'name'     => 'required|unique:members,name',
        'email'    => 'required|unique:members,email',
        'birthday' => 'nullable|date',
    ];

    protected $form_messages = [
        'name.required'  => '请输入用户名.',
        'name.unique'    => '用户名已经存在.',
        'email.required' => '请输入邮箱.',
        'email.unique'   => '邮箱已经存在.',
        'birthday.date'  => '无效的出生日期.',
    ];

    protected function filterFormRules($member = null)
    {
        $rules = $this->form_rules;

        if ($member && $member->exists) {
            $rules['name']  .= ',' . $member->id;
            $rules['email'] .= ',' . $member->id;
        }

        return $rules;
    }

    public function index()
    {
        $query = Member::query()->with('groups');
        $query->orderBy('created_at', 'desc');
        $lists = $query->paginate(intval($this->request->get('limit', 20)));

        return $this->respondWithPaginator($lists, function (Member $list) {
            return [
                'id'           => $list->id,
                'name'         => $list->name,
                'email'        => $list->email,
                'phone'        => $list->phone,
                'nick_name'    => $list->nick_name,
                'real_name'    => $list->real_name,
                'sex'          => sex_trans($list->sex),
                'age'          => $list->birthday ? $list->birthday->age : '',
                'avatar'       => $list->avatar,
                'points'       => $list->points,
                'signature'    => $list->signature,
                'introduction' => $list->introduction,
                'group'        => $list->groups ? $list->groups->implode('display_name', '|') : '',
                'created_at'   => $list->created_at->toDateTimeString(),
            ];
        });
    }

    public function create()
    {
        $validator = $this->getValidationFactory()->make(
            $this->request->all(),
            $this->filterFormRules(),
            $this->form_messages
        );

        if ($validator->fails()) {
            return $this->errorValidate($validator->getMessageBag()->toArray());
        }

        $member = new Member(array_only($this->request->all(), [
            'name',
            'email',
            'phone',
            'birthday',
            'sex',
            'signature',
            'introduction',
            'nick_name',
            'real_name',
        ]));

        if (! $member->save()) {
            return $this->errorInternal();
        }

        $groups = Group::whereIn('id', $this->request->input('groups', []))
            ->get()
            ->pluck('id')
            ->toArray();

        $permissions = Permission::whereIn('id', $this->request->input('permissions', []))
            ->get()
            ->pluck('id')
            ->toArray();

        // 给用户添加用户组
        $member->groups()->sync($groups);
        $member->permissions()->sync($permissions);

        return $this->noContent();
    }

    public function show($member_id)
    {
        $member = Member::find(intval($member_id));
        if (! $member || ! $member->exists) {
            return $this->errorNotFound();
        }

        return $this->respondWithItem($member, function (Member $list) {
            return [
                'id'           => $list->id,
                'name'         => $list->name,
                'email'        => $list->email,
                'phone'        => $list->phone,
                'nick_name'    => $list->nick_name,
                'real_name'    => $list->real_name,
                'sex'          => sex_trans($list->sex),
                'age'          => $list->birthday ? $list->birthday->age : '',
                'birthday'     => $list->birthday ? $list->birthday->toDateString() : '',
                'avatar'       => $list->avatar,
                'points'       => $list->points,
                'signature'    => $list->signature,
                'introduction' => $list->introduction,
                'group'        => $list->cachedGroups()->implode('display_name', '|'),
                'created_at'   => $list->created_at->toDateTimeString(),
            ];
        });
    }

    public function update($member_id)
    {
        $member = Member::find(intval($member_id));
        if (! $member || ! $member->exists) {
            return $this->errorNotFound();
        }

        $validator = $this->getValidationFactory()->make(
            $this->request->all(),
            $this->filterFormRules($member),
            $this->form_messages
        );

        if ($validator->fails()) {
            return $this->errorValidate($validator->getMessageBag()->toArray());
        }

        $member->fill(array_only($this->request->all(), [
            'name',
            'email',
            'phone',
            'birthday',
            'sex',
            'signature',
            'introduction',
            'nick_name',
            'real_name',
        ]));

        if (! $member->save()) {
            return $this->errorInternal();
        }

        $groups = Group::whereIn('id', $this->request->input('groups', []))
            ->get()
            ->pluck('id')
            ->toArray();

        $permissions = Permission::whereIn('id', $this->request->input('permissions', []))
            ->get()
            ->pluck('id')
            ->toArray();

        // 给用户添加用户组
        $member->groups()->sync($groups);
        $member->permissions()->sync($permissions);

        return $this->noContent();
    }

    public function destroy($id)
    {
        $member = Member::find($id);
        if (! $member || ! $member->exists) {
            return $this->errorNotFound();
        }

        if (! $member->delete()) {
            return $this->errorInternal();
        }

        return $this->noContent();
    }
}
