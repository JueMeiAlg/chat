<?php


namespace App\Http;


class StatusCode
{
    /**
     * 登录相关
     */
    const LOGIN_SUCCESS = ['code' => 0, 'msg' => '登录成功'];
    const LOGIN_FAIL = ['code' => -2, 'msg' => '登录失败'];
    const PASSWORD_ERROR = ['code' => -3, 'msg' => '账号或密码错误'];
    const USER_NOT_EXIST = ['code' => -4, 'msg' => '用户不存在'];
    const NOT_HAS_AUTH = ['code' => 401, 'msg' => '请登录后再试'];
    const USER_NOT_USE = ['code' => -6, 'msg' => '用户不可使用'];
}