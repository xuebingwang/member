<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 18:14
 */
namespace Notadd\Member\Handlers\Information;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\MemberInformation;

/**
 * Class EditHandler.
 */
class EditHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    public function execute()
    {
        $this->validate($this->request, [
            'id'   => 'required',
            'name' => 'required',
        ], [
            'id.required'   => $this->translator->trans('参数缺失！'),
            'name.required' => $this->translator->trans('必须填写信息项名称！'),
        ]);
        if (MemberInformation::query()->where('id', $this->request->input('id'))->count()) {
            MemberInformation::query()->find($this->request->input('id'))->update($this->request->all());
            $this->withCode(200)->withMessage('更新信息项数据成功！');
        } else {
            $this->withCode(500)->withError('信息项不存在！');
        }
    }
}
