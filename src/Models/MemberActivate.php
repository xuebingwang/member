<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-29 14:57
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class MemberActivate.
 */
class MemberActivate extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'activated',
        'context',
        'member_id',
        'type',
    ];

    /**
     * @var string
     */
    protected $table = 'member_activates';
}
