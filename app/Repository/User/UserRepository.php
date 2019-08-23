<?php


namespace App\Repository\User;


use App\Exceptions\ApiException;
use App\Http\StatusCode;
use App\Models\User;
use App\Models\User\UserColumn;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
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
     * 根据fd获取信息
     *
     * @param int $fd
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function fdGetUser(int $fd)
    {
        return User::query()
            ->where('fd', $fd)
            ->firstOrFail();
    }

    /**
     * 根据用户id获得fd
     *
     * @param int $userId
     * @return int
     */
    public function userIdGetFd(int $userId)
    {
        return User::query()
            ->where('id', $userId)
            ->firstOrFail()
            ->fd;
    }

    /**
     * 获得所有好友Id
     *
     * @param int $userId
     * @return array
     */
    public function getAllFriendId(int $userId)
    {
        return User\UserFriend::query()
            ->where('user_id', $userId)
            ->pluck('friend_id')
            ->toArray();
    }

    /**
     * 获得我所有好友的fd
     *
     * @param int $userId
     * @return array
     */
    public function getAllFriendFd(int $userId)
    {
        $friendId = $this->getAllFriendId($userId);
       return User::query()
            ->whereIn('id', $friendId)
            ->whereNotNull('fd')
            ->pluck('fd')
            ->toArray();
    }

    /**
     * 添加用户
     *
     * @param array $userInfo
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws ApiException
     */
    public function addUser(array $userInfo)
    {
        try{
            DB::beginTransaction();
            $user = User::query()->create([
                'name' => $userInfo['name'],
                'phone' => $userInfo['phone'],
                'password' => Hash::make($userInfo['password']),
                'avatar' => $userInfo['avatar'] ?? "",
                'signature' => $userInfo['signature'] ?? "",
            ]);
            //默认给他新加一个栏目
            UserColumn::query()->create([
                'name' => '我的好友',
                'user_id' => $user->id,
            ]);
            DB::commit();
            return $user;
        }catch (QueryException $exception) {
            DB::rollBack();
            throw new ApiException(StatusCode::DBError($exception->getMessage()));
        }

    }
}
