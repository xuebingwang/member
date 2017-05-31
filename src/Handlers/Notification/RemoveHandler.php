<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-08 18:14
 */
namespace Notadd\Member\Handlers\Notification;

use Illuminate\Notifications\DatabaseNotification;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class RemoveHandler.
 */
class RemoveHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    public function execute()
    {
        if (!$this->request->has('id')) {
            $this->withCode(500)->withError('参数缺失！');
        } else {
            if (DatabaseNotification::query()->where('id', $this->request->input('id'))->count()) {
                DatabaseNotification::query()->find($this->request->input('id'))->delete();
                $this->withCode(200)->withMessage('删除通知消息成功！');
            } else {
                $this->withCode(500)->withError('通知消息不存在！');
            }
        }
    }
}
