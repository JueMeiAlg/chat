<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Http\StatusCode;
use App\Models\User\FriendAuth;
use App\Models\User\UserColumn;
use App\Models\User\UserFriend;
use App\Service\Search\User\Contract\SearchUserInterface;
use Illuminate\Support\Facades\Auth;

/**
 * 好友管理
 *
 * Class FriendController
 * @package App\Http\Controllers\User
 */
class FriendController extends Controller
{
    /**
     * 删除好友
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //删除好友表中的数据
        UserFriend::query()
            ->where('user_id', Auth::id())
            ->where('friend_id', $id)
            ->delete();
        //双方互相删除
        UserFriend::query()
            ->where('friend_id', Auth::id())
            ->where('user_id', $id)
            ->delete();
        return $this->Json(StatusCode::SUCCESS);
    }

    /**
     * 搜索好友
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\FromVerif
     */
    public function searchFriend()
    {
        $field = $this->formVerif([
            'phone' => 'required'
        ]);
        $users = app(SearchUserInterface::class)
            ->setPhone($field['phone'])
            ->setPage(request()->get('page', 1))
            ->setLimit(request()->get('limit', 10))
            ->search();

        return $this->Json(StatusCode::SUCCESS, ['data' => $users]);
    }

    /**
     * 添加好友
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\FromVerif
     */
    public function store()
    {
        $field = $this->formVerif([
            'friend_id' => 'required',
            'status' => 'required',
            'reason' => 'nullable',
        ]);
        //修改信息状态3

        FriendAuth::query()
            ->where('user_id', Auth::id())
            ->where('friend_id', $field['friend_id'])
            ->update([
                'status' => $field['status'],
                'reason' => $field['reason'],
            ]);
        if ($field['status'] == FriendAuth::PASS) {
            //好友记录反插 双方都有
            $columnId = UserColumn::query()
                ->where('user_id', Auth::id())
                ->orderByDesc('id')
                ->first()->id;

            UserFriend::query()
                ->create([
                    'user_id' => Auth::id(),
                    'friend_id' => $field['friend_id'],
                    'column_id' => $columnId,
                ]);
            $columnId = UserColumn::query()
                ->where('user_id', $field['friend_id'])
                ->orderByDesc('id')
                ->first()->id;

            UserFriend::query()
                ->create([
                    'user_id' => $field['friend_id'],
                    'friend_id' => Auth::id(),
                    'column_id' => $columnId,
                ]);
        }
        return $this->Json(StatusCode::SUCCESS);
    }

    /**
     * 添加好友认证消息
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\FromVerif
     */
    public function storeFriendAuth()
    {
        $field = $this->formVerif([
            'friend_id' => 'required',
            'msg' => 'required',
        ]);
        //插入消息
        FriendAuth::query()
            ->create([
                'user_id' => $field['friend_id'],
                'msg' => $field['msg'],
                'friend_id' => Auth::id(),
            ]);
        return $this->Json(StatusCode::SUCCESS);
    }

    /**
     * 好友消息认证列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function friendAuthList()
    {
        $page = request()->get('page', 1);
        $limit = request()->get('limit', 10);

        $msg = FriendAuth::query()
            ->with('friend')
            ->where('user_id', Auth::id())
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->orderByDesc('created_at')
            ->get();

        $total = FriendAuth::query()
            ->where('user_id', Auth::id())
            ->count();

        return $this->Json(StatusCode::SUCCESS, ['data' => $msg, 'total' => $total]);
    }

    /**
     * 未处理的消息统计
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function friendAuthCount()
    {
        $count = FriendAuth::query()
            ->where('status', FriendAuth::INIT)
            ->count();
        return $this->Json(StatusCode::SUCCESS, ['data' => ['count' => $count]]);
    }
}
