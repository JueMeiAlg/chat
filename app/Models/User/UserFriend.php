<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserFriend extends Model
{
    /**
     * 置操作表
     *
     * @var string
     */
    protected $table = 'user_friends';

    /**
     * 操作字段白名单
     *
     * @var array
     */
    protected $fillable = [
        'id',//主键
        'user_id', //用户id
        'friend_id', //好友Id
        //unique(['user_id', 'friend_id'])
    ];
}
