<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-04 19:02
 */
namespace Notadd\Member\Handlers\Information\Group;

use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\MemberInformationGroup;

/**
 * Class CreateHandler.
 */
class CreateHandler extends SetHandler
{
    /**
     * Execute Handler.
     *
     * @return bool
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
            $this->messages->push($this->translator->trans('创建信息分组成功！'));

            return true;
        }
        $this->errors->push($this->translator->trans('创建信息分组失败！'));

        return false;
    }
}
