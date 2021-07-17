<?php

namespace Codelin\TencentIm\service;


/**
 * 腾讯IM Chatroom相关请求
 * Class Chatroom
 * @package app\service
 */
class Chatroom extends TencentImService
{

    /**
     * @param string $userId 群主uid
     * @param string $type 群类型
     * @param string $name 群名称
     * @param array $extend 扩展参数
     * @return mixed
     */
    public function create_group($userId, $type, $name, $extend = [])
    {
        $param = [
            'Owner_Account' => (string)$userId,
            'Type'          => $type ?? "ChatRoom",
            'Name'          => $name,
            'GroupId'       => substr(date('ymdhis') . rand(1, 999999), 3, 9),
        ];
        if (!empty($extend)) {
            $param = array_merge($param, $extend);
        }
        $url = "group_open_http_svc/create_group";
        return $this->sendPost($url, $param);
    }

    /**
     * @param string $groupId 群组id
     * @param array $member 添加成员
     * @param int $silence 静默方式
     * @return mixed
     */
    public function addGroupMember($groupId, $member, $silence = 0)
    {
        $param = [
            'GroupId'    => $groupId,
            'MemberList' => $member,
            'Silence'    => $silence
        ];
        $url   = "group_open_http_svc/add_group_member";
        return $this->sendPost($url, $param);
    }

    public function deleteGroupMember($groupId, $member, $silence = 1)
    {
        $param = [
            'GroupId'             => $groupId,
            'MemberToDel_Account' => $member,
            'Silence'             => $silence
        ];
        $url   = "group_open_http_svc/delete_group_member";
        return $this->sendPost($url, $param);
    }

    public function destroyGroup($groupId)
    {
        $param = [
            'GroupId' => $groupId,
        ];
        $url   = "group_open_http_svc/destroy_group";
        return $this->sendPost($url, $param);
    }

    /**
     * 转让群主
     * @param string $groupId 群id
     * @param string $userId 新群主id
     * @return mixed
     */
    public function changeGroupOwner($groupId, $userId)
    {
        $param = [
            'GroupId'          => $groupId,
            'NewOwner_Account' => $userId,
        ];
        $url   = "group_open_http_svc/change_group_owner";
        return $this->sendPost($url, $param);
    }

    /**
     * 修改群内人员设置
     * @param string $groupId 群主id
     * @param string $userId 要操作的人
     * @param string $role 设置权限 Admin设置管理员 Member取消管理员
     * @param int $time 禁言时间 默认为0不禁言
     * @param array $extend 扩展参数
     * @return mixed
     */
    public function modifyGroupMemberInfo($groupId, $userId, $role, $time = 0, $extend = [])
    {
        $param = [
            'GroupId'        => $groupId,
            'Member_Account' => $userId,
            'Role'           => $role,
            'ShutUpTime'     => $time,
        ];
        $param = array_merge($param, $extend);
        $url   = "group_open_http_svc/modify_group_member_info";
        return $this->sendPost($url, $param);
    }
}