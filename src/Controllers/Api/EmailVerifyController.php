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
            return 'Not Found';
        }

        $this->emailVerification->findByEmail($member->email);
        // $this->emailVerification->
    }

    public function activeEmail()
    {

    }
}
