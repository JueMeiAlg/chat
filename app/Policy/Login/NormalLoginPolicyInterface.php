<?php


namespace App\Policy\Login;


use App\Exceptions\ApiException;
use App\Http\StatusCode;
use App\Policy\Login\Contract\LoginInterface;
use App\Policy\Login\Contract\LoginAbstract;
use App\Repository\User\UserRepository;

/**
 * 正常手机号密码登录处理
 *
 * Class NormalLoginInterfacePolicy
 * @package App\Policy\LoginInterface
 */
class NormalLoginPolicy extends LoginAbstract implements LoginInterface
{
    /**
     * 登录处理函数
     *
     * @return array|mixed
     * @throws ApiException
     */
    public function login()
    {
        $phone = request()->get('phone');
        $pwd = request()->get('password');
        $this->user = app(UserRepository::class)->phoneGetUser($phone);

        //密码为MD5加密
        if ($this->user->password != $pwd) {
            throw new ApiException(StatusCode::PASSWORD_ERROR);
        }
        //检测用户状态
        $this->checkUserStatus();

        //通过生成token
        $token = $this->createToken();

        return [
            'token'=>$token,
            'user'=>$this->user
        ];
    }
}