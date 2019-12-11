<?php
/**
 * ----------------------------------------------------------------------
 *              nekoimi <i@sakuraio.com>
 *                                          ------
 *   Copyright (c) 2017-2019 https://nekoimi.com All rights reserved.
 * ----------------------------------------------------------------------
 */
namespace Nekoimi\LumenSocialite;

use InvalidArgumentException;
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
     * Create a new driver instance.
     *
     * @param string $driver
     * @return \Overtrue\Socialite\ProviderInterface
     */
    protected function createDriver($driver)
    {
        if (isset($this->initialDrivers[$driver])) {
            $provider = $this->initialDrivers[$driver];
            $provider = 'Nekoimi\\LumenSocialite\\Providers\\'.$provider.'Provider';

            return $this->buildProvider($provider, $this->formatConfig($this->config->get($driver)));
        }

        if (isset($this->customCreators[$driver])) {
            return $this->callCustomCreator($driver);
        }

        throw new InvalidArgumentException("Driver [$driver] not supported.");
    }

    /**
     * @return Request
     */
    protected function createDefaultRequest()
    {
        return Request::createFromGlobals();
    }
}
