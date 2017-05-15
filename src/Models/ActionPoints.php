<?php
/**
 * This file is part of Notadd.
 *
 * @author Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-01-23 16:09
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
    /**
     * @var string
     */
    protected $table = 'action_points';

    /**
     * @var array
     */
    protected $fillable = [
        'display_name',
        'name',
        'points',
        'description',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'points' => 'float',
    ];

    /**
     * @param string $name
     * @param        $points
     * @param null   $displayName
     * @param null   $description
     *
     * @return \Notadd\Foundation\Database\Model|\Notadd\Member\Models\ActionPoints
     */
    public static function addAction(string $name, $points, $displayName = null, $description = null)
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

    /**
     * @param $name
     *
     * @return \Notadd\Member\Models\ActionPoints
     */
    public static function findByName($name)
    {
        return static::newQuery()->where('name', $name)->get()->first(null, new static());
    }
}
