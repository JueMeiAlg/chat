<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * 好友认证
 *
 * Class FriendAuth
 * @package App\Models\User
 */
class FriendAuth extends Model
{
    /**
     * 置操作表
     *
     * @var string
     */
    protected $table = 'friend_auths';

    /**
     * 置可操作字段
     *
     * @var array
     */
    protected $fillable = [
        'id', //主键
        'msg', //留言消息
        'reason', //nullable()拒绝理由
        'status', //default(0)认证状态 0初始状态 1通过 2拒绝
        'user_id', //属于谁的添加消息
        'friend_id', //谁发来的添加好友消息
    ];

    /**
     * 好友确认认证初始状态
     *
     * @var int
     */
    const INIT = 0;

    /**
     * 好友确认认证通过状态
     *
     * @var int
     */
    const PASS = 1;

    /**
     * 好友确认认证拒绝状态
     *
     * @var int
     */
    const REFUSE = 2;

    /**
     * 关联到用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * 关联到好友
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function friend()
    {
        return $this->hasOne(User::class, 'id', 'friend_id');
    }
}
