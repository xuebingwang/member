<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-06 17:25
 */
namespace Notadd\Member\Handlers\Tag;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\MemberTagRelation;

/**
 * Class UserHandler.
 */
class UserHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    public function execute()
    {
        if (!$this->request->has('id')) {
            $this->withCode(500)->withError('参数缺失！');
        } else {
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
            $this->withCode(200)->withMessage('更新用户标签成功！');
        }
    }
}
