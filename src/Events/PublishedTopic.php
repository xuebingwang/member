<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-02-09 11:19
 */
namespace Notadd\Member\Events;

use Notadd\Member\Models\Topic;
use Notadd\Member\Models\Member;

/**
 * Class PublishedTopic.
 */
class PublishedTopic
{
    public $user;

    public $topic;

    public function __construct(Member $user, Topic $topic)
    {
        $this->user = $user;
        $this->topic = $topic;
    }
}
