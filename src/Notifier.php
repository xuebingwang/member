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

/**
 * Class Notifier.
 */
class Notifier
{
    public function notify($type, Member $sender, Member $toUser, $subject = null, $subjectType = null, $reply = null)
    {
        return Notification::notify($type, $sender, $toUser, $subject, $subjectType, $reply);
    }

    public function systemNotify($toUser, $body)
    {
        return Notification::create([
            'sender_id'    => 0,
            'user_id'      => $toUser,
            'subject_id'   => 0,
            'subject_type' => null,
            'body'         => $body,
            'reply_id'     => 0,
            'type'         => 'system',
        ]);
    }

    public function batchSystemNotify(array $users, $body)
    {
        $insert = [];
        foreach ($users as $user) {
            $insert[] = [
                'sender_id'    => 0,
                'user_id'      => $user,
                'subject_id'   => 0,
                'subject_type' => null,
                'body'         => $body,
                'reply_id'     => 0,
                'type'         => 'system',
            ];
        }

        Notification::insert($insert);
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
