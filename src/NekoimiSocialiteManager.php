<?php
/**
 * ----------------------------------------------------------------------
 *              nekoimi <i@sakuraio.com>
 *                                          ------
 *   Copyright (c) 2017-2019 https://nekoimi.com All rights reserved.
 * ----------------------------------------------------------------------
 */
namespace Nekoimi\LumenSocialite;

use Overtrue\Socialite\SocialiteManager;
use Symfony\Component\HttpFoundation\Request;

class NekoimiSocialiteManager extends SocialiteManager
{
    /**
     * @var array
     */
    protected $initialDrivers = [
        'weibo'  => 'Weibo',
        'qq'     => 'QQ',
        'wechat' => 'WeChat',
    ];

    /**
     * @return Request
     */
    protected function createDefaultRequest()
    {
        return Request::createFromGlobals();
    }
}
