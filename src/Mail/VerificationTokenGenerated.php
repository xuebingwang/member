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

    /**
     * @var string
     */
    public $subject;

    /**
     * @var string
     */
    public $from;

    /**
     * @var string
     */
    public $name;

    public function __construct(
        Authenticatable $user,
        $token,
        $subject = null,
        $from = null,
        $name = null
    )
    {
        $this->user    = $user;
        $this->from    = $from;
        $this->name    = $name;
        $this->token   = $token;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject(empty($this->subject) ? '邮箱激活' : $this->subject)
            ->view('member::email.user_email_verification');

        return $this;
    }
}
