<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-06 17:25
 */
namespace Notadd\Member\Handlers\Tag;

use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\MemberTagRelation;

/**
 * Class UserHandler.
 */
class UserHandler extends SetHandler
{
    public function execute()
    {
        if (!$this->request->has('id')) {
            $this->code = 500;
            $this->errors->push($this->translator->trans('参数缺失！'));

            return false;
        }
        $data = collect($this->request->input('tags'));
        $exists = MemberTagRelation::query()->where('member_id', $this->request->input('id'))->get();
        $exists->each(function (MemberTagRelation $relation) use ($data) {
            if ($key = $data->search($relation->getAttribute('id'))) {
                $data->offsetUnset($key);
            } else {
                $relation->delete();
            }
        });
        if ($data->count()) {
            $data->each(function ($tag) {
                MemberTagRelation::query()->create([
                    'member_id' => $this->request->input('id'),
                    'tag_id'    => $tag,
                ]);
            });
        }
        $this->messages->push($this->translator->trans('更新用户标签成功！'));

        return true;
    }
}
