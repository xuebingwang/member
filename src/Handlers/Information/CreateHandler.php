<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 18:10
 */
namespace Notadd\Member\Handlers\Information;

use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\MemberInformation;

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
            'name.required' => $this->translator->trans('必须填写信息项名称！'),
        ]);
        if (MemberInformation::query()->create($this->request->all())) {
            $this->messages->push($this->translator->trans('创建信息项成功！'));

            return true;
        }
        $this->errors->push($this->translator->trans('创建信息项失败！'));

        return false;
    }
}
