<?php

namespace TencentIm\service;


/**
 * 腾讯IM Account相关请求
 * Class Account
 * @package app\service
 */
class Account extends TencentImService
{
    /**
     * 导入单个用户进入IM系统
     * @param int $userId 用户id 必须是字符串 INT会报错
     * @param string $nickname 昵称
     * @param string $avatar 头像
     * @return mixed
     */
    public function account_import($userId, $nickname, $avatar)
    {
        $param = [
            'Identifier' => (string)$userId,
            'Nick'       => $nickname,
            'FaceUrl'    => $avatar
        ];
        $url   = "im_open_login_svc/account_import";
        return $this->sendPost($url, $param);
    }

    /**
     * 检查账号是否导入
     * @param array $ids 检查的好友id数组
     * @return mixed
     */
    public function account_check($ids)
    {
        $param = [
            'CheckItem' => $ids
        ];
        $url   = "im_open_login_svc/account_check";
        return $this->sendPost($url, $param);
    }
}