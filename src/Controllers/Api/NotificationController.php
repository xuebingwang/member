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
                'seeder'  => $list->sender ? $list->sender->name : '系统通知',
                'user'    => $list->user ? $list->user->name : '',
                'label'   => $list->labelUp(),
                'body'    => $list->body,
                'read_at' => $list->read_at ? $list->read_at->toDateTimeString() : '',
            ];
        });
    }

    /**
     * Notify a person
     *
     * @return array|mixed
     */
    public function systemNotify()
    {
        $validator = $this->getValidationFactory()->make(
            [
                'user_id' => 'required',
                'body'    => 'required',
            ],
            [
                'user_id.required' => '通知人不能为空.',
                'body.required'    => '通知内容不能为空.',
            ]
        );

        if ($validator->fails()) {
            return $this->errorValidate($validator->getMessageBag()->toArray());
        }

        $notify = $this->getContainer()->make('notifier')->systemNotify(
            $this->request->input('user_id'),
            $this->request->input('body')
        );

        if (! $notify || ! $notify->exists) {
            return $this->errorInternal();
        }

        return $this->noContent();
    }

    /**
     * Notify some people
     *
     * @return array|mixed
     */
    public function batchSystemNotify()
    {
        $validator = $this->getValidationFactory()->make(
            [
                'user_ids' => 'required|array',
                'body'     => 'required',
            ],
            [
                'user_ids.required' => '通知人不能为空.',
                'user_ids.array'    => '通知人不能为空.',
                'body.required'     => '通知内容不能为空.',
            ]
        );

        if ($validator->fails()) {
            return $this->errorValidate($validator->getMessageBag()->toArray());
        }

        $notify = $this->getContainer()->make('notifier')->batchSystemNotify(
            $this->request->input('user_ids'),
            $this->request->input('body')
        );

        if (! $notify || ! $notify->exists) {
            return $this->errorInternal();
        }

        return $this->noContent();
    }
}
