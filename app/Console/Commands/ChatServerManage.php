<?php

namespace App\Console\Commands;

use App\Service\Chat\Swoole\HandleEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Swoole\WebSocket\Server;

class ChatServerManage extends Command
{
    /**
     * 启动命令
     *
     * @var string
     */
    protected $signature = 'chat {action? : start|stop|restart}
    {--d : 以守护进程方式"启动或重启chat"}';

    /**
     * 程序描述
     *
     * @var string
     */
    protected $description = 'Chat管理器';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 用户输入的选项
     *
     * @var string
     */
    protected $option;

    /**
     * swooleWSK服务实例
     *
     * @var \swoole_websocket_server;
     */
    protected $swoole;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument('action');
        $this->option = $this->option('d');
        if (is_null($action)) {
            $action = $this->choice('选择具体执行的命令?', ['start', 'stop', 'restart'], 2);
            if ($this->option == false) {
                $this->option = $this->choice('是否以守护进程模式运行?', ['true', 'false'], 0);
            }
            if ($this->option == 'false') {
                config(['chat.settings.daemonize' => false]);
            } else {
                config(['chat.settings.daemonize' => true]);
            }
        }

        $this->setSwoole();

        switch ($action) {
            case 'start':
                $this->start();
                break;
            case 'stop':
                $this->stop();
                break;
            case 'restart':
                $this->restart();
                break;
        }
    }

    public function start()
    {
        $event = new HandleEvent();
        $this->swoole->on('Open', [$event, 'OnOpen']);
        $this->swoole->on('Message', [$event, 'OnMessage']);
        $this->swoole->on('Close', [$event, 'OnClose']);
        $this->info('服务已启动!');
        $this->swoole->start();
    }

    public function stop()
    {

    }

    public function restart()
    {

    }

    /**
     * 设置初始化swoole
     *
     * @param $swoole
     */
    public function setSwoole()
    {
        $ip = config('chat.listen_ip');
        $port = config('chat.listen_port');
        $socketType = config('chat.socket_type');
        $settings = config('chat.settings');

        //是否开启https
        if (isset($settings['ssl_cert_file'], $settings['ssl_key_file'])) {
            $this->swoole = new Server($ip, $port, SWOOLE_PROCESS, $socketType | SWOOLE_SSL);
        } else {
            $this->swoole = new Server($ip, $port, SWOOLE_PROCESS, $socketType);
        }

        $this->swoole->set($settings);

        app()->singleton('swoole', function () {
            return $this->swoole;
        });
    }
}
