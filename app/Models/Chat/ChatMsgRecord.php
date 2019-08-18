<?php

namespace App\Models\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 好友聊天消息记录
 *
 * Class ChatMsgRecord
 * @package App\Models\Chat
 */
class ChatMsgRecord extends Model
{
    use SoftDeletes;

    /**
     * 置操作表
     *
     * @var string
     */
    protected $table = 'chat_msg_records';

    /**
     * 置白名单字段
     *
     * @var array
     */
    protected $fillable = [
        'id',//主键
        'user_id',//谁的记录
        'friend_id',//那个好友发的
        'msg',//消息
    ];

    /**
     * 关联到用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
