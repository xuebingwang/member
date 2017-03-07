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
}
