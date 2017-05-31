<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 16:00
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class MemberTag.
 */
class MemberTag extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'tag',
    ];

    /**
     * @var string
     */
    protected $table = 'member_tags';
}
