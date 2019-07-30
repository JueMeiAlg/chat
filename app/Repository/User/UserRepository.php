<?php


namespace App\Repository\User;


use App\Models\User;

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
}