<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-04 18:41
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class MemberInformationGroup.
 */
class MemberInformationGroup extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'order',
        'show',
    ];

    /**
     * @var string
     */
    protected $table = 'member_information_groups';
}
