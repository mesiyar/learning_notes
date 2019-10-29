<?php
/**
 * Created by PhpStorm.
 * User: eddie
 * Date: 2018/3/5
 * Time: 10:37
 */

/**
 * 监控一个目录下的文件变化的函数
 * Class FileWatch
 */
class FileWatch
{

    protected $all = array();

    public function __construct($dir)
    {
        $this->watch($dir);
    }

    //子类中重写这个方法
    public function run($file)
    {
    }

    protected function all_file($dir)
    {
        if (is_file($dir)) {
            $this->all[$dir] = md5_file($dir);
            return $this->all;
        }
        if (is_dir($dir)) {
            $open = opendir($dir);
            while (($file = readdir($open)) !== false) {
                if ($file != "." && $file != "..") {
                    $f = $dir . "/" . $file;
                    if (is_file($f)) {
                        $this->all[$f] = md5_file($f);
                    } elseif (is_dir($f)) {
                        $this->all_file($f);
                    }

                }
            }
        }
        return $this->all;
    }

    public function watch($dir)
    {
        $this->all = array();
        $old = $this->all_file($dir);
        while (true) {
            sleep(2);
            $this->all = array();
            $new = $this->all_file($dir);
            $re = array_diff($new, $old);
            $del = array_diff_key($old, $new);
            $re = array_merge($re, $del);
            if ($re) {
                $this->all = array();
                $old = $this->all_file($dir);
                $file = array_keys($re);
                $this->run($file[0]);
            }
        }
    }
}
//使用方法
class mywatch extends FileWatch
{
    public function run($file)
    {
        if(!empty($file)) {
            echo "new file or file has been changed with ".$file.PHP_EOL;
            echo "please choose 1 or 0 to upload files or skip ".PHP_EOL;
            $fileName = explode('/', $file);

            while (true) {
                $a = trim(fgets(STDIN));
                if(ctype_digit($a)) {
                    echo $a.PHP_EOL;
                    if($a == 1) {
                        //上传文件
                        echo "you choose upload files ".PHP_EOL;
                        // 判断系统
                        switch (PHP_OS) {
                            //linux 需要用scp 命令
                            case 'Linux':
                                exec('scp '.$file.' root@192.168.1.21:/home/'.$file);
                                break;
                            case 'WINNT':
                                exec('PSCP.exe '.$file.' root@192.168.1.21:/home/'.end($fileName));
                                break;
                            case 'Darwin':
                                //mac
                        }
                        break;
                    } else {
                        //不管 跳过
                        echo "you choose skip ".PHP_EOL;
                        break;
                    }
                } else {
                    echo 'please enter 0 or 1'.PHP_EOL;
                }
            }
        } else {
            echo "no files has created and no files has been changed".PHP_EOL;
        }
    }
}
echo 'Your System is '.PHP_OS.PHP_EOL;
echo "Welcome to use fileWatch System".PHP_EOL;
$watch = new mywatch("./");