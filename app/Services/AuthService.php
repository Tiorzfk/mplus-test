<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
  protected $users;

  public function __construct(UserRepositoryInterface $users)
  {
    $this->users = $users;
  }

  public function register($data)
  {
    $data['password'] = Hash::make($data['password']);

    $user = $this->users->createUser($data);
    $token = JWTAuth::fromUser($user);

    return compact('user', 'token');
  }

  public function login($email, $password)
  {
    $user = $this->users->findByEmail($email);

    if (!$user || !Hash::check($password, $user->password)) {
      throw new ApiException('Invalid email or password', 401);
    }

    $token = JWTAuth::fromUser($user);

    return compact('user', 'token');
  }
}
