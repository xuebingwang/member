<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-21 18:14
 */
namespace Notadd\Member\Handlers\Information;

use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\MemberInformation;

/**
 * Class EditHandler.
 */
class EditHandler extends SetHandler
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
            $this->code = 500;
            $this->errors->push($this->translator->trans('参数缺失！'));

            return false;
        }
        if (MemberInformation::query()->where('id', $this->request->input('id'))->count()) {
            MemberInformation::query()->find($this->request->input('id'))->update($this->request->all());
            $this->messages->push($this->translator->trans('更新信息项数据成功！'));

            return true;
        }
        $this->code = 500;
        $this->errors->push($this->translator->trans('信息项不存在！'));

        return false;
    }
}
