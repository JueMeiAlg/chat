<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * 用户的好友分栏下的用户信息
 *
 * Class UserColumnRelationUser
 * @package App\Models\User
 */
class UserColumnRelationUser extends Model
{
    /**
     * 置操作表
     *
     * @var string
     */
    protected $table = 'user_column_relation_users';

    /**
     * 置操作表
     *
     * @var array
     */
    protected $fillable = [
        'id', //主键
        'user_id', //被关联的用户Id
        'column_id', //栏目Id
    ];

    /**
     * 关联到栏目信息
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function column()
    {
        return $this->belongsTo(UserColumn::class);
    }

    /**
     * 关联到用户信息
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
