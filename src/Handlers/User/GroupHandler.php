<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-27 18:07
 */
namespace Notadd\Member\Handlers\User;

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
        $this->memberGroup = $memberGroup;
        $this->model = $member;
    }

    public function configurations()
    {
        $groups = collect();
        collect($this->request->input('groups', []))->each(function ($item) use ($groups) {
            if ($item['check']) {
                $groups->push([
                    'end'   => $item['end'],
                    'group' => $item['id'],
                ]);
            }
        });
        $this->request->offsetSet('end', $this->request->input('date'));
        $this->request->offsetSet('extends', $groups->toJson());
        $this->request->offsetSet('group_id', $this->request->input('group'));
        $this->request->offsetSet('member_id', $this->request->input('id'));
    }

    public function execute()
    {
        $this->configurations();
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
        if ($this->memberGroup->newQuery()->where('member_id', $this->request->input('member_id'))->count()) {
            $group = $this->memberGroup->newQuery()->where('member_id', $this->request->input('member_id'))->first();
            $group->update($this->request->all());
        } else {
            $this->memberGroup->newQuery()->create($this->request->all());
        }
        $this->messages->push($this->translator->trans('更新用户用户组信息成功！'));

        return true;
    }
}
