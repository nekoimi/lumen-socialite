<?php
/**
 * ----------------------------------------------------------------------
 *              nekoimi <i@sakuraio.com>
 *                                          ------
 *   Copyright (c) 2017-2019 https://nekoimi.com All rights reserved.
 * ----------------------------------------------------------------------
 */
namespace Nekoimi\LumenSocialite;

use Illuminate\Support\ServiceProvider;

class LumenServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the provider.
     */
    public function register()
    {
        $this->app->singleton(NekoimiSocialiteManager::class, function ($app) {
            $config = array_merge(config('socialite', []));

            return new NekoimiSocialiteManager($config, $app->make('request'));
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [NekoimiSocialiteManager::class];
    }
}
