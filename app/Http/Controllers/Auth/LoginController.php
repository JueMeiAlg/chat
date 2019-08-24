<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\StatusCode;
use App\Policy\Login\Contract\LoginInterface;
use App\Repository\User\UserRepository;

/**
 * 登录注册控制器
 *
 * Class LoginController
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    /**
     * 登录
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $type = request()->get('type');
        $result = app(LoginInterface::class, ['policy' => $type])->login();

       return $this->Json(StatusCode::LOGIN_SUCCESS, ['data'=>$result]);
    }

    /**
     * 注册
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\FromVerif
     */
    public function register()
    {
        $field = $this->formVerif([
           'phone'=>'required',
           'password'=>'required',
        ]);
        $field['name'] = randomEnSTR(5);
        $user = app(UserRepository::class)->addUser($field);
        return $this->Json(StatusCode::SUCCESS, ['data'=>$user]);
    }
}
