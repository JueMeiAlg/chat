<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Http\StatusCode;
use App\Models\User\FriendAuth;
use App\Models\User\UserColumn;
use App\Models\User\UserFriend;
use App\Repository\User\UserRepository;
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
     * 数据仓库对象
     *
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * 注入仓库服务
     *
     * FriendController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * 删除好友
     *
     * @param int $id 好友Id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiException
     */
    public function destroy($id)
    {
        $this->userRepository->destroyFriend($id, Auth::id());

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
            'phone' => 'required',

        ]);
        $page = request()->get('page', 1);
        $limit = request()->get('limit', 10);
        $users = $this->userRepository->searchFriend($field['phone'], $page, $limit);

        return $this->Json(StatusCode::SUCCESS, ['data' => $users]);
    }

    /**
     * 添加好友,或者拒绝好友都是这个函数处理
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiException
     * @throws \App\Exceptions\FromVerif
     */
    public function store()
    {
        $field = $this->formVerif([
            'friend_id' => 'required',
            'status' => 'required',
            'reason' => 'nullable',
        ]);
        //修改信息状态
        $this->userRepository->updateFriendAuth(Auth::id(), $field['friend_id'], $field['status'], $field['reason']);


        if ($field['status'] == FriendAuth::PASS) {

            $this->userRepository->addFriend($field['friend_id'], Auth::id());

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
        $this->userRepository->addFriendAuth(Auth::id(), $field['friend_id'], $field['msg']);

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

        [$msg, $total] = $this->userRepository->friendAuthList(Auth::id(), $page, $limit);

        return $this->Json(StatusCode::SUCCESS, ['data' => $msg, 'total' => $total]);
    }

    /**
     * 未处理的消息统计
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function friendAuthCount()
    {
        $count = $this->userRepository->friendAuthUntreatedCount(Auth::id());

        return $this->Json(StatusCode::SUCCESS, ['data' => ['count' => $count]]);
    }
}
