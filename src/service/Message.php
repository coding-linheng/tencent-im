<?php

namespace TencentIm\service;


/**
 * 腾讯IM Message
 * Class Message
 * @package app\service
 */
class Message extends TencentImService
{

    /**
     * 发送单聊消息
     * @param string $sync 是否同步消息到发送方
     * @param string $to_account 接收人
     * @param array $msg_body 消息体
     * @param string $from_account 指定发送人  为空则单发
     * @param array $offline 离线消息
     * @return mixed
     */
    public function send_msg($sync, $to_account, $msg_body, $from_account = "", $offline = [])
    {
        $param = [
            'SyncOtherMachine' => $sync,
            'To_Account'       => (string)$to_account,
            'MsgRandom'        => rand(0, 1000000),
            'MsgTimeStamp'     => time(),
            'MsgBody'          => $msg_body
        ];
        if (!empty($from_account)) {
            $param = array_merge($param, ['From_Account' => (string)$from_account]);
        }
        if (!empty($offline)) {
            $param = array_merge($param, ['OfflinePushInfo' => $offline]);
        }
        $url = "openim/sendmsg";
        return $this->sendPost($url, $param);
    }

    /**
     * 批量发送单聊消息
     * @param int $sync 是否同步
     * @param array $to_account 接收人
     * @param array $msg_body 消息体
     * @return mixed
     */
    public function batchSendMsg(int $sync, array $to_account, array $msg_body)
    {
        $param = [
            'SyncOtherMachine' => $sync,
            'To_Account'       => $to_account,
            'MsgRandom'        => rand(0, 1000000),
            'MsgTimeStamp'     => time(),
            'MsgBody'          => $msg_body
        ];
        $url   = "openim/batchsendmsg";
        return $this->sendPost($url, $param);
    }

    /**
     * @param string $type 消息类型
     * @param array $message 消息包体
     * @param string $desc 简介
     * @return array|array[]
     */
    public function formatMessage($type, $message, $desc)
    {
        switch ($type) {
            case 'text':
                $type        = "TIMTextElem";
                $messageBody = [
                    'Text' => $message
                ];
                break;
            case 'custom':
                $type        = "TIMCustomElem";
                $messageBody = [
                    'Data' => $message,
                    'Desc' => $desc
                ];
                break;
            default:
                return [];
        }
        return [
            [
                "MsgType"    => $type,
                "MsgContent" => $messageBody
            ]
        ];
    }
}