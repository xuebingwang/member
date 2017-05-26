<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 18:19
 */
namespace Notadd\Member\Handlers\Information;

use Notadd\Foundation\Passport\Abstracts\Handler;
use Notadd\Member\Models\MemberInformation;

/**
 * Class InformationHandler.
 */
class InformationHandler extends Handler
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
            if (MemberInformation::query()->where('id', $this->request->input('id'))->count()) {
                $this->success()
                    ->withData(MemberInformation::query()->find($this->request->input('id')))
                    ->withMessage('获取信息项成功！');
            } else {
                $this->withCode(500)->withError('获取信息项失败！');
            }
        }
    }
}
