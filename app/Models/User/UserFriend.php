<?php

namespace App\Models\User;

use App\Models\User;
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
        'column_id', //好友分栏Id
        //unique(['user_id', 'friend_id', 'column_id'])
    ];

    /**
     * 关联到好友信息
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function friend()
    {
        return $this->hasOne(User::class, 'id', 'friend_id');
    }
}
