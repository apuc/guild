<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 15.11.18
 * Time: 17:37
 */

namespace common\hhapi\core\request;


use Exception;

trait Request
{
    public $url;
    private $params;

    public function parseUrl($url, $method = 'get')
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; tr-TR) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27');
        if ($method === 'post') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getPostParams());
        }
        $res = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($res);
//        if ($res->http_code == '404') {
//            throw new Exception('User not found!', 404);
//        }
//        if ($res->http_code == '403') {
//            throw new Exception('Bad token!', 403);
//        }
        return $res;
    }

    public function baseRequest($path)
    {
        $this->url = 'https://api.hh.ru/' . $path;
        return $this;
    }

    public function addParams($params)
    {
        if ($params) {
            $this->params = $params;
            $i = 0;
            foreach ((array)$params as $key => $param) {
                $s = ($i === 0) ? '?' : '&';
                $this->url .= $s . $key . '=' . $param;
                $i++;
            }
        }
        return $this;
    }

    private function getPostParams()
    {
        $params = '';
        if ($this->params) {
            foreach ((array)$this->params as $key => $param) {
                $params .= $key . '=' . $param . '&';
            }
            $params = mb_substr($params, 0, -1);
        }
        return $params;
    }

    public function get()
    {
        return $this->parseUrl($this->url);
    }

    public function post()
    {
        return $this->parseUrl($this->url, 'post');
    }


}