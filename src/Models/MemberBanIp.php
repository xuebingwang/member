<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-02 11:27
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class MemberBanIp.
 */
class MemberBanIp extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'end',
        'ip',
        'reason',
    ];

    /**
     * @var string
     */
    protected $table = 'member_ban_ips';
}
