<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-05 12:33
 */
namespace Notadd\Member\Handlers\Information\Group;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\MemberInformationGroup;

/**
 * Class PatchHandler.
 */
class PatchHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    public function execute()
    {
        if (!$this->request->has('data')) {
            $this->withCode(500)->withError('参数缺失！');
        } else {
            collect((array)$this->request->input('data'))->each(function (array $attributes) {
                if (isset($attributes['id']) && MemberInformationGroup::query()->where('id', $attributes['id'])->count()) {
                    MemberInformationGroup::query()->find($attributes['id'])->update($attributes);
                }
            });
            $this->withCode(200)->withMessage('批量更新数据成功！');
        }
    }
}
