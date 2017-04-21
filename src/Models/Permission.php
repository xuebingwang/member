<?php
/**
 * This file is part of Notadd.
 *
 * @author Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-15 11:29
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Member\Permission as BasePermission;

/**
 * Class Permission.
 */
class Permission extends BasePermission
{
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($perm) {
            $perm->groups()->sync([]);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_permission', 'permission_id', 'group_id');
    }
}
