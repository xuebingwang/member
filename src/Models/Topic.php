<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-02-07 17:03
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class Topic.
 */
class Topic extends Model
{
    protected $table = 'topics';

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'body_original',
        'last_reply_user_id',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(Member::class, 'user_id', 'id');
    }
}
