<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-27 13:41
 */
namespace Notadd\Member\Handlers\User;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\Member;
use Notadd\Member\Models\MemberBan;

/**
 * Class BanHandler.
 */
class BanHandler extends Handler
{
    public function configurations()
    {
        if ($this->request->input('time', 0) == 5) {
            $this->request->input('end', '') || $this->request->offsetSet('time', 0);
        }
        $this->request->input('end', '') || $this->request->offsetSet('end', null);
        $this->request->offsetSet('member_id', $this->request->input('id'));
        $this->request->offsetUnset('id');
    }

    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    public function execute()
    {
        $this->configurations();
        if (!$this->request->input('member_id', 0)) {
            $this->withCode(500)->withMessage('参数缺失！');
        } else {
            if (Member::query()->where('id', $this->request->input('member_id'))->count() == 0) {
                $this->withCode(500)->withMessage('用户不存在！');
            } else {
                if (MemberBan::query()->where('member_id', $this->request->input('member_id'))->count()) {
                    $ban = MemberBan::query()->where('member_id', $this->request->input('member_id'))->first();
                    $ban->update($this->request->all());
                } else {
                    MemberBan::query()->create($this->request->all());
                }
                $this->withCode(200)->withMessage('更新用户封禁状态成功！');
            }
        }
    }
}
