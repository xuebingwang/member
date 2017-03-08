<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-03-08 12:00
 */

namespace Notadd\Member\Controllers\Api;

use Closure;
use Notadd\Member\Models\Member;
use Illuminate\Http\JsonResponse;

class MemberController
{
    public function index()
    {
        $query = Member::query();

        $lists = $query->paginate(20);

        return $this->responseWithPaginate($lists, function (Member $list) {
            return [
                'nick_name'  => $list->nick_name,
                'sex'        => $list->sex,
                'avatar'     => $list->avatar,
                'points'     => $list->points,
                'created_at' => $list->created_at->toDateTimeString(),
            ];
        });
    }

    protected function responseWithArray($data, $code = 200, $message = 'ok')
    {
        return new JsonResponse([
            'code'    => 200,
            'message' => 'ok',
            'data'    => $data,
        ], $code);
    }

    public function responseWithPaginate($data, Closure $handle)
    {
        $results = array_only($data->toArray(), ['total', 'per_page', 'current_page', 'last_page', 'next_page_url', 'prev_page_url', 'from', 'to']) + ['data' => []];
        foreach ($data as $list) {
            $results['data'][] = $handle($list);
        }

        return $this->responseWithArray($results);
    }
}
