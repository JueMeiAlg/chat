<?php


namespace App\Repository\User;


use App\Exceptions\ApiException;
use App\Http\StatusCode;
use App\Models\User;
use App\Models\User\FriendAuth;
use App\Models\User\UserColumn;
use App\Models\User\UserFriend;
use App\Service\Search\User\Contract\SearchUserInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * 用户数据仓库
 *
 * Class UserRepository
 * @package App\Repository\User
 */
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
     * fd更新绑定
     *
     * @param int $fd
     * @param int $userId
     * @return int
     */
    public function fdBind(int $fd, int $userId)
    {
       return User::query()
            ->where('id', $userId)
            ->update([
                'fd' => $fd
            ]);
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
     * 清除fd绑定状态
     *
     * @param int $fd
     * @return int
     */
    public function clearFd(int $fd)
    {
        return User::query()
            ->where('fd', $fd)
            ->update([
                'fd'=>null
            ]);
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
        try {
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
        } catch (QueryException $exception) {
            DB::rollBack();
            throw new ApiException(StatusCode::DBError($exception->getMessage()));
        }

    }

    /**
     * 获得用户的分栏和好友信息
     *
     * @param int $userId 用户Id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function columnFriend(int $userId)
    {
        return UserColumn::query()
            ->where('user_id', $userId)
            ->with('friend')
            ->get();
    }

    /**
     * 新增好友分栏
     *
     * @param string $name 分栏名称
     * @param int $userId 当前用户Id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function addFriendColumn(string $name, int $userId)
    {
        return UserColumn::query()->create([
            'name' => $name,
            'user_id' => $userId,
        ]);
    }

    /**
     * 修改分栏信息
     *
     * @param string $name 新分栏名称
     * @param int $columnId 分栏Id
     * @return int
     */
    public function updateColumn(string $name, int $columnId)
    {
        return UserColumn::query()
            ->where('id', $columnId)
            ->update([
                'name' => $name
            ]);
    }

    /**
     * 删除好友分栏
     *
     * @param int $columnId 分栏id
     * @param int $userId 用户Id 谁的分栏
     * @return mixed
     * @throws ApiException
     */
    public function destroyColumn(int $columnId, int $userId)
    {
        try {
            DB::beginTransaction();
            //他的其他分组
            $column = UserColumn::query()
                ->where('user_id', $userId)
                ->orderByDesc('id')
                ->where('id', '!=', $columnId)
                ->first();

            //如果没有数据 说明在删除最后一个分栏信息,最后一个不允许删除
            if (is_null($column)) {
                throw new ApiException(StatusCode::LAST_COLUMN_NOT_DESTROY);
            }

            //查出这个分栏下关联的好友信息
            $friendIds = UserFriend::query()
                ->where('column_id', $columnId)
                ->pluck('friend_id')->toArray();

            //删除关联信息
            UserFriend::query()
                ->where('column_id', $columnId)
                ->where('user_id', $userId)
                ->delete();

            //重写跟新分栏建立关联关系
            foreach ($friendIds as $friend) {
                UserFriend::query()->create([
                    'column_id' => $column->id,
                    'friend_id' => $friend,
                    'user_id' => $userId,
                ]);
            }
            //删除栏目信息
            $delete = UserColumn::query()
                ->where('id', $columnId)
                ->delete();
            DB::commit();
            return $delete;
        } catch (QueryException $exception) {
            DB::rollBack();
            throw new ApiException(StatusCode::DBError($exception->getMessage()));
        }

    }

    /**
     * 删除用户的好友
     *
     * @param int $friendId 好友id 要被删除的好友
     * @param int $userId 用户Id  是哪个要用要删除好友
     * @throws ApiException
     */
    public function destroyFriend(int $friendId, int $userId)
    {
        try {
            DB::beginTransaction();
            //删除好友表中的数据
            UserFriend::query()
                ->where('user_id', $userId)
                ->where('friend_id', $friendId)
                ->delete();
            //双方互相删除
            UserFriend::query()
                ->where('friend_id', $userId)
                ->where('user_id', $friendId)
                ->delete();
            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();
            throw new ApiException(StatusCode::DBError($exception->getMessage()));
        }
    }

    /**
     * 新增好友
     *
     * @param int $friendId 好友Id
     * @param int $userId 当前用户Id
     * @throws ApiException
     */
    public function addFriend(int $friendId, int $userId)
    {
        try {
            DB::beginTransaction();
            //好友记录反插 双方都有
            $columnId = $this->getUserTopFriendColumnId($userId);

            UserFriend::query()
                ->create([
                    'user_id' => $userId,
                    'friend_id' => $friendId,
                    'column_id' => $columnId,
                ]);
            $columnId = $this->getUserTopFriendColumnId($friendId);

            UserFriend::query()
                ->create([
                    'user_id' => $friendId,
                    'friend_id' => $userId,
                    'column_id' => $columnId,
                ]);
            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();
            throw new ApiException(StatusCode::DBError($exception->getMessage()));
        }
    }

    /**
     * 获得用户第一个栏目的Id
     *
     * @param int $userId
     * @return mixed
     */
    public function getUserTopFriendColumnId(int $userId)
    {
        return $this->getUserTopFriendColumn($userId)
            ->id;
    }

    /**
     * 获得用户第一个的栏目信息
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getUserTopFriendColumn(int $userId)
    {
        return UserColumn::query()
            ->where('user_id', $userId)
            ->orderBy('id', 'asc')
            ->first();
    }

    /**
     * 获得用户最后一个栏目的Id
     *
     * @param int $userId
     * @return mixed
     */
    public function getUserLastFriendColumnId(int $userId)
    {
        return $this->getUserLastFriendColumn($userId)
            ->id;
    }

    /**
     * 获得用户最后一个的栏目信息
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getUserLastFriendColumn(int $userId)
    {
        return UserColumn::query()
            ->where('user_id', $userId)
            ->orderByDesc('id')
            ->first();
    }

    /**
     * 修改好友认证状态
     *
     * @param int $userId
     * @param int $friendId
     * @param int $status 认证状态 0初始状态 1通过 2拒绝
     * @param $reason
     * @return int
     */
    public function updateFriendAuth(int $userId, int $friendId, $status, $reason)
    {
        return FriendAuth::query()
            ->where('user_id', $userId)
            ->where('friend_id', $friendId)
            ->update([
                'status' => $status,
                'reason' => $reason,
            ]);
    }

    /**
     * 新增好友认证信息
     *
     * @param int $userId 消息发出者 用户Id
     * @param int $friendId 消息接收者Id
     * @param string $msg 消息
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function addFriendAuth(int $userId, int $friendId, string $msg)
    {
        //插入消息
        return FriendAuth::query()
            ->create([
                'msg' => $msg,
                'user_id' => $friendId,
                'friend_id' => $userId,
            ]);
    }

    /**
     * 好友认证消息
     *
     * @param int $userId 用户Id
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function friendAuthList(int $userId, int $page, int $limit)
    {
        $msg = FriendAuth::query()
            ->with('friend')
            ->where('user_id', $userId)
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->orderByDesc('created_at')
            ->get();

        $total = FriendAuth::query()
            ->where('user_id', $userId)
            ->count();
        return [$msg, $total];
    }

    /**
     * 好友认证消息未处理的总数
     *
     * @param int $userId
     * @return int
     */
    public function friendAuthUntreatedCount(int $userId)
    {
        return FriendAuth::query()
            ->where('user_id', $userId)
            ->where('status', FriendAuth::INIT)
            ->count();
    }

    /**
     * 根据电话号码搜索好友
     *
     * @param string $phone 手机号码
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function searchFriend(string $phone, int $page, $limit)
    {
        return app(SearchUserInterface::class)
            ->setPhone($phone)
            ->setPage($page)
            ->setLimit($limit)
            ->search();
    }
}
