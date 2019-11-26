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
        echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        $data = json_decode($frame->data, true);
        var_dump($data);
        if (!is_array($data)) {
            $server->push($frame->fd, $this->encode(['code' => '0', 'msg' => '消息格式不正确']));
        } else {
            switch ($data['type']) {
                case 1:
                    $return = $this->validateLoginInfo($data['data']);
                    if ($return === true) {
                        $server->push($frame->fd, $this->encode([
                            'code' => 200,
                            'msg' => '登陆成功',
                            'msg_type' => 'login',
                            'data' => [
                                'username' => $data['data']['username'],
                                'fd' => $frame->fd
                            ],
                        ]));

                        $send = [
                            'code' => 200,
                            'msg' => '登陆成功',
                            'msg_type' => 'online',
                            'data' => [
                                'username' => $data['data']['username'],
                                'fd' => $frame->fd
                            ],
                        ];
                        foreach ($server->connections as $fd) {
                            if ($fd == $frame->fd) continue;
                            $server->push($fd, $this->encode($send));
                        }
                    } else {
                        $server->push($frame->fd, $this->encode($return));
                    }
                    break;
                case 2:
                    $send = [
                        'code' => 200,
                        'msg_type' => 'msg',
                        'data' => [
                            'msg' => $data['data']['msg']
                        ],
                    ];
                    foreach ($server->connections as $fd) {
                        if ($fd == $frame->fd) continue;
                        $server->push($fd, $this->encode($send));
                    }
                    break;
                default:
                    break;
            }
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

    private function encode(array $data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    private function validateLoginInfo($data)
    {
        $username = $data['username'] ?? false;

        $password = $data['password'] ?? false;

        if (!$username || !$password) {
            return ['code' => 0, 'msg' => '请输入登陆信息！'];
        }
        $sql = "select username,password_hash from chat_users where username = '{$username}'";
        $user = $this->mysql($sql);
        if ($user) {
            if ($user['password_hash'] == $this->encryptPassword($password)) {
                return true;
            } else {
                return ['code' => 0, 'msg' => '密码不正确'];
            }
        } else {
            $password = $this->encryptPassword($password);
            $time = time();
            $sql = "insert into chat_users (username, password_hash, created_at, updated_at) values('$username','{$password}',{$time}, {$time})";
            $result = $this->mysql($sql);
            if ($result) {
                return true;
            } else {
                return ['code' => '0', 'msg' => '数据插入失败！',];
            }
        }

    }

    private function mysql(string $sql)
    {
        $swoole_mysql = new Swoole\Coroutine\MySQL();
        $swoole_mysql->connect(['host' => '127.0.0.1', 'port' => 3306, 'user' => 'root', 'password' => 'A123456', 'database' => 'sw_chat',]);
        $res = $swoole_mysql->query($sql);
        return $res;
    }

    private function encryptPassword($password)
    {
        return md5(md5($password));
    }

}