<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\AuthManager;
use Illuminate\Auth\TokenGuard;
use Illuminate\Contracts\Auth\UserProvider;

class ApiAuthService
{
    /**
     * @var TokenGuard
     */
    private $guard;

    /**
     * @var UserProvider
     */
    private $provider;

    /**
     * ApiAuthService constructor.
     *
     * @param TokenGuard $guard
     * @param AuthManager $authManager
     */
    public function __construct(AuthManager $authManager)
    {
        $this->guard = $authManager->guard();
        $this->provider = $authManager->createUserProvider();
    }

    /**
     * Create user
     *
     * @param array $userInfo
     * @return User|null
     */
    public function register(array $userInfo): ?User
    {
        return User::create($userInfo);
    }

    /**
     * Login user
     *
     * @param array $credentials
     * @return string
     * @throws AuthenticationException
     */
    public function login(array $credentials): string
    {
        /** @var User $user */
        $user = $this->provider->retrieveByCredentials($credentials);

        if($user && $this->provider->validateCredentials($user, $credentials)) {
            $user->api_token = str_random(64);
            $user->save();

            $this->guard->setUser($user);
            return $user->api_token;
        }

        throw new AuthenticationException();
    }

    /**
     * Logout user
     *
     * @param $id
     */
    public function logout($id)
    {
        $user = User::findOrFail($id);
        $user->api_token = null;
        $user->save();
    }
}
