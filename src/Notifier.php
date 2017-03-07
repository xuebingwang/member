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

class Notifier
{
    public function notify($type, Member $sender, Member $toUser, $subject = null, $subjectType = null, $reply = null)
    {
        if ($sender->id == $toUser->id) {
            return;
        }

        return Member::create([
            'sender_id'    => $sender->id,
            'user_id'      => $toUser->id,
            'subject_id'   => $subject ? $subject->id : 0,
            'subject_type' => $subjectType,
            'reply_id'     => $reply ? $reply->id : 0,
            'body'         => $reply ? $reply->body : '',
            'type'         => $type,
        ]);
    }
}
