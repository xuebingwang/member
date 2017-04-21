<?php
/**
 * This file is part of Notadd.
 *
 * @author Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-01-23 17:40
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class GetPointsRecord.
 *
 * @property integer             $id
 * @property integer             $user_id
 * @property string              $action_display_name
 * @property string              $action_name
 * @property float               $points
 * @property \Carbon\Carbon|null $created_at
 */
class GetPointsRecord extends Model
{
    /**
     * @var string
     */
    protected $table = 'get_points_records';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'action_display_name',
        'action_name',
        'points',
    ];

    /**
     * @var array
     */
    protected $dates = ['created_at'];
}
