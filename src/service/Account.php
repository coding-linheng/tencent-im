<?php

/*
 * This file is part of phpunit/php-code-coverage.
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Codelin\TencentIm\service;

/**
 * 腾讯IM Account相关请求
 * Class Account.
 */
class Account extends TencentImService
{
    /**
     * 导入单个用户进入IM系统
     *
     * @param int    $userId   用户id 必须是字符串 INT会报错
     * @param string $nickname 昵称
     * @param string $avatar   头像
     *
     * @return mixed
     */
    public function account_import(int $userId, string $nickname, string $avatar)
    {
        $param = [
            'Identifier' => (string)$userId,
            'Nick'       => $nickname,
            'FaceUrl'    => $avatar,
        ];
        $url = 'im_open_login_svc/account_import';

        return $this->sendPost($url, $param);
    }

    /**
     * 检查账号是否导入.
     *
     * @param array $ids 检查的好友id数组
     *
     * @return mixed
     */
    public function account_check(array $ids)
    {
        $param = [
            'CheckItem' => $ids,
        ];
        $url = 'im_open_login_svc/account_check';

        return $this->sendPost($url, $param);
    }

    /**
     * @param int $userId       用户im id
     * @param array $portraitData 修改数据数组
     */
    public function setPortrait(int $userId, array $portraitData)
    {
        $param = [
            'From_Account' => $userId,
            'ProfileItem'  => $portraitData,
        ];
        $url = '/profile/portrait_set';

        return $this->sendPost($url, $param);
    }

    public function getPortrait($userId, $portraitData)
    {
        $param = [
            'To_Account' => [$userId],
            'TagList'    => $portraitData,
        ];
        $url = '/profile/portrait_get';

        return $this->sendPost($url, $param);
    }
}
