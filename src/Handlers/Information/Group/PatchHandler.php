<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-05 12:33
 */
namespace Notadd\Member\Handlers\Information\Group;

use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\MemberInformationGroup;

/**
 * Class PatchHandler.
 */
class PatchHandler extends SetHandler
{
    /**
     * Execute Handler.
     *
     * @return bool
     * @throws \Exception
     */
    public function execute()
    {
        if (!$this->request->has('data')) {
            $this->code = 500;
            $this->errors->push($this->translator->trans('参数缺失！'));

            return false;
        }
        collect((array)$this->request->input('data'))->each(function (array $attributes) {
            if (isset($attributes['id']) && MemberInformationGroup::query()->where('id', $attributes['id'])->count()) {
                MemberInformationGroup::query()->find($attributes['id'])->update($attributes);
            }
        });
        $this->messages->push($this->translator->trans('批量更新数据成功！'));

        return true;
    }
}
