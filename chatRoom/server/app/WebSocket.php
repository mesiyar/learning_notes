<?php
/**
 * Created by PhpStorm.
 * User: eddie
 * Date: 2019/10/31
 * Time: 下午9:13
 */
use Swoole\WebSocket\Server;

class WebSocket
{
    private $_host = '0.0.0.0';

    private $_port = 8888;

    private $_server;

    public function __construct()
    {
        $this->_server = new Server($this->_host, $this->_port);
        $this->_server->set(['daemonize' => 0, 'worker_num' => 4, 'max_request' => 10000,//'task_worker_num' => 4,
        ]);

        $this->_server->on("start", [$this, 'onStart']);

        $this->_server->on("message", [$this, 'onMessage']);

    }

    public function onMessage(Server $server, $frame)
    {
        var_dump($server->connections);
        echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        foreach ($server->connections as $fd) {
            if($fd== $frame->fd) continue;
            $server->push($fd, $frame->data);
        }

    }


    public function onStart()
    {
        echo "server is running at http://{$this->_host}:{$this->_port}\n";
    }

    public function start()
    {
        $this->_server->start();
    }

}