<?php
/**
 * ----------------------------------------------------------------------
 *              nekoimi <i@sakuraio.com>
 *                                          ------
 *   Copyright (c) 2017-2019 https://nekoimi.com All rights reserved.
 * ----------------------------------------------------------------------
 */
namespace Nekoimi\LumenSocialite;

use Illuminate\Support\Facades\Facade;

class NekoimiSocialite extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'Nekoimi\LumenSocialite\NekoimiSocialiteManager';
    }
}
