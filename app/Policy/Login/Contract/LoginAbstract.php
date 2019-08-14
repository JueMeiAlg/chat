<?php


namespace App\Policy\Login\Contract;


use App\Exceptions\ApiException;
use App\Http\StatusCode;
use App\Models\User;
use Illuminate\Support\Facades\Redis;

abstract class LoginAbstract implements LoginInterface
{
    /**
     * 全局挂载一个User实例
     *
     * @var null |User
     */
    protected $user = null;

    /**
     * 具体登录函数,需子类实现
     *
     * @return mixed
     */
    abstract public function login();

    /**
     * 实现检测用户是否可用
     *
     * @return mixed|void
     * @throws ApiException
     */
    public function checkUserStatus()
    {
        if ($this->user->status == User::PROHIBIT) {
            throw new ApiException(StatusCode::USER_NOT_USE);
        }
    }

    /**
     * 实现创建token
     *
     * @return mixed|string
     */
    public function createToken()
    {
        $str = randomEnSTR(rand(108, 255));
        $this->storeToken($str);
        return $str;
    }

    /**
     * 实现存储Token
     *
     * @param $tokne
     * @return mixed|void
     */
    public function storeToken($tokne)
    {
        User::query()
            ->where('id', $this->user->id)
            ->update([
                'token' => $tokne
            ]);
//        $userId = $this->user->id;
//        //拼出存储键
//        $storeKey = 'user:token:' . $tokne;
//        Redis::setex($storeKey, config('cache.tokenExpire'), $userId);
    }
}