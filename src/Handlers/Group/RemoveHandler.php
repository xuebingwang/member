<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-26 17:15
 */
namespace Notadd\Member\Handlers\Group;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\MemberGroup;

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
        $group = MemberGroup::query()->find($this->request->input('id'));
        if ($group && $group->delete()) {
            $this->withCode(200)->withMessage('删除用户组成功！');
        } else {
            $this->withCode(500)->withError('删除用户组失败！');
        }
    }
}
