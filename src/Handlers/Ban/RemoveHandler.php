<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-02 11:32
 */
namespace Notadd\Member\Handlers\Ban;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\MemberBanIp;

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
            $builder = MemberBanIp::query();
            if ($builder->where('id', $this->request->input('id'))->count()) {
                $builder->find($this->request->input('id'))->delete();
                $this->withCode(200)->withMessage('删除封禁 IP 成功！');
            } else {
                $this->withCode(500)->withError('封禁 IP 不存在！');
            }
        }
    }
}
