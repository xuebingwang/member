<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 19:02
 */
namespace Notadd\Member\Handlers\Information\Group;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\MemberInformationGroup;

/**
 * Class CreateHandler.
 */
class CreateHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    public function execute()
    {
        $this->validate($this->request, [
            'name' => 'required',
        ], [
            'name.required' => '必须填写分组名称！',
        ]);
        if (MemberInformationGroup::query()->create($this->request->all())) {
            $this->withCode(200)->withMessage('创建信息分组成功！');
        } else {
            $this->withCode(500)->withError('创建信息分组失败！');
        }
    }
}
