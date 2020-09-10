<?php

//namespace delayList;

class DelayList
{
    const REDIS_DELAY_KEY = 'redis_delay_key';

    const EXPIRE_TIME = 20;// s
    static $job_id = 0;
    /**
     * @var \Redis
     */
    private $redis = null;

    public function initRedis()
    {
        if (is_null($this->redis)) {
            $this->redis = new \Redis();
            $this->redis->connect('127.0.0.1');
        }
    }

    public function __construct()
    {
        $this->initRedis();
    }

    public function push($msg = 'a')
    {
        $ttr = time() + self::EXPIRE_TIME;
        self::$job_id++;
        $data = [
            'job_id' => self::$job_id,
            'job_type' => 1,
            'ttr' => $ttr,
            'job_info' => $msg
        ];
        $encode = json_encode($data, JSON_UNESCAPED_UNICODE);
        echo "压入队列 {$encode}".PHP_EOL;
        $this->redis->lPush(self::REDIS_DELAY_KEY, $encode);
    }

    public function run()
    {
        echo "开始进行任务".PHP_EOL;
        while (true) {
            $val = $this->redis->brPop(self::REDIS_DELAY_KEY, 1800);
            echo "获取到任务信息 {$val[1]}".PHP_EOL;
            $val = json_decode($val[1], true);
            $ttr = $val['ttr'];
            $sleep = $ttr - time();
            if($sleep > 0 ) {
                sleep($sleep);
            } else {
                echo "消息已过期".PHP_EOL;
                continue;
            }

            echo "job_id [{$val['job_id']} job_msg[{$val['job_info']}]".PHP_EOL;
        }
    }
}