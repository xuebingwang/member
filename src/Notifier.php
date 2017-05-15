<?php
/**
 * This file is part of Notadd.
 *
 * @author Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-07 14:40
 */
namespace Notadd\Member;

use Notadd\Member\Models\Member;
use Notadd\Member\Models\Notification;

/**
 * Class Notifier.
 */
class Notifier
{
    /**
     * @param                              $type
     * @param \Notadd\Member\Models\Member $sender
     * @param \Notadd\Member\Models\Member $toUser
     * @param null                         $subject
     * @param null                         $subjectType
     * @param null                         $reply
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function notify($type, Member $sender, Member $toUser, $subject = null, $subjectType = null, $reply = null)
    {
        return Notification::notify($type, $sender, $toUser, $subject, $subjectType, $reply);
    }

    /**
     * @param $toUser
     * @param $body
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function systemNotify($toUser, $body)
    {
        return Notification::query()->create([
            'sender_id'    => 0,
            'user_id'      => $toUser,
            'subject_id'   => 0,
            'subject_type' => null,
            'body'         => $body,
            'reply_id'     => 0,
            'type'         => 'system',
        ]);
    }

    /**
     * @param array $users
     * @param       $body
     */
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

        Notification::query()->insert($insert);
    }

    /**
     * @param \Notadd\Member\Models\Member $sender
     * @param \Notadd\Member\Models\Member $toUser
     * @param null                         $subject
     * @param null                         $subjectType
     * @param null                         $reply
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function atNotify(Member $sender, Member $toUser, $subject = null, $subjectType = null, $reply = null)
    {
        return $this->notify('at', $sender, $toUser, $subject, $subjectType, $reply);
    }

    /**
     * @param \Notadd\Member\Models\Member $sender
     * @param \Notadd\Member\Models\Member $toUser
     * @param null                         $subject
     * @param null                         $subjectType
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function likeNotify(Member $sender, Member $toUser, $subject = null, $subjectType = null)
    {
        return $this->notify('like', $sender, $toUser, $subject, $subjectType);
    }

    /**
     * @param \Notadd\Member\Models\Member $sender
     * @param \Notadd\Member\Models\Member $toUser
     * @param null                         $subject
     * @param null                         $subjectType
     * @param null                         $reply
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function newReplyNotify(Member $sender, Member $toUser, $subject = null, $subjectType = null, $reply = null)
    {
        return $this->notify('new_reply', $sender, $toUser, $subject, $subjectType, $reply);
    }
}
