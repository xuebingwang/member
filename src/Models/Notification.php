<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-02-07 15:19
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class Notification.
 *
 * @property integer             $id
 * @property integer             $sender
 * @property integer             $user_id
 * @property integer             $subject_id
 * @property string              $subject_type
 * @property integer             $reply_id
 * @property string              $body
 * @property string              $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $read_at
 */
class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'sender_id',
        'user_id',
        'subject_id',
        'subject_type',
        'reply_id',
        'body',
        'type',
    ];

    protected $dates = ['read_at'];

    /**
     * 发送人
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(Member::class, 'sender_id', 'id');
    }

    /**
     * 接收人
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Member::class, 'user_id', 'id');
    }

    public static function notify(
        $type,
        Member $sender,
        Member $toUser,
        $subject = null,
        $subjectType = null,
        $reply = null
    ) {
        if ($sender->id == $toUser->id) {
            return;
        }

        return static::create([
            'sender_id'    => $sender->id,
            'user_id'      => $toUser->id,
            'subject_id'   => $subject ? $subject->id : 0,
            'subject_type' => $subjectType,
            'reply_id'     => $reply ? $reply->id : 0,
            'body'         => $reply ? $reply->body : '',
            'type'         => $type,
        ]);
    }

    public function labelUp()
    {
        $label = '';
        switch ($this->type) {
            case 'new_reply':
                $label = '回复了你的话题:';
                if ($this->subject_type == 'article') {
                    $label = '回复了你的文章:';
                }
                break;
        }

        return $label;
    }

    /**
     * 标记为已读
     *
     * @return $this
     */
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->forceFill(['read_at' => $this->freshTimestamp()])->save();
        }

        return $this;
    }
}
