<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-06 15:38
 */
namespace Notadd\Member\Handlers\Tag;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\MemberTag;

/**
 * Class PatchHandler.
 */
class PatchHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    public function execute()
    {
        $this->validate($this->request, [
            'tags' => 'required|array',
            'type' => 'required|in:combine,delete',
        ], [
            'tags.required' => '标签列表并不存在！',
            'tags.array'    => '标签列表必须是数组！',
            'type.required' => '操作类型不存在',
            'type.in'       => '操作类型不合法',
        ]);
        collect($this->request->input('tags'))->each(function ($id) {
            if (MemberTag::query()->where('id', $id)->count()) {
                switch ($this->request->input('type')) {
                    case 'combine':
                        break;
                    case 'delete':
                        MemberTag::query()->find($id)->delete();
                        break;
                }
            }
        });
        $this->withCode(200)->withMessage('批量更新标签数据成功！');
    }
}