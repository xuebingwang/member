<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-27 14:41
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class MemberBan.
 */
class MemberBan extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'member_id',
        'reason',
        'type',
        'time',
    ];

    /**
     * @var string
     */
    protected $table = 'member_banned';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
