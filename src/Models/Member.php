<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-01-05 15:01
 */
namespace Notadd\Member\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;
use Notadd\Foundation\Member\Member as BaseMember;

/**
 * Class Member.
 *
 * @property integer             $id
 * @property string              $name
 * @property string              $email
 * @property string              $phone
 * @property string              $nick_name
 * @property string              $real_name
 * @property string              $sex 0 1 2
 * @property \Carbon\Carbon|null $birthday
 * @property string              $signature
 * @property string              $introduction
 * @property string              $avatar
 * @property integer             $points
 * @property integer             $total_registration_count
 * @property integer             $continue_registration_count
 * @property string              $is_banned
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 */
class Member extends BaseMember
{
    use SoftDeletes;

    /**
     * Founder role
     */
    const ROLE_FOUNDER = 'founder';

    protected $table = 'members';

    protected $fillable = [
        'nick_name',
        'real_name',
        'phone',
        'name',
        'email',
        'sex',
        'birthday',
        'password',
        'signature',
        'introduction',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'birthday'];

    /**
     * 用户的用户组
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_member', 'member_id', 'group_id');
    }

    public function topics()
    {
        return $this->hasMany(Topic::class, 'user_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id')
            ->with('sender')
            ->orderBy('created_at', 'desc');
    }

    public function getCacheGroupKey()
    {
        $userPrimaryKey = $this->primaryKey;

        return 'groups_for_member_' . $this->$userPrimaryKey;
    }

    /**
     * 从缓存中获取当前用户的所属用户组, 如果没有就从数据库获取
     *
     * @return mixed
     */
    public function cachedGroups()
    {
        return Cache::remember($this->getCacheGroupKey(), 60, function () {
            return $this->groups()->get();
        });
    }

    /**
     * 判断用户是否有某个用户组
     *
     * @param string|array $group
     *
     * @return bool
     */
    public function hasGroup($name, $requireAll = false)
    {
        if (is_array($name)) {
            foreach ($name as $groupName) {
                $hasGroup = $this->hasGroup($groupName);
                if ($hasGroup && ! $requireAll) {
                    return true;
                } elseif (! $hasGroup && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        } else {
            foreach ($this->cachedGroups() as $group) {
                if ($group->name == $name) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if user has a permission by its name.
     *
     * @param string|array $permission
     * @param bool         $requireAll
     *
     * @return bool
     */
    public function may($permission, $requireAll = false)
    {
        if ($this->hasPermission($permission, $requireAll)) {
            return true;
        }
        if (is_array($permission)) {
            foreach ($permission as $permName) {
                $hasPerm = $this->may($permName);
                if ($hasPerm && ! $requireAll) {
                    return true;
                } elseif (! $hasPerm && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        } else {
            foreach ($this->cachedGroups() as $group) {
                foreach ($group->cachedPermissions() as $perm) {
                    if (str_is($permission, $perm->name)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * 是否有权限执行前台的权限判断
     *
     * @param      $permission
     * @param bool $requireAll
     *
     * @return bool
     */
    public function frontMay($permission, $requireAll = false)
    {
        if (is_array($permission)) {
            $permission = array_map(function ($val) {
                if (ends_with($val, '*')) {
                    return $val;
                }

                return Permission::FRONT_PREFIX . $val;
            }, $permission);
        } else {
            if (! ends_with($permission, '*')) {
                $permission = Permission::FRONT_PREFIX . $permission;
            }
        }

        return $this->may($permission, $requireAll);
    }

    /**
     * Check if user has a admin permission by its name.
     *
     * @param string|array $permission
     * @param bool         $requireAll
     *
     * @return bool
     */
    public function adminMay($permission, $requireAll = false)
    {
        if (is_array($permission)) {
            $permission = array_map(function ($val) {
                if (ends_with($val, '*')) {
                    return $val;
                }

                return Permission::ADMIN_PREFIX . $val;
            }, $permission);
        } else {
            if (! ends_with($permission, '*')) {
                $permission = Permission::ADMIN_PREFIX . $permission;
            }
        }

        return $this->may($permission, $requireAll);
    }

    public function save(array $options = [])
    {
        $result = parent::save($options);
        Cache::forget($this->getCacheGroupKey());

        return $result;
    }

    public function delete()
    {
        $result = parent::delete();
        Cache::forget($this->getCacheGroupKey());

        return $result;
    }

    public function restore()
    {
        $result = parent::restore();
        Cache::forget($this->getCacheGroupKey());

        return $result;
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            if (! method_exists(static::class, 'bootSoftDeletes')) {
                $user->groups()->sync([]);
            }

            return true;
        });
    }

    public function setPassword($password)
    {
        $this->password = empty($password) ? '' : app()->make('hash')->make($password);

        return $this;
    }

    public function checkPassword($password)
    {
        return app()->make('hash')->check($password, $this->password);
    }

    public function checkIn()
    {
        if ($this->todaySigned()) {
            return;
        }
        $signAction = ActionPoints::where('name', 'sign')->first();
        if (! $signAction) {
            return;
        }
        Registration::checkIn($this->id, $signAction->points);
        $this->points += $signAction->points;
        $this->total_registration_count += 1;
        if ($this->yesterdaySigned()) {
            $this->continue_registration_count += 1;
        } else {
            $this->continue_registration_count = 1;
        }
        $this->save();
        GetPointsRecord::create([
            'user_id'             => $this->id,
            'action_display_name' => $signAction->display_name,
            'action_name'         => $signAction->name,
            'points'              => $signAction->points,
        ]);
    }

    /**
     * 今天是否签到
     *
     * @return bool
     */
    public function todaySigned()
    {
        return (bool) Registration::where('user_id', $this->id)
            ->where('signed_at', '>=', Carbon::now()->startOfDay())
            ->where('signed_at', '<=', Carbon::now()->endOfDay())
            ->count();
    }

    /**
     * 昨天是否签到
     *
     * @return bool
     */
    public function yesterdaySigned()
    {
        return (bool) Registration::where('user_id', $this->id)
            ->where('signed_at', '>=', Carbon::now()->subDay()->startOfDay())
            ->where('signed_at', '<=', Carbon::now()->subDay()->endOfDay())
            ->count();
    }

    public function attachGroup($group)
    {
        if (is_object($group)) {
            $group = $group->getKey();
        }
        if (is_array($group)) {
            $group = $group['id'];
        }
        $this->groups()->attach($group);
    }

    public function detachGroup($group)
    {
        if (is_object($group)) {
            $group = $group->getKey();
        }
        if (is_array($group)) {
            $group = $group['id'];
        }
        $this->groups()->detach($group);
    }

    public function attachGroups($groups)
    {
        foreach ($groups as $group) {
            $this->attachGroup($group);
        }
    }

    public function detachGroups($groups = null)
    {
        if (! $groups) {
            $groups = $this->groups()->get();
        }
        foreach ($groups as $group) {
            $this->detachGroup($group);
        }
    }
}
