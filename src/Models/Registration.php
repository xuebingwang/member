<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-02-08 18:22
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class Registration.
 *
 * @property integer             $id
 * @property integer             $user_id
 * @property float               $points
 * @property \Carbon\Carbon|null $signed_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at.
 */
class Registration extends Model
{
    protected $table = 'registrations';

    protected $fillable = [
        'user_id',
        'points',
        'signed_at',
    ];

    protected $dates = ['signed_at'];

    public static function checkIn(int $userId, float $points, $signedTime = null)
    {
        return self::create([
            'user_id'   => $userId,
            'points'    => $points,
            'signed_at' => $signedTime ?: time(),
        ]);
    }
}
