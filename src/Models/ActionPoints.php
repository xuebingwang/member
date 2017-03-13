<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-01-23 16:09
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class ActionPoints.
 *
 * @property integer             $id
 * @property string              $name
 * @property string              $display_name
 * @property float               $points
 * @property string              $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class ActionPoints extends Model
{
    protected $table = 'action_points';

    protected $fillable = [
        'display_name',
        'name',
        'points',
        'description',
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'points' => 'float',
    ];

    public static function addAction($name, $points, $displayName = null, $description = null)
    {
        $actionPoints = static::findByName($name);
        if (!$actionPoints || !$actionPoints->exists) {
            $actionPoints = new static(['name' => $name]);
        }
        $actionPoints->points = $points;
        $actionPoints->display_name = $displayName;
        $actionPoints->description = $description;
        $actionPoints->save();

        return $actionPoints;
    }

    public static function findByName($name)
    {
        return static::where('name', $name)
            ->get()
            ->first(null, new static);
    }
}
