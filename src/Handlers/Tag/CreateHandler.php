<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-21 18:22
 */
namespace Notadd\Member\Handlers\Tag;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\MemberTag;

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
            'tag' => 'required',
        ], [
            'tag.required' => $this->translator->trans('必须填写标签名称！'),
        ]);
        $created = new Collection();
        if (Str::contains(',', $this->request->input('tag'))) {
            $tags = explode(',', $this->request->input('tag'));
            foreach ($tags as $tag) {
                $created->push(MemberTag::query()->create([
                    'tag' => $tag,
                ]));
            }
        } else {
            $created->push(MemberTag::query()->create([
                'tag' => $this->request->input('tag'),
            ]));
        }
        if ($list = $this->request->input('list')) {
            $list = explode(PHP_EOL, $list);
        }

        $this->messages->push($this->translator->trans('创建用户标签成功！'));

        return true;
    }
}
