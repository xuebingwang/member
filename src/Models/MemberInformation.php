<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-04 18:39
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class MemberInformation.
 */
class MemberInformation extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'description',
        'details',
        'length',
        'name',
        'order',
        'opinions',
        'privacy',
        'register',
        'required',
        'type',
    ];

    /**
     * @var string
     */
    protected $table = 'member_informations';
}