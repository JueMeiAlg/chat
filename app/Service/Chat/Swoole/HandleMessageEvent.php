<?php


namespace App\Service\Chat\Swoole;


use App\Models\User;
use Swoole\WebSocket\Server;

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
     * 绑定Fd
     *
     * @param $userId
     * @param $fd
     */
    public function bindFd($userId, $fd)
    {
        User::query()
            ->where('id', $userId)
            ->update([
                'fd' => $fd
            ]);

        $this->send($fd, [
            'msg' => 'OK',
            'code' => 0
        ]);

        //通知他的好友上线信息
        $fds = User\UserFriend::query()
            ->with('friend:id,fd')
            ->where('user_id', $userId)
            ->get()
            ->pluck('friend')
            ->pluck('fd')->reject(function ($value) {
                return is_null($value);
            })->values()->toArray();

        $this->sendFds($fds, [
            'msg' => 'friendOnline',
            'data' => [
                'fd' => $fd
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