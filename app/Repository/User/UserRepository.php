<?php


namespace App\Repository\User;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * 根据手机号查找用户
     *
     * @param string $phone
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function phoneGetUser(string $phone)
    {
       return User::query()
            ->where('phone', $phone)
            ->firstOrFail();
    }

    /**
     * 根据用户Id查找用户
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function idGetUser(int $id)
    {
       return User::query()
            ->where('id', $id)
            ->firstOrFail();
    }

    /**
     * 添加用户
     *
     * @param array $userInfo [string phone, string password]
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function addUser(array $userInfo)
    {
        return User::query()->create([
            'name'=>randomEnSTR(mt_rand(10,18)),
            'phone'=>$userInfo['phone'],
            'password'=>Hash::make($userInfo['password']),
        ]);
    }
}