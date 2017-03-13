<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-03-12 11:27
 */
namespace Notadd\Member\Controllers\Api;

use Notadd\Member\Models\Notification;
use Notadd\Member\Abstracts\AbstractApiController;

/**
 * Class NotificationController.
 */
class NotificationController extends AbstractApiController
{
    public function index()
    {
        $query = Notification::query()->with('seeder')->with('user');
        $lists = $query->paginate($this->request->get('limit', 20));

        return $this->respondWithPaginator($lists, function (Notification $list) {
            return [
                'seeder'  => $list->sender ? $list->sender->name : '',
                'user'    => $list->user ? $list->user->name : '',
                'type'    => $list->labelUp(),
                'body'    => $list->body,
                'read_at' => $list->read_at ? $list->read_at->toDateTimeString() : '',
            ];
        });
    }
}
