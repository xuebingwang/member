<?php
/**
 * This file is part of Notadd.
 *
 * @author Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-01-05 15:26
 */

namespace Notadd\Member\Models;

use Notadd\Member\Models\Permission;
use Notadd\Foundation\Database\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Class Group.
 *
 * @property integer             $id
 * @property string              $name
 * @property string              $display_name
 * @property string              $icon
 * @property string              $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Group extends Model
{
    /**
     * @var string
     */
    protected $table = 'groups';

    /**
     * @var array
     */
    protected $fillable = [
        'display_name',
        'description',
        'name',
        'icon',
    ];

    /**
     * Many-to-Many relations with the member model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(Member::class, 'group_member', 'group_id', 'member_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'group_permission', 'group_id', 'permission_id');
    }

    /**
     * @return string
     */
    public function getCachePermissionKey()
    {
        $groupPrimaryKey = $this->primaryKey;

        return 'permissions_for_group_' . $this->$groupPrimaryKey;
    }

    /**
     * @return mixed
     */
    public function cachedPermissions()
    {
        return Cache::remember($this->getCachePermissionKey(), 60, function () {
            return $this->permissions()->get();
        });
    }

    /**
     * @param array $options
     *
     * @return bool
     */
    public function save(array $options = [])
    {
        $result = parent::save($options);
        Cache::forget($this->getCachePermissionKey());

        return $result;
    }

    /**
     * @return bool|null
     */
    public function delete()
    {
        $result = parent::delete();
        Cache::forget($this->getCachePermissionKey());

        return $result;
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($group) {
            $group->members()->sync([]);
            $group->permissions()->sync([]);
        });
    }

    /**
     * @param      $name
     * @param bool $requireAll
     *
     * @return bool
     */
    public function hasPermission($name, $requireAll = false)
    {
        if (is_array($name)) {
            foreach ($name as $permissionName) {
                $hasPermission = $this->hasPermission($permissionName);
                if ($hasPermission && ! $requireAll) {
                    return true;
                } elseif (! $hasPermission && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        } else {
            foreach ($this->cachedPermissions() as $permission) {
                if ($permission->name == $name) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param      $name
     * @param bool $requireAll
     *
     * @return bool
     */
    public function hasAdminPermission($name, $requireAll = false)
    {
        $adminName = $name;
        if (is_array($name)) {
            $adminName = array_map(function ($val) {
                return Permission::ADMIN_PREFIX . $val;
            }, $name);
        } else {
            $adminName = Permission::ADMIN_PREFIX . $name;
        }

        return $this->hasPermission($adminName, $requireAll);
    }

    /**
     * @param      $name
     * @param null $display_name
     * @param null $icon
     * @param null $description
     *
     * @return \Notadd\Member\Models\Group
     */
    public static function addGroup($name, $display_name = null, $icon = null, $description = null)
    {
        $group = self::where('name', $name)->first();
        if (! $group) {
            $group = new self(['name' => $name]);
        }

        $group->icon         = $icon;
        $group->display_name = $display_name;
        $group->description  = $description;
        $group->save();

        return $group;
    }

    /**
     * Attach permission to current role.
     *
     * @param object|array $permission
     *
     * @return void
     */
    public function attachPermission($permission)
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }
        if (is_array($permission)) {
            $permission = $permission['id'];
        }
        $this->permissions()->attach($permission);
    }

    /**
     * Detach permission from current role.
     *
     * @param object|array $permission
     *
     * @return void
     */
    public function detachPermission($permission)
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }
        if (is_array($permission)) {
            $permission = $permission['id'];
        }
        $this->permissions()->detach($permission);
    }

    /**
     * Attach multiple permissions to current role.
     *
     * @param mixed $permissions
     *
     * @return void
     */
    public function attachPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $this->attachPermission($permission);
        }
    }

    /**
     * Detach multiple permissions from current role
     *
     * @param mixed $permissions
     *
     * @return void
     */
    public function detachPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $this->detachPermission($permission);
        }
    }
}
