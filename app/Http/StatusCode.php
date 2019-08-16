<?php


namespace App\Http;


class StatusCode
{
    const SUCCESS = ['code' => 0, 'msg' => '请求成功'];
    const ERROR = ['code' => -1, 'msg' => '请求失败'];

    /**
     * 登录相关
     */
    const LOGIN_SUCCESS = ['code' => 0, 'msg' => '登录成功'];
    const LOGIN_FAIL = ['code' => -2, 'msg' => '登录失败'];
    const PASSWORD_ERROR = ['code' => -3, 'msg' => '账号或密码错误'];
    const USER_NOT_EXIST = ['code' => -4, 'msg' => '用户不存在'];
    const NOT_HAS_AUTH = ['code' => 401, 'msg' => '请登录后再试'];
    const USER_NOT_USE = ['code' => -6, 'msg' => '用户不可使用'];


    /**
     * 返回JSON数据
     * @param array $code
     * @param array $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public static function Json(array $code, array $data = [],$status = 200)
    {
        $json = array_merge($code, $data);
        return response()->json($json,$status);
    }

    /**
     * 数据库错误消息
     *
     * @param $msg
     * @return array
     */
    public static function DBError($msg)
    {
        return ['code' => -9, 'msg' => $msg];
    }
}