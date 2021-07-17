<?php

namespace TencentIm\service;

use TencentIm\Tencent;
use TencentIm\Http;

/**
 * 腾讯IM相关请求
 * Class TencentImService
 * @package app\service
 */
class TencentImService
{
    private $baseUrl = "https://console.tim.qq.com/v4/";
    private $appid = '1400537488';
    protected $secret = "8d8ee764d3f217e626eabed210ab49a4b7b42ef685cb366bd3fc6c6bb3b3a31c";
    private $identifier = 'administrator';
    private $contenttype = 'json';
    private $userSig = null;


    /**
     * @param $url
     * @param $param
     * @return mixed
     */
    protected function sendPost($url, $param)
    {
        try {
            $this->setAdminSig();
            $post     = sprintf($this->baseUrl . $url . "?sdkappid=%s&identifier=%s&usersig=%s&random=%s&contenttype=%s",
                $this->appid, $this->identifier, $this->userSig, rand(0, 4294967295), $this->contenttype);
            $headers  = ['Content-type: application/json'];
            $options  = [
                CURLOPT_HTTPHEADER => $headers
            ];
            $response = Http::post($post, json_encode($param), $options);
            $data     = json_decode($response, true);
            $path     = ROOT_PATH . "/runtime/log/";
            file_put_contents($path . 'im_request.log', "---------------------------------------------------" . "\r\n",
                FILE_APPEND);
            file_put_contents($path . 'im_request.log', "时间:" . date('Y-m-d H:i:s') . "\r\n", FILE_APPEND);
            file_put_contents($path . 'im_request.log', "请求参数:" . json_encode($param) . "\r\n", FILE_APPEND);
            file_put_contents($path . 'im_request.log', "返回参数:" . json_encode($data) . "\r\n", FILE_APPEND);
            if ($data['ErrorCode'] != 0) {
                throw new \Exception($data['ErrorInfo'], $data['ErrorCode']);
            }
        } catch (\Exception $e) {
            ##记录报错
            $path = ROOT_PATH . "/runtime/log/";
            file_put_contents($path . 'im_err.log', "---------------------------------------------------" . "\r\n", FILE_APPEND);
            file_put_contents($path . 'im_err.log', "时间:" . date('Y-m-d H:i:s') . "\r\n", FILE_APPEND);
            file_put_contents($path . 'im_err.log', "错误代码:" . json_encode($e->getCode()) . "\r\n", FILE_APPEND);
            file_put_contents($path . 'im_err.log', "错误信息:" . json_encode($e->getMessage()) . "\r\n", FILE_APPEND);
        } finally {
            return $data;
        }
    }

    /**
     * 获取管理员签名
     */
    private function setAdminSig()
    {
        ##可以再这里用redis增加一个缓存
        $im            = new Tencent($this->appid, $this->secret);
        $this->userSig = $im->genUserSig($this->identifier);
    }
}
