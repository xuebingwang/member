<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 20:17
 */
namespace Notadd\Member\Handlers\Information;

use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\MemberInformation;

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
            $this->code = 500;
            $this->errors->push($this->translator->trans('参数缺失！'));

            return false;
        }
        if (MemberInformation::query()->where('id', $this->request->input('id'))->count()) {
            MemberInformation::query()->find($this->request->input('id'))->delete();
            $this->messages->push($this->translator->trans('删除信息项成功！'));

            return true;
        }
        $this->errors->push($this->translator->trans('删除信息项失败！'));

        return false;
    }
}
