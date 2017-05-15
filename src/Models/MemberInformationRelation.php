<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 18:48
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class MemberInformationRelation.
 */
class MemberInformationRelation extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'group_id',
        'information_id',
    ];

    /**
     * @var string
     */
    protected $table = 'member_information_relations';
}
