<?php

namespace App\Models;

use App\Models\Chat\Group;
use App\Models\User\UserFriend;
use App\Models\User\UserJoinedGroup;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Self_;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * 置操作表
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * 置可操作字段
     *
     * @var array
     */
    protected $fillable = [
        'id',//主键Id
        'name',//用户名
        'phone',//unique 注册手机号码
        'status',//default(1) 用户状态 1:正常 0封禁
        'password',//密码
        'signature',// nullable() 个性签名
        'avatar',// nullable() 用户头像
    ];

    /**
     * 主动隐藏字段
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'status'
    ];

    /**
     * 正常用户
     */
    const NORMAL = 1;

    /**
     * 禁止登录用户
     */
    const PROHIBIT = 0;

    /**
     * 远程一对多用户加入的群组
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function group()
    {
        return $this->hasManyThrough(Group::class,UserJoinedGroup::class,
            'user_id', 'id', 'id', 'group_id'
        );
    }

    /**
     * 远程一对多关联到用户的好友
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function friend()
    {
        return $this->hasManyThrough(self::class,UserFriend::class,
            'user_id', 'id', 'id', 'friend_id'
        );
    }
}
