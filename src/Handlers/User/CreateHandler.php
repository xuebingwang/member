<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 17:13
 */
namespace Notadd\Member\Handlers\User;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\Member;

/**
 * Class Create.
 */
class CreateHandler extends SetHandler
{
    /**
     * Create constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Member\Models\Member    $member
     */
    public function __construct(Container $container, Member $member)
    {
        parent::__construct($container);
        $this->model = $member;
    }

    /**
     * @return bool
     */
    public function execute()
    {
        $this->validate($this->request, [
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required',
        ], [
            'email.required' => $this->translator->trans('必须填写电子邮箱账号！'),
            'email.email' => $this->translator->trans('请填写格式正确的电子邮箱账号！'),
            'name.required' => $this->translator->trans('必须填写用户名！'),
            'password.required' => $this->translator->trans('必须填写密码！'),
        ]);
        if (!$this->request->has('birthday')) {
            $this->request->offsetSet('birthday', null);
        }
        $this->request->offsetSet('password', bcrypt($this->request->input('password')));
        if ($this->model->newQuery()->create($this->request->all())) {
            $this->messages->push($this->translator->trans('创建用户成功！'));

            return true;
        }
        $this->errors->push($this->translator->trans('创建用户失败！'));

        return false;
    }
}
