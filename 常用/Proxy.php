<?php

/**
 * http 代理服务器
 * Class Proxy
 */
class Proxy
{
    // 允许访问的ip
    private $_allowIps = [];

    // 代理到的地址
    private $_proxyAddr = '';

    /**
     * Proxy constructor.
     * @param string $proxyAddr 代理地址
     * @param array $allowIps 允许访问的ip
     * @throws Exception
     */
    public function __construct($proxyAddr = '', $allowIps = [])
    {
        if (empty($proxyAddr)) {
            throw new Exception("请配置代理地址!");
        }

        if (!$this->checkAddress($proxyAddr)) {
            throw new Exception("代理地址不合法请检查!");
        }

        $this->_proxyAddr = $proxyAddr;
        $this->_allowIps = $allowIps;
        if (!$this->checkIp()) {
            throw new Exception("非法访问!");
        }
    }

    public function run()
    {
        $_REQUEST['url'] = $this->getRequestUrl();
        $_REQUEST['url'] = str_replace('/test', '', $_REQUEST['url']);
        $ip = $_SERVER[''];
        $aAccess = curl_init();
        // --------------------
        // 设置curl
        curl_setopt($aAccess, CURLOPT_URL, $_REQUEST['url']);
        curl_setopt($aAccess, CURLOPT_HEADER, true);
        curl_setopt($aAccess, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($aAccess, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($aAccess, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($aAccess, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($aAccess, CURLOPT_TIMEOUT, 60);
        curl_setopt($aAccess, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($aAccess, CURLOPT_PROXY, $ip . ':80');

        if (!empty($_SERVER['HTTP_REFERER']))
            curl_setopt($aAccess, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);


        $headers = $this->getClientHeader();
        curl_setopt($aAccess, CURLOPT_HTTPHEADER, $headers);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            curl_setopt($aAccess, CURLOPT_POST, 1);
            curl_setopt($aAccess, CURLOPT_POSTFIELDS, http_build_query($_POST));
        }

        // 执行请求
        $sResponse = curl_exec($aAccess);
        list($headerstr, $sResponse) = $this->parseHeader($sResponse);
        $headarr = explode("\r\n", $headerstr);
        foreach ($headarr as $h) {
            if (strlen($h) > 0) {
                if (strpos($h, 'Content-Length') !== false) continue;
                if (strpos($h, 'Transfer-Encoding') !== false) continue;
                if (strpos($h, 'Connection') !== false) continue;
                if (strpos($h, 'HTTP/1.1 100 Continue') !== false) continue;
                header($h);
            }
        }

        // 关闭请求,释放资源
        curl_close($aAccess);
        echo $sResponse;
    }

    /**
     * 校验地址合法性
     * @param $url
     * @return bool
     */
    private function checkAddress($url): bool
    {
        $reg = "/http[s]?:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is";

        if (preg_match($reg, $url)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 校验ip地址
     * @return bool
     */
    private function checkIp(): bool
    {
        if ($this->_allowIps) {
            $ip = $this->getIp();
            foreach ($this->_allowIps as $filter) {
                if ($filter === '*' || $filter === $ip || (($pos = strpos($filter, '*')) !== false && !strncmp($ip, $filter, $pos))) {
                    return true;
                }
            }
            return false;
        }
        return true;
    }

    /**
     * 获取客户端ip
     *
     * @return array|false|string
     */
    private function getIp()
    {
        if (getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
        else $ip = "Unknow";
        return $ip;
    }

    /**
     * @return string
     */
    private function getRequestUrl(): string
    {
        //缓存结果，同一个request不重复计算
        static $gtrooturl;
        if (empty($gtrooturl)) {
            $uri = $_SERVER['REQUEST_URI'];
            $uriArr = explode('/', $uri);
            $uriArr = array_filter($uriArr);
//            if($uriArr[0] != 'manager') {
//                exit('非法访问!');
//            }
            $gtrooturl = $this->_proxyAddr . $uri;
        }
        return $gtrooturl;
    }

    /**
     * 解析header
     * @param $sResponse
     * @return array|mixed
     */
    private function parseHeader($sResponse): array
    {
        list($headerstr, $sResponse) = explode("\r\n\r\n", $sResponse, 2);
        $ret = array($headerstr, $sResponse);
        if (preg_match('/^HTTP\/1\.1 \d{3}/', $sResponse)) {
            $ret = $this->parseHeader($sResponse);
        }
        return $ret;
    }

    /**
     * 请求头的回调
     * @param $str
     * @return string
     */
    public function headerCallback($str): string
    {
        return strtoupper($str[0]);
    }

    /**
     * 获取客户端的请求头
     * @return array
     */
    private function getClientHeader(): array
    {
        $headers = [
            'out-exam:true'
        ];
        foreach ($_SERVER as $k => $v) {
            if (strpos($k, 'HTTP_') === 0) {
                $k = strtolower(preg_replace('/^HTTP/', '', $k));
                $k = preg_replace_callback('/_\w/', [$this, 'headerCallback'], $k);
                $k = preg_replace('/^_/', '', $k);
                $k = str_replace('_', '-', $k);
                if ($k == 'Host') continue;
                $headers[] = "$k:$v";
            }
        }
        return $headers;
    }
}
