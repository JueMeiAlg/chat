<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

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
        'phone',//注册手机号码
        'status',//default(1) 用户状态 1:正常 0封禁
        'password',//密码
        'signature',// nullable() 个性签名
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
}
