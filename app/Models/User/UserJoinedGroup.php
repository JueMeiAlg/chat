<?php

namespace App\Models\User;

use App\Models\Chat\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * 用户加入的群组
 *
 * Class UserJoinedGroup
 * @package App\Models\User
 */
class UserJoinedGroup extends Model
{
    /**
     * 置操作表
     *
     * @var string
     */
    protected $table = 'user_joined_groups';

    /**
     * 可操作字段白名单
     *
     * @var array
     */
    protected $fillable = [
        'id',//主键Id
        'group_id',//群组Id
        'user_id',//用户Id
        //unique(['group_id', 'user_id']) 联合唯一键,一个用户,一个群组,只能加入操作一次
    ];

    /**
     * 关联到群组信息
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hasGroup()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    /**
     * 关联到用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hasUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
