<?php


namespace App\Service\Chat\Swoole;

use Swoole\WebSocket\Server;
use Swoole\WebSocket\Frame;

class HandleEvent
{
    public function OnOpen(Server $ws, $request)
    {
        
    }

    public function OnMessage(Server $ws, Frame $frame)
    {
        
    }

    public function OnClose(Server $ws, int $fd)
    {
        
    }
}