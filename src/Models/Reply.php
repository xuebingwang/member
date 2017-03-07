<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-02-07 17:04
 */

namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;

class Reply extends Model
{
    protected $table = 'replies';

    protected $fillable = [
        'user_id', 'topic_id', 'body', 'body_original',
    ];
}
