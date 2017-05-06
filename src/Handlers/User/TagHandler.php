<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-06 16:43
 */
namespace Notadd\Member\Handlers\User;

use Notadd\Foundation\Passport\Abstracts\DataHandler;
use Notadd\Member\Models\MemberTagRelation;

/**
 * Class TagHandler.
 */
class TagHandler extends DataHandler
{
    public function data()
    {
        if (!$this->request->has('id')) {
            $this->code = 500;
            $this->errors->push($this->translator->trans('参数缺失！'));

            return false;
        }

        return MemberTagRelation::query()->where('member_id', $this->request->input('id'))->get();
    }
}
