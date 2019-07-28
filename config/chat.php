<?php

return [
    'listen_ip'                => env('CHAT_LISTEN_IP', '0.0.0.0'),
    'listen_port'              => env('CHAT_LISTEN_PORT', 9200),
    'socket_type'              => defined('SWOOLE_SOCK_TCP') ? SWOOLE_SOCK_TCP : 1,
    'settings'=>[
        'daemonize'=>false,
//        'ssl_cert_file'=>'', //开启证书文件地址
//        'ssl_key_file'=>'',//密匙, 写入这2个将开启https
        'dispatch_mode'      => 2,
        'reactor_num'        => function_exists('swoole_cpu_num') ? swoole_cpu_num() * 2 : 4,
        'worker_num'         => function_exists('swoole_cpu_num') ? swoole_cpu_num() * 2 : 8,
        'task_max_request'   => 8000,
        'max_request'        => 8000,
        'open_tcp_nodelay'   => true,
        'pid_file'           => storage_path('chat.pid'),
        'buffer_output_size' => 2 * 1024 * 1024,
        'socket_buffer_size' => 128 * 1024 * 1024,


        /**
         * More settings of Swoole
         * @see https://wiki.swoole.com/wiki/page/274.html  Chinese
         * @see https://www.swoole.co.uk/docs/modules/swoole-server/configuration  English
         */
    ]
];