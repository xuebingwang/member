<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-21 18:19
 */
namespace Notadd\Member\Handlers\Information;

use Notadd\Foundation\Passport\Abstracts\DataHandler;
use Notadd\Member\Models\MemberInformation;

/**
 * Class InformationHandler.
 */
class InformationHandler extends DataHandler
{
    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        if (!$this->request->has('id')) {
            $this->code = 500;
            $this->errors->push($this->translator->trans('参数缺失！'));

            return [];
        }
        if (MemberInformation::query()->where('id', $this->request->input('id'))->count()) {
            $this->messages->push($this->translator->trans('获取信息项成功！'));

            return MemberInformation::query()->find($this->request->input('id'));
        } else {
            $this->code = 500;
            $this->errors->push($this->translator->trans('获取信息项失败！'));

            return [];
        }
    }
}
