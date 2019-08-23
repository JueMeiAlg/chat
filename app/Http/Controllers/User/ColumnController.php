<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Http\StatusCode;
use App\Repository\User\UserRepository;
use Illuminate\Support\Facades\Auth;

/**
 * 用户好友分栏
 *
 * Class ColumnController
 * @package App\Http\Controllers\User
 */
class ColumnController extends Controller
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
     * ColumnController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * 存储栏目数据
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\FromVerif
     */
    public function store()
    {
        $field = $this->formVerif([
            'name' => 'required'
        ]);

        $id = $this->userRepository->addFriendColumn($field['name'], Auth::id())->id;

        return $this->Json(StatusCode::SUCCESS, ['data' => ['id' => $id]]);
    }

    /**
     * 修改栏目信息
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\FromVerif
     */
    public function update($id)
    {
        $field = $this->formVerif([
            'name' => 'required'
        ]);
        $this->userRepository->updateColumn($field['name'], $id);

        return $this->Json(StatusCode::SUCCESS);
    }

    /**
     * 删除分栏信息,如果分栏下有好友信息,自动移动到其他分栏下
     *
     * @param int $id 分栏Id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiException
     */
    public function destroy($id)
    {
        $this->userRepository->destroyColumn($id, Auth::id());

        return $this->Json(StatusCode::SUCCESS, ['msg' => '删除成功,如果下面有好友,会自动移动到其他分组中']);
    }

    /**
     * 用的分栏和分栏下的好友信息
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $columnFriend = $this->userRepository->columnFriend(Auth::id());

        return $this->Json(StatusCode::SUCCESS, ['data' => $columnFriend]);
    }
}
