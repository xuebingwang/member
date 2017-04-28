<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-27 16:50
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class MemberGroup.
 */
class MemberGroup extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'end',
        'group_id',
        'member_id',
        'next',
        'type',
    ];

    /**
     * @var string
     */
    protected $table = 'member_groups';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function details()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }
}
