<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialAuthService
{
  protected $users;

  public function __construct(UserRepositoryInterface $users)
  {
    $this->users = $users;
  }

  public function handleProviderCallback($provider, $accessToken = null)
  {
    /** @var \Laravel\Socialite\Contracts\Provider|\Laravel\Socialite\Two\AbstractProvider $driver */
    $driver = Socialite::driver($provider);
    $socialUser = $driver->stateless()
      ->scopes(['openid', 'profile', 'email'])
      ->userFromToken($accessToken);

    $user = $this->users->findOrCreateSocialUser(
      $provider,
      $socialUser->getId(),
      $socialUser->getEmail(),
      $socialUser->getName(),
      $socialUser->getAvatar()
    );

    $token = JWTAuth::fromUser($user);

    return compact('user', 'token');
  }
}
