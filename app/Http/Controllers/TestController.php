<?php


namespace App\Http\Controllers;


use App\Models\Chat\Group;
use App\Models\User;
use App\Models\User\UserColumn;
use App\Service\Chat\Swoole\HandleMessageEvent;
use App\Service\Search\User\Contract\SearchUserInterface;
use App\Service\Search\User\MysqlSearchDriver;
use Illuminate\Support\Facades\App;
use Symfony\Component\Debug\Exception\FatalThrowableError;

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
        $methodName = 't' . $id;
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

    public function t5()
    {
        //测试搜索
        $mysql = new MysqlSearchDriver();
        $user = $mysql
            ->setSignature('我')
            ->setPhone('136868400')
            ->search();
        dd($user);
    }

    /**
     * 测试搜索绑定
     */
    public function t6()
    {
        $mysql = app(SearchUserInterface::class)->setPhone('1368684')->search();
        dd($mysql);
    }

    public function t7()
    {
        dd(User::query()->get());
    }

    public function t8()
    {
        $request = [
            'msg'=>'bindFd',
            'data'=>[
                'userId'=>1,
                'fd'=>2
            ]
        ];
        App::call(HandleMessageEvent::class . '@' . $request['msg'], $request['data'] ?? []);
    }

    public function t9()
    {
        $user = User\UserFriend::query()
            ->with('friend:id,fd')
            ->where('user_id', 1)
            ->get()
            ->pluck('friend')
            ->pluck('fd')->reject(function ($value) {
                return is_null($value);
            })->values()->toArray();
        dd($user);
    }
}

