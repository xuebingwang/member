<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 18:50
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class MemberTagRelation.
 */
class MemberTagRelation extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'member_id',
        'tag_id',
    ];

    /**
     * @var string
     */
    protected $table = 'member_tag_relations';
}
