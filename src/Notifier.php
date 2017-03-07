<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-03-07 14:40
 */

namespace Notadd\Member;

use Notadd\Member\Models\Member;
use Notadd\Member\Models\Notification;

class Notifier
{
    public function notify($type, Member $sender, Member $toUser, $subject = null, $subjectType = null, $reply = null)
    {
        return Notification::notify($type, $sender, $toUser, $subject, $subjectType, $reply);
    }

    public function atNotify(Member $sender, Member $toUser, $subject = null, $subjectType = null, $reply = null)
    {
        return $this->notify('at', $sender, $toUser, $subject, $subjectType, $reply);
    }

    public function likeNotify(Member $sender, Member $toUser, $subject = null, $subjectType = null)
    {
        return $this->notify('like', $sender, $toUser, $subject, $subjectType);
    }

    public function newReplyNotify(Member $sender, Member $toUser, $subject = null, $subjectType = null, $reply = null)
    {
        return $this->notify('new_reply', $sender, $toUser, $subject, $subjectType, $reply);
    }
}
