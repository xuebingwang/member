<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-03-10 17:30
 */

namespace Notadd\Member\Controllers\Api;

use Notadd\Member\Models\ActionPoints;
use Notadd\Member\Abstracts\AbstractApiController;

class ActionPointsController extends AbstractApiController
{
    public function index()
    {
        $query = ActionPoints::query();

        $lists = $query->paginate($this->request->get('limit', 20));

        return $this->respondWithPaginator($lists, function (ActionPoints $list) {
            return [
                'id'           => $list->id,
                'name'         => $list->name,
                'display_name' => $list->display_name,
                'points'       => $list->points,
                'description'  => $list->description,
            ];
        });
    }
}
