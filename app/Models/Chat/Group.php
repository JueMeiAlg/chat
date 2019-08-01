<?php

namespace App\Models\Chat;

use App\Models\User;
use App\Models\User\UserJoinedGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 群组模型
 *
 * Class Group
 * @package App\Models\Chat
 */
class Group extends Model
{
    use SoftDeletes;

    /**
     * 置操作表
     *
     * @var string
     */
    protected $table = 'groups';

    /**
     * 操作字段白名单
     *
     * @var array
     */
    protected $fillable = [
        'id',//主键Id
        'name',//群组名称
        'max_person',//default(50)最大允许加入人数
        'total_person',//default(0)当前群组总加入人数
        'photo',//群组显示图标
    ];

    /**
     * 远程一对多关联到所有加入到这个群组的用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function user()
    {
        return $this->hasManyThrough(User::class, UserJoinedGroup::class,
            'group_id', 'id', 'id', 'user_id'
        );
    }
}
