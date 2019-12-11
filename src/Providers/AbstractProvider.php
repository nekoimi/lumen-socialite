<?php
/**
 * ----------------------------------------------------------------------
 *              nekoimi <i@sakuraio.com>
 *                                          ------
 *   Copyright (c) 2017-2019 https://nekoimi.com All rights reserved.
 * ----------------------------------------------------------------------
 */
namespace Nekoimi\LumenSocialite\Providers;

use Overtrue\Socialite\AccessTokenInterface;
use Overtrue\Socialite\InvalidStateException;
use Overtrue\Socialite\Providers\AbstractProvider as BaseProvider;
use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class AbstractProvider extends BaseProvider
{
    /**
     * @var string
     */
    protected $state = '';

    /**
     * @param null $redirectUrl
     * @return RedirectResponse
     */
    public function redirect($redirectUrl = null)
    {
        return new RedirectResponse(
            $this->redirectString($redirectUrl)
        );
    }


    /**
     * @param null $redirectUrl
     * @return string
     */
    public function redirectString($redirectUrl = null) {
        $state = null;

        if (!is_null($redirectUrl)) {
            $this->redirectUrl = $redirectUrl;
        }

        if ($this->usesState()) {
            $state = !empty($this->state) ? $this->state : $this->makeState();
        }

        return $this->getAuthUrl($state);
    }

    /**
     * @param AccessTokenInterface|null $token
     * @return BaseProvider|\Overtrue\Socialite\User
     */
    public function user(AccessTokenInterface $token = null)
    {
        if (is_null($token) && $this->hasInvalidState()) {
            throw new InvalidStateException();
        }

        $token = $token ?: $this->getAccessToken($this->getCode());

        $user = $this->getUserByToken($token);

        $user = $this->mapUserToObject($user)->merge([
            'original' => $user,
            'state'    => $this->request->get('state')
        ]);

        return $user->setToken($token)->setProviderName($this->getName());
    }

    /**
     * @return bool
     */
    protected function hasInvalidState()
    {
        if ($this->isStateless()) {
            return false;
        }

        if (is_null($this->state) || $this->state === '') {
            $this->state = (string)$this->request->getSession()->get('state');
        }

        return !(strlen($this->state) > 0 && $this->request->get('state') === $this->state);
    }

    /**
     * @return $this
     */
    public function stateful()
    {
        $this->stateless = false;

        return $this;
    }

    /**
     * @param string $state
     * @return $this
     */
    public function setState(string $state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @param string $state
     * @return $this
     */
    public function withState(string $state)
    {
        $this->state = $state;

        return $this;
    }
}
