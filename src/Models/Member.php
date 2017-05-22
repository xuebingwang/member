<?php
/**
 * This file is part of Notadd.
 *
 * @author Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, notadd.com
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
        return $this->hasMany(MemberGroupRelation::class, 'member_id');
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
