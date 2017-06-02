<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-06-01 18:48
 */
namespace Notadd\Member\Entities;

use Notadd\Foundation\Flow\Abstracts\Entity;

/**
 * Class MemberNotification.
 */
class MemberNotification extends Entity
{
    /**
     * @return string
     */
    public function name()
    {
        return 'member.notification';
    }

    /**
     * @return array
     */
    public function places()
    {
        return [];
    }

    /**
     * @return array
     */
    public function transitions()
    {
        return [];
    }
}
