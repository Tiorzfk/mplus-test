<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
  public function findOrCreateSocialUser($provider, $providerId, $email, $name, $avatar)
  {
    return User::firstOrCreate(
      ['email' => $email],
      [
        'email' => $email,
        'name' => $name,
        'provider' => $provider,
        'provider_id' => $providerId,
        'avatar' => $avatar
      ]
    );
  }

  public function findByEmail($email)
  {
    return User::where('email', $email)->first();
  }

  public function createUser(array $data)
  {
    return User::create($data);
  }
}
