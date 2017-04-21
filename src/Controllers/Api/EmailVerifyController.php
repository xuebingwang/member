<?php
/**
 * This file is part of Notadd.
 *
 * @author Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-19 10:04
 */
namespace Notadd\Member\Controllers\Api;

use Notadd\Member\Models\Member;
use Notadd\Member\EmailVerification;
use Notadd\Member\Abstracts\AbstractApiController;

/**
 * Class EmailVerifyController.
 */
class EmailVerifyController extends AbstractApiController
{
    /**
     * @var \Notadd\Member\EmailVerification
     */
    protected $emailVerification;

    /**
     * EmailVerifyController constructor.
     *
     * @param \Notadd\Member\EmailVerification $emailVerification
     */
    public function __construct(EmailVerification $emailVerification)
    {
        parent::__construct();

        $this->emailVerification = $emailVerification;
    }

    /**
     * @param $email
     *
     * @return array|mixed
     */
    public function sendEmailVerify($email)
    {
        $member = Member::findByEmail($email);
        if (! $member || ! $member->exists) {
            return $this->errorNotFound();
        }

        $this->emailVerification->generate($member);

        $this->emailVerification->send($member);

        return $this->respondWithSuccess('激活邮件已发送');
    }

    /**
     * @param $token
     *
     * @return mixed
     */
    public function activeEmail($token)
    {
        $email = $this->request->get('email', '');

        try {
            $this->emailVerification->process($email, $token);
        } catch (\Exception $e) {
            return $this->errorValidate([
                'token' => '邮件激活验证失败',
            ]);
        }

        return $this->respondWithSuccess('激活成功');
    }
}
