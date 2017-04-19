<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-04-19 10:04
 */

namespace Notadd\Member\Controllers\Api;

use Notadd\Member\Models\Member;
use Notadd\Member\EmailVerification;
use Notadd\Member\Abstracts\AbstractApiController;

class EmailVerifyController extends AbstractApiController
{
    protected $emailVerification;

    public function __construct(EmailVerification $emailVerification)
    {
        parent::__construct();

        $this->emailVerification = $emailVerification;
    }

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

    public function activeEmail()
    {

    }
}
