<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 17:49
 */
namespace Notadd\Member\Handlers\Group;

use Illuminate\Container\Container;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\MemberGroup;

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
            'identification' => 'required|unique:member_groups,identification',
            'name'           => 'required',
        ], [
            'identification.required' => $this->translator->trans('必须填写用户组标识！'),
            'identification.unique'   => $this->translator->trans('用户标识必须唯一！'),
            'name.required'           => $this->translator->trans('必须填写用户组名称！'),
        ]);
        if (MemberGroup::query()->create($this->request->all())) {
            $this->withCode(200)->withMessage('创建用户组成功！');
        } else {
            $this->withCode(500)->withError('创建用户失败！');
        }
    }
}
