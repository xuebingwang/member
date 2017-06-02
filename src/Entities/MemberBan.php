<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-06-01 18:47
 */
namespace Notadd\Member\Entities;

use Notadd\Foundation\Flow\Abstracts\Entity;

/**
 * Class MemberBan.
 */
class MemberBan extends Entity
{
    /**
     * @return string
     */
    public function name()
    {
        return 'member.ban';
    }

    /**
     * @return array
     */
    public function places()
    {
        return [];
    }
}
