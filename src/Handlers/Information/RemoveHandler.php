<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 20:17
 */
namespace Notadd\Member\Handlers\Information;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\MemberInformation;

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
            if (MemberInformation::query()->where('id', $this->request->input('id'))->count()) {
                MemberInformation::query()->find($this->request->input('id'))->delete();
                $this->withCode(200)->withMessage('删除信息项成功！');
            } else {
                $this->withCode(500)->withError('删除信息项失败！');
            }
        }
    }
}
