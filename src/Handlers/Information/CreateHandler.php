<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 18:10
 */
namespace Notadd\Member\Handlers\Information;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\MemberInformation;

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
            'name.required' => $this->translator->trans('必须填写信息项名称！'),
        ]);
        if (MemberInformation::query()->create($this->request->all())) {
            $this->withCode(200)->withMessage('创建信息项成功！');
        } else {
            $this->withCode(500)->withError('创建信息项失败！');
        }
    }
}
