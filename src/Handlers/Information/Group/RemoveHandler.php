<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 19:17
 */
namespace Notadd\Member\Handlers\Information\Group;

use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\MemberInformationGroup;

/**
 * Class RemoveHandler.
 */
class RemoveHandler extends SetHandler
{
    /**
     * Execute Handler.
     *
     * @return bool
     * @throws \Exception
     */
    public function execute()
    {
        if (!$this->request->has('id')) {
            $this->errors->push($this->translator->trans('缺少参数！'));

            return false;
        }
        if (MemberInformationGroup::query()->where('id', $this->request->input('id'))->count()) {
            MemberInformationGroup::query()->find($this->request->input('id'))->delete();
            $this->messages->push($this->translator->trans('删除信息分组成功！'));

            return true;
        }
        $this->errors->push($this->translator->trans('删除信息分组失败！'));

        return false;
    }
}
