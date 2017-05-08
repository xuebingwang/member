<?php
/**
 * This file is part of Notadd.
 *
 * @author Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-01-05 15:01
 */
namespace Notadd\Member\Models;

use Illuminate\Notifications\Notifiable;
use Notadd\Member\Traits\InjectionFunction;
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
 * @property string              $sex    0 1 2
 * @property \Carbon\Carbon|null $birthday
 * @property string              $signature
 * @property string              $introduction
 * @property string              $avatar
 * @property integer             $points
 * @property string              $status normal banned deleted activated
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 */
class Member extends BaseMember
{
    use SoftDeletes, InjectionFunction, Notifiable;

    /**
     * Founder role
     */
    const ROLE_FOUNDER = 'founder';

    /**
     * @var string
     */
    protected $table = 'members';

    /**
     * @var array
     */
    protected $fillable = [
        'avatar',
        'birthday',
        'email',
        'introduction',
        'name',
        'nickname',
        'password',
        'phone',
        'realname',
        'sex',
        'signature',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'birthday',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function activate() {
        return $this->hasOne(MemberActivate::class, 'member_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ban()
    {
        return $this->hasOne(MemberBan::class, 'member_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups()
    {
        return $this->hasMany(MemberGroup::class, 'member_id');
    }

    /**
     * @return mixed
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id')
            ->with('sender')
            ->orderBy('created_at', 'desc');
    }

    /**
     * @return string
     */
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
        return $this->cache->remember($this->getCacheGroupKey(), 60, function () {
            return $this->groups()->get();
        });
    }

    /**
     * 判断用户是否有某个用户组
     *
     * @param      $name
     * @param bool $requireAll
     *
     * @return bool
     * @internal param array|string $group
     *
     */
    public function hasGroup($name, $requireAll = false)
    {
        if (is_array($name)) {
            foreach ($name as $groupName) {
                $hasGroup = $this->hasGroup($groupName);
                if ($hasGroup && !$requireAll) {
                    return true;
                } elseif (!$hasGroup && $requireAll) {
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
                if ($hasPerm && !$requireAll) {
                    return true;
                } elseif (!$hasPerm && $requireAll) {
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
            if (!ends_with($permission, '*')) {
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
            if (!ends_with($permission, '*')) {
                $permission = Permission::ADMIN_PREFIX . $permission;
            }
        }

        return $this->may($permission, $requireAll);
    }

    /**
     * @param array $options
     *
     * @return bool
     */
    public function save(array $options = [])
    {
        $result = parent::save($options);
        $this->cache->forget($this->getCacheGroupKey());

        return $result;
    }

    /**
     * @return bool|null
     */
    public function delete()
    {
        $result = parent::delete();
        $this->cache->forget($this->getCacheGroupKey());

        return $result;
    }

    /**
     * @return mixed
     */
    public function restore()
    {
        $result = parent::restore();
        $this->cache->forget($this->getCacheGroupKey());

        return $result;
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            if (!method_exists(static::class, 'bootSoftDeletes')) {
                $user->groups()->sync([]);
            }

            return true;
        });
    }

    /**
     * Setting the password
     *
     * @param string $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = empty($password) ? '' : app()->make('hash')->make($password);

        return $this;
    }

    /**
     * Check the password
     *
     * @param string $password
     *
     * @return bool
     */
    public function checkPassword($password)
    {
        return app()->make('hash')->check($password, $this->password);
    }

    /**
     * @param $group
     */
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

    /**
     * @param $group
     */
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

    /**
     * @param $groups
     */
    public function attachGroups($groups)
    {
        foreach ($groups as $group) {
            $this->attachGroup($group);
        }
    }

    /**
     * @param null $groups
     */
    public function detachGroups($groups = null)
    {
        if (!$groups) {
            $groups = $this->groups()->get();
        }
        foreach ($groups as $group) {
            $this->detachGroup($group);
        }
    }

    /**
     * @param $email
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Notadd\Member\Models\Member
     */
    public static function findByEmail($email)
    {
        return static::query()->where('email', $email)->first();
    }

    /**
     * Get a relationship.
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function getRelationValue($key)
    {
        // If the key already exists in the relationships array, it just means the
        // relationship has already been loaded, so we'll just return it out of
        // here because there is no need to query within the relations twice.
        if ($this->relationLoaded($key)) {
            return $this->relations[$key];
        }
        // If the "attribute" exists as a method on the model, we will just assume
        // it is a relationship and will load and return results from the query
        // and hydrate the relationship's value on the "relationships" array.
        if (method_exists($this, $key) || $this->hasInjectedFunction($key)) {
            return $this->getRelationshipFromMethod($key);
        }
    }
}
