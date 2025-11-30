<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
  public function findOrCreateSocialUser($provider, $providerId, $email, $name, $avatar);
  public function findByEmail($email);
  public function createUser(array $data);
}
