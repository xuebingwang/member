<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 17:13
 */
namespace Notadd\Member\Handlers\User;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\Member;

/**
 * Class Create.
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
        if (Member::query()->create($this->request->all())) {
            $this->withCode(200)->withMessage('创建用户成功！');
        } else {
            $this->withCode(500)->withError('创建用户失败！');
        }
    }
}
