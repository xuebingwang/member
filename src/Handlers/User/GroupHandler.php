<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-27 18:07
 */
namespace Notadd\Member\Handlers\User;

use Carbon\Carbon;
use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\Group;
use Notadd\Member\Models\Member;
use Notadd\Member\Models\MemberGroup;

/**
 * Class GroupHandler.
 */
class GroupHandler extends SetHandler
{
    /**
     * @var \Notadd\Member\Models\Group
     */
    protected $group;

    /**
     * @var \Illuminate\Support\Collection
     */
    private $groups;

    /**
     * @var \Notadd\Member\Models\MemberGroup
     */
    protected $memberGroup;

    /**
     * GroupHandler constructor.
     *
     * @param \Illuminate\Container\Container   $container
     * @param \Notadd\Member\Models\Group       $group
     * @param \Notadd\Member\Models\Member      $member
     * @param \Notadd\Member\Models\MemberGroup $memberGroup
     */
    public function __construct(Container $container, Group $group, Member $member, MemberGroup $memberGroup)
    {
        parent::__construct($container);
        $this->group = $group;
        $this->groups = collect();
        $this->memberGroup = $memberGroup;
        $this->model = $member;
    }

    public function execute()
    {
        if (!$this->request->input('member_id', 0)) {
            $this->code = 500;
            $this->errors->push($this->translator->trans('参数缺失！'));

            return false;
        }
        if (Member::query()->where('id', $this->request->input('member_id'))->count() == 0) {
            $this->code = 500;
            $this->errors->push($this->translator->trans('用户不存在！'));

            return false;
        }
        collect($this->request->input('data'))->each(function ($data) {
            $data['end'] = Carbon::createFromTimestampUTC(strtotime($data['end']));

            if ($this->memberGroup
                ->newQuery()
                ->where('member_id', $data['member_id'])
                ->where('group_id', $data['group_id'])
                ->count()) {
                $group = $this->memberGroup
                    ->newQuery()
                    ->where('member_id', $data['member_id'])
                    ->where('group_id', $data['group_id'])
                    ->first();
                $group->update($data);
            } else {
                $this->memberGroup->newQuery()->create($data);
            }
        });
        $this->messages->push($this->translator->trans('更新用户用户组信息成功！'));

        return true;
    }
}
