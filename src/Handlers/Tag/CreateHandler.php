<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 18:22
 */
namespace Notadd\Member\Handlers\Tag;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\MemberTag;

/**
 * Class CreateHandler.
 */
class CreateHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    public function execute()
    {
        $this->validate($this->request, [
            'tag' => 'required',
        ], [
            'tag.required' => $this->translator->trans('必须填写标签名称！'),
        ]);
        $created = new Collection();
        $tags = new Collection();
        if (Str::contains($this->request->input('tag'), ',')) {
            foreach (explode(',', $this->request->input('tag')) as $tag) {
                $tags->push($tag);
            }
        } else {
            $tags->push($this->request->input('tag'));
        }
        $tags->each(function (string $tag) use ($created) {
            if (MemberTag::query()->where('tag', $tag)->count()) {
                $created->push(MemberTag::query()->where('tag', $tag)->first());
            } else {
                $created->push(MemberTag::query()->create([
                    'tag' => $tag,
                ]));
            }
        });
        if ($users = $this->request->input('users')) {
            $users = explode(PHP_EOL, $users);
        }
        $this->withCode(200)->withMessage('创建用户标签成功！');
    }
}
