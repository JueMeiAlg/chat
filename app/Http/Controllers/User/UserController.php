<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Http\StatusCode;
use App\Repository\User\UserRepository;

/**
 * 用户相关信息控制器
 *
 * Class UserController
 * @package App\Http\Controllers\User
 */
class UserController extends Controller
{
    private $userRepository;

    /**
     * 注入数据操作仓库
     *
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * 查看用户信息
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function userInfo($id)
    {
        $user = $this->userRepository->idGetUser($id);
        return $this->Json(StatusCode::SUCCESS, ['data'=>$user]);
    }


}
