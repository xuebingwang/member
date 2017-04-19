<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-04-19 10:04
 */

namespace Notadd\Member\Controllers\Api;

use Notadd\Member\Abstracts\AbstractApiController;
use Notadd\Member\EmailVerification;
use Notadd\Member\Models\Member;

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
    }

    public function activeEmail()
    {

    }
}
