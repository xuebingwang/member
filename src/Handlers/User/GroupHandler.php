<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-27 18:07
 */
namespace Notadd\Member\Handlers\User;

use Carbon\Carbon;
use Illuminate\Container\Container;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\Member;
use Notadd\Member\Models\MemberGroupRelation;

/**
 * Class GroupHandler.
 */
class GroupHandler extends Handler
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $exits;

    /**
     * @var \Notadd\Member\Models\MemberGroup
     */
    protected $group;

    /**
     * @var \Illuminate\Support\Collection
     */
    private $groups;

    /**
     * @var \Notadd\Member\Models\MemberGroupRelation
     */
    protected $memberGroup;

    /**
     * GroupHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->groups = collect();
    }

    public function execute()
    {
        if (!$this->request->input('member_id', 0)) {
            $this->withCode(500)->withError('参数缺失！');
        } else {
            if (Member::query()->where('id', $this->request->input('member_id'))->count() == 0) {
                $this->withCode(500)->withError('用户不存在！');
            } else {
                $this->exits = MemberGroupRelation::query()->where('member_id', $this->request->input('member_id'))->get();
                collect($this->request->input('data'))->each(function ($data) {
                    $has = $this->exits->where('group_id', '=', $data['group_id']);
                    if ($has->count()) {
                        $this->exits = $this->exits->diff($has);
                    }
                    $data['end'] = Carbon::createFromTimestampUTC(strtotime($data['end']));

                    if (MemberGroupRelation::query()
                        ->where('member_id', $data['member_id'])
                        ->where('group_id', $data['group_id'])
                        ->count()) {
                        $group = MemberGroupRelation::query()
                            ->where('member_id', $data['member_id'])
                            ->where('group_id', $data['group_id'])
                            ->first();
                        $group->update($data);
                    } else {
                        MemberGroupRelation::query()->create($data);
                    }
                });
                $this->exits->each(function (MemberGroupRelation $group) {
                    $group->delete();
                });
                $this->withCode(200)->withMessage('更新用户用户组信息成功！');
            }
        }
    }
}
