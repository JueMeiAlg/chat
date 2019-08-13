<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * 用户的好友分栏
 *
 * Class UserCloumn
 * @package App\Models\User
 */
class UserColumn extends Model
{
    /**
     * 置操作表
     *
     * @var string
     */
    protected $table = 'user_columns';

    /**
     * 置可操作字段
     *
     * @var array
     */
    protected $fillable = [
        'id', //主键
        'name', //好友分组栏目名称
        'user_id', //改分组属于哪个用户
    ];

    /**
     * 关联到用户信息
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 关联到栏目下的好友信息
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function friend()
    {
        return $this->hasManyThrough(
            User::class,
            UserColumnRelationUser::class,
            'column_id', 'id',
            'id','user_id');
    }
}
