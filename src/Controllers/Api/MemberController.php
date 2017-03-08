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

        $lists = $query->paginate(20);

        return $this->respondWithPaginator($lists, function (Member $list) {
            return [
                'nick_name'  => $list->nick_name,
                'sex'        => $list->sex,
                'avatar'     => $list->avatar,
                'points'     => $list->points,
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

        return $this->respondWithPaginator($member, function (Member $list) {
            return [
                'nick_name'  => $list->nick_name,
                'sex'        => $list->sex,
                'avatar'     => $list->avatar,
                'points'     => $list->points,
                'created_at' => $list->created_at->toDateTimeString(),
            ];
        });
    }
}
