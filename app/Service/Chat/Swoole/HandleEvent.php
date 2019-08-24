<?php


namespace App\Service\Chat\Swoole;

use Illuminate\Support\Facades\App;
use Swoole\Http\Request;
use Swoole\WebSocket\Server;
use Swoole\WebSocket\Frame;

class HandleEvent
{
    /**
     * 当链接建立时,事件处理
     *
     * @param \Swoole\WebSocket\Server $ws wsk服务实例
     * @param \Swoole\Http\Request $request 当前请求实例
     */
    public function OnOpen(Server $ws, Request $request)
    {
        //发送fd绑定消息
        $ws->push($request->fd, json_encode([
            'code' => 0,
            'msg' => 'bindFd',
            'data' => [
                'fd' => $request->fd
            ]
        ]));
    }

    /**
     * 当客户端发送来消息时事件处理函数
     *
     * @param \Swoole\WebSocket\Server $ws wsk实例
     * @param \Swoole\WebSocket\Frame $frame [int fd, string data, int opcode, bool finish]
     */
    public function OnMessage(Server $ws, Frame $frame)
    {
        $request = json_decode($frame->data, true);
        HandleMessageEvent::setWs($ws);
        //已msg作为函数名 data中的数据作为参数,实现一个简单的路由调用
        App::call(HandleMessageEvent::class . '@' . $request['msg'], $request['data'] ?? []);
    }

    /**
     * 当链接断开时处理函数
     *
     * @param \Swoole\WebSocket\Server $ws wsk实例
     * @param int $fd 客户编号
     */
    public function OnClose(Server $ws, int $fd)
    {
        HandleMessageEvent::setWs($ws);
        App::call(HandleMessageEvent::class . '@close', ['fd' => $fd]);
    }

    /**
     * 启动事件
     *
     * @param \Swoole\WebSocket\Server $server
     */
    public function onStart(Server $server)
    {
        foreach (spl_autoload_functions() as $function) {
            spl_autoload_unregister($function);
        }
        //设置进程名称方便辨认
        swoole_set_process_name('chat: master process');
        //记录Pid用于重启或者停止进程
        file_put_contents(config('chat.settings.pid_file'), $server->master_pid);
    }

    /**
     * 当前管理进程启动的时候,设置进程标识
     *
     * @param \Swoole\WebSocket\Server $server
     */
    public function onManagerStart(Server $server)
    {
        //设置进程名称方便辨认
        swoole_set_process_name('chat: manager process');
    }

    /**
     * 当工作进程启动的,设置不同的进程标识,清除代码缓存
     *
     * @param \Swoole\WebSocket\Server $server
     * @param                          $workerId
     */
    public function onWorkerStart(Server $server, $workerId)
    {
        if ($workerId >= $server->setting['worker_num']) {
            $process = 'task worker';
        } else {
            $process = 'worker';
        }
        swoole_set_process_name(sprintf('chat: %s process %d', $process, $workerId));

        /**
         * 清除代码缓存
         */
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }
        if (function_exists('apc_clear_cache')) {
            apc_clear_cache();
        }
        //清除文件状态
        clearstatcache();
    }

    /**
     * work进程发送错误输出错误信息
     *
     * @param \Swoole\WebSocket\Server $server
     * @param                          $workerId
     * @param                          $workerPId
     * @param                          $exitCode
     * @param                          $signal
     */
    public function onWorkerError(Server $server, $workerId, $workerPId, $exitCode, $signal)
    {
        $format = "\033[31;31m%s\033[0m";
        $format .= PHP_EOL;
        printf($format, sprintf('worker[%d] error: exitCode=%s, signal=%s', $workerId, $exitCode, $signal));
    }
}