<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Http\StatusCode;
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
}
