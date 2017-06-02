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
 * Class MemberTag.
 */
class MemberTag extends Entity
{
    /**
     * @return string
     */
    public function name()
    {
        return 'member.tag';
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