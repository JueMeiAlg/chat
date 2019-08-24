<?php


namespace App\Service\Chat\Swoole;


use App\Models\Chat\ChatMsgRecord;
use App\Models\User;
use App\Repository\Chat\ChatRepository;
use App\Repository\User\UserRepository;
use Swoole\WebSocket\Server;

/**
 * 消息处理类
 *
 * Class HandleMessageEvent
 * @package App\Service\Chat\Swoole
 */
class HandleMessageEvent
{
    /**
     * 连接实例
     *
     * @var Server
     */
    protected static $ws;

    /**
     * 设置连接实例
     *
     * @param Server $ws
     */
    public static function setWs(Server $ws)
    {
        static::$ws = $ws;
    }

    /**
     * 清除连接实例
     */
    public static function clearWs()
    {
        static::$ws = null;
    }

    /**
     * 绑定Fd
     *
     * @param $userId
     * @param $fd
     */
    public function bindFd($userId, $fd)
    {
        $userRepository = app(UserRepository::class);

        $user = $userRepository->idGetUser($userId);
        //fd绑定
        $userRepository->fdBind($fd, $userId);

        //通知连接用户绑定成功
        $this->send($fd, [
            'msg' => 'OK',
            'code' => 0
        ]);

        $friendFds = $userRepository->getAllFriendFd($userId);

        $this->sendFds($friendFds, [
            'msg' => 'friendOnline',
            'data' => [
                'fd' => $fd,
                'userName' => $user->name,
                'id' => $user->id
            ]
        ]);

    }

    /**
     * 转发好友消息
     *
     * @param $userId
     * @param $friendId
     * @param $msg
     */
    public function friendMsg($userId, $friendId, $msg)
    {
        //得到好友的Fd
        $friendFd = app(UserRepository::class)->userIdGetFd($friendId);
        //插入消息
        app(ChatRepository::class)->createMsg($userId, $friendId, $msg);

        //如果当前好友在线想他推送消息
        if (!is_null($friendFd)) {
            $this->send($friendFd, [
                'msg' => 'friendMsg',
                'data' => [
                    'friend_id' => $userId,
                    'friend_fd' => $friendFd,
                    'msg' => $msg
                ]
            ]);
        }
    }

    /**
     * 心跳包处理
     */
    public function heartBeat()
    {
        //todo OR nothing
    }

    /**
     * 客户断开连接消息
     *
     * @param $fd
     */
    public function close($fd)
    {
        $userRepository = app(UserRepository::class);
        //获取用户信息
        $user = $userRepository->fdGetUser($fd);
        //清除这个fd的绑定状态
        $userRepository->clearFd($fd);
        //获得他的所有好友的Fd
        $friendFds = $userRepository->getAllFriendFd($user->id);
        //通知他的好友下线信息
       $this->sendFds($friendFds, [
            'msg' => 'friendOffline',
            'data' => [
                'fd' => $fd,
                'userName' => $user->name,
                'id' => $user->id
            ]
        ]);
    }

    /**
     * 发送消息
     *
     * @param int $fd
     * @param $data
     * @return bool
     */
    public function send(int $fd, $data)
    {
        if (is_array($data)) {
            $data = json_encode($data);
        }
        return static::$ws->push($fd, $data);
    }

    /**
     * 批量发送消息
     *
     * @param array $fds
     * @param $data
     */
    public function sendFds(array $fds, $data)
    {
        if (is_array($data)) {
            $data = json_encode($data);
        }
        foreach ($fds as $fd) {
            static::$ws->push($fd, $data);
        }
    }
}