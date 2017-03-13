<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-02-09 12:01
 */
namespace Notadd\Member\Events;

use Notadd\Member\Models\Member;

/**
 * Class CheckIn.
 */
class CheckIn
{
    public $user;

    public function __construct(Member $user)
    {
        $this->user = $user;
    }
}
