<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-04-19 14:07
 */

namespace Notadd\Member\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Auth\Authenticatable;

class VerificationTokenGenerated extends Mailable
{
    /**
     * Member instance
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * @var string
     */
    public $token;

    public function __construct(Authenticatable $user, $token)
    {
        $this->user  = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('邮箱激活')
            ->view('member::user_email_verification');

        return $this;
    }
}
