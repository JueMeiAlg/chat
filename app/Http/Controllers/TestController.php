<?php


namespace App\Http\Controllers;


use App\Models\Chat\Group;
use App\Models\User;
use App\Models\User\UserColumn;

/**
 * 测试和代码调试控制器
 *
 * Class TestController
 * @package App\Http\Controllers
 */
class TestController extends Controller
{
    public function index($id)
    {
        $methodName = 't'.$id;
        $request = request()->all();
        return $this->$methodName(...$request);
    }

    public function t1()
    {
        //群组是否能成功关联到用
        $group = Group::query()
            ->with('user')
            ->get()->toArray();
        dd($group);
    }

    public function t2()
    {
        //用户加入的群组
        $user = User::query()
            ->with('group')
            ->get()->toArray();
        dd($user);
    }

    public function t3()
    {
        //用的好友
        $user = User::query()
            ->with('friend')
            ->get()->toArray();
        dd($user);
    }

    public function t4()
    {
        //用户分栏下的好友
        $user = UserColumn::query()->with('friend')
            ->where('user_id', 2)
            ->get()
            ->toArray();
        dd($user);
    }
}
