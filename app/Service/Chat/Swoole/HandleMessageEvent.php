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
        return static::$ws->send($fd, $data);
    }
}