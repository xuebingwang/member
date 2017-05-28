<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-27 13:41
 */
namespace Notadd\Member\Handlers\User;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\Member;
use Notadd\Member\Models\MemberBan;

/**
 * Class BanHandler.
 */
class BanHandler extends SetHandler
{
    /**
     * BanHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Member\Models\MemberBan $ban
     */
    public function __construct(Container $container, MemberBan $ban)
    {
        parent::__construct($container);
        $this->model = $ban;
    }

    public function configurations()
    {
        if ($this->request->input('time', 0) == 5) {
            $this->request->input('end', '') || $this->request->offsetSet('time', 0);
        }
        $this->request->input('end', '') || $this->request->offsetSet('end', null);
        $this->request->offsetSet('member_id', $this->request->input('id'));
        $this->request->offsetUnset('id');
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
            $this->errors->push($this->translator->trans('用户不存在！'));

            return false;
        }
        if ($this->model->newQuery()->where('member_id', $this->request->input('member_id'))->count()) {
            $ban = $this->model->newQuery()->where('member_id', $this->request->input('member_id'))->first();
            $ban->update($this->request->all());
        } else {
            $this->model->newQuery()->create($this->request->all());
        }
        $this->messages->push($this->translator->trans('更新用户封禁状态成功！'));

        return true;
    }
}
