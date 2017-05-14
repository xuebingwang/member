<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-08 18:14
 */
namespace Notadd\Member\Handlers\Notification;

use Illuminate\Notifications\DatabaseNotification;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class RemoveHandler.
 */
class RemoveHandler extends SetHandler
{
    /**
     * Execute Handler.
     *
     * @return bool
     * @throws \Exception
     */
    public function execute()
    {
        if (!$this->request->has('id')) {
            $this->code = 500;
            $this->errors->push($this->translator->trans('参数缺失！'));

            return false;
        }
        if (DatabaseNotification::query()->where('id', $this->request->input('id'))->count()) {
            DatabaseNotification::query()->find($this->request->input('id'))->delete();
            $this->messages->push($this->translator->trans('删除通知消息成功！'));

            return true;
        } else {
            $this->code = 500;
            $this->errors->push($this->translator->trans('通知消息不存在！'));

            return false;
        }
    }
}
