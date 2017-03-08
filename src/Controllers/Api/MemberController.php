<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-03-08 12:00
 */

namespace Notadd\Member\Controllers\Api;

use Notadd\Member\Models\Member;
use Notadd\Member\Abstracts\AbstractApiController;

class MemberController extends AbstractApiController
{
    public function index()
    {
        $query = Member::query();

        $query->orderBy('created_at', 'desc');

        $lists = $query->paginate(intval($this->request->get('limit', 20)));

        return $this->respondWithPaginator($lists, function (Member $list) {
            return [
                'id'         => $list->id,
                'nick_name'  => $list->nick_name,
                'sex'        => sex_trans($list->sex),
                'age'        => $list->birth_date ? $list->birth_date->age : '',
                'avatar'     => $list->avatar,
                'points'     => $list->points,
                'group'      => $list->cachedGroups()->implode('display_name', '|'),
                'created_at' => $list->created_at->toDateTimeString(),
            ];
        });
    }

    public function show($member_id)
    {
        $member = Member::find(intval($member_id));

        if (! $member || ! $member->exists) {
            return $this->errorNotFound();
        }

        return $this->respondWithItem($member, function (Member $list) {
            return [
                'id'         => $list->id,
                'nick_name'  => $list->nick_name,
                'sex'        => sex_trans($list->sex),
                'age'        => $list->birth_date ? $list->birth_date->age : '',
                'avatar'     => $list->avatar,
                'points'     => $list->points,
                'group'      => $list->cachedGroups()->implode('display_name', '|'),
                'created_at' => $list->created_at->toDateTimeString(),
            ];
        });
    }
}
