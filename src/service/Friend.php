<?php

namespace TencentIm\service;


/**
 * 腾讯IM Friend
 * Class Friend
 * @package app\service
 */
class Friend extends TencentImService
{
    /**
     * 添加好友
     * @param string $user_id 添加者
     * @param string $add_id 被添加者
     * @return mixed
     */
    public function friend_add($user_id, $add_id)
    {
        $param = [
            'From_Account'  => (string)$user_id,
            'AddFriendItem' => [
                [
                    'To_Account' => (string)$add_id,
                    'AddSource'  => "AddSource_Type_Follow",
                    'GroupName'  => "朋友",
                    'AddWording' => '互相关注成为新朋友,快发起语音聊聊吧'
                ]
            ],
            "ForceAddFlags" => 1
        ];
        $url   = "sns/friend_add";
        return $this->sendPost($url, $param);
    }

    public function friend_get($user_id)
    {
        $param = [
            'From_Account' => $user_id,
            'StartIndex'   => 0
        ];
        $url   = "sns/friend_get";
        return $this->sendPost($url, $param);
    }
}