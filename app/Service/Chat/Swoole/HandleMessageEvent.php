<?php


namespace App\Service\Chat\Swoole;


use App\Models\Chat\ChatMsgRecord;
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
        $user = User::query()
            ->where('id', $userId)
            ->first();
        $user->update([
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
                'fd' => $fd,
                'userName' => $user->name,
                'id' => $user->id
            ]
        ]);

    }

    /**
     * 转发好友消息
     */
    public function friendMsg($userId, $friendId, $msg)
    {
        //得到好友的Fd
        $friendFd = User::query()
            ->where('id', $friendId)
            ->first()
            ->fd;

        //插入消息,双方消息反插
        ChatMsgRecord::query()->create([
            'msg' => $msg,
            'friend_id' => $friendId,
            'user_id' => $userId,
        ]);
        ChatMsgRecord::query()->create([
            'msg' => $msg,
            'friend_id' => $userId,
            'user_id' => $friendId,
        ]);

        //如果当前好友在线想他推送消息
        if (!is_null($friendFd)) {
            $this->send($friendFd, [
                'msg' => 'friendMsg',
                'data' => [
                    'friend_id' => $userId,
                    'friend_fd' => $friendFd,
                    'msg'=>$msg
                ]
            ]);
        }
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