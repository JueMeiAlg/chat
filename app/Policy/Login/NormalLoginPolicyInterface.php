<?php


namespace App\Policy\Login;


use App\Exceptions\ApiException;
use App\Http\StatusCode;
use App\Policy\Login\Contract\LoginInterface;
use App\Policy\Login\Contract\LoginAbstract;
use App\Repository\User\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        if (!Hash::check($pwd, $this->user->password )) { //密码不匹配
            throw new ApiException(StatusCode::PASSWORD_ERROR);
        }

        //检测用户状态
        $this->checkUserStatus();

        //通过生成token
        $token = $this->createToken();

        //使用Id登录
        Auth::loginUsingId($this->user->id);
        return [
            'token'=>$token,
            'user'=>$this->user
        ];
    }
}