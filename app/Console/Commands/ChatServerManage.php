<?php

namespace App\Console\Commands;

use App\Service\Chat\Swoole\HandleEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Swoole\Process;
use Swoole\WebSocket\Server;

class ChatServerManage extends Command
{
    /**
     * 启动命令
     *
     * @var string
     */
    protected $signature = 'chat {action? : start|stop|restart}
    {--d : 以守护进程方式"启动或重启chat"}
    {--h : 查看支持的命令"}';

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
        $help = $this->option('h');
        if ($help) {
          $this->outputHelp();
            return;
        }
        
        $action = $this->argument('action');
        $option = $this->option('d');


        if (is_null($action)) {
            $action = $this->choice('选择具体执行的命令?', ['start', 'stop', 'restart'], 2);
            if ($option == false) {
                $option = $this->choice('是否以守护进程模式运行?', ['true', 'false'], 0);
            }
        }

        if ($option === 'false' || $option === false) {
            config(['chat.settings.daemonize' => false]);
        } else {
            config(['chat.settings.daemonize' => true]);
        }

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

    /**
     * 启动服务
     */
    public function start()
    {
        //步骤条
        $bar = $this->output->createProgressBar(3);
        $bar->advance();//步骤1
        $this->setSwoole();

        $bar->advance();//步骤2
        $event = new HandleEvent();
        $this->swoole->on('Open', [$event, 'OnOpen']);
        $this->swoole->on('Message', [$event, 'OnMessage']);
        $this->swoole->on('Close', [$event, 'OnClose']);
        $this->swoole->on('ManagerStart', [$event, 'onManagerStart']);
        $this->swoole->on('WorkerStart', [$event, 'onWorkerStart']);
        $this->swoole->on('WorkerError', [$event, 'onWorkerError']);
        $this->swoole->on('Start', [$event, 'onStart']);

        $bar->advance();//步骤3
        echo PHP_EOL;
        $this->info('服务已启动!');
        $this->swoole->start();
    }

    /**
     * 停止服务
     *
     * @return int
     */
    public function stop()
    {
        $pidFile = config('chat.settings.pid_file');

        if (!file_exists($pidFile)) {
            $this->warn('chat好像没有在运行');
            return 0;
        }

        $pid = file_get_contents($pidFile);

        if (self::kill($pid, 0)) {
            if (self::kill($pid, SIGTERM)) {
                // 确保主进程退出
                $time = 1;
                $waitTime = 60;
                $this->info("The max time of waiting to forcibly stop is {$waitTime}s.");
                while (self::kill($pid, 0)) {
                    if ($time > $waitTime) {
                        $this->warn("Swoole [PID={$pid}] cannot be stopped gracefully in {$waitTime}s, will be stopped forced right now.");
                        return 1;
                    }
                    $this->info("Waiting Swoole[PID={$pid}] to stop. [{$time}]");
                    sleep(1);
                    $time++;
                }
                if (file_exists($pidFile)) {
                    unlink($pidFile);
                }
                $this->info("Swoole [PID={$pid}] is stopped.");
                return 0;
            } else {
                $this->error("Swoole [PID={$pid}] is stopped failed.");
                return 1;
            }
        } else {
            $this->warn("Swoole [PID={$pid}] does not exist, or permission denied.");
            return 0;
        }

    }

    /**
     * 重启服务
     *
     * @return int|void
     */
    public function restart()
    {
        $code = $this->stop();
        if ($code !== 0) {
            return $code;
        }
        return $this->start();
    }

    /**
     * 设置初始化swoole
     *
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

    /**
     * 终止进程
     *
     * @param $pid
     * @param $sig
     * @return bool
     */
    public static function kill($pid, $sig)
    {
        try {
            return Process::kill($pid, $sig);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 输出命令帮助
     */
    public function outputHelp()
    {
        $headers = ['命令名称', '指令'];
        $users = [
            ['启动服务', 'php artisan chat start'],
            ['停止服务', 'php artisan chat stop'],
            ['重启服务', 'php artisan chat restart'],
            ['守护进程的形式启动', 'php artisan chat start --d'],
            ['守护进程的形式重启', 'php artisan chat restart --d'],
            ['查看支持的命令', 'php artisan chat --h'],
        ];
        $this->table($headers, $users);
    }
}
