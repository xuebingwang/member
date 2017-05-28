<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-06 16:43
 */
namespace Notadd\Member\Handlers\User;

use Notadd\Foundation\Passport\Abstracts\Handler;
use Notadd\Member\Models\MemberTagRelation;

/**
 * Class TagHandler.
 */
class TagHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        if (!$this->request->has('id')) {
            $this->withCode(500)->withError('参数缺失！');
        } else {
            $this->success()
                ->withData(MemberTagRelation::query()->where('member_id', $this->request->input('id'))->get())
                ->withMessage('');
        }
    }
}
