<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\CustomAuthRequest;
use App\Exceptions\ApiException;

class AuthController extends Controller
{
  protected $service;

  public function __construct(AuthService $service)
  {
    $this->service = $service;
  }

  /**
   * @group Auth
   */
  public function register(CustomAuthRequest $request)
  {
    return apiResponse(
      $this->service->register($request->all()),
      'User successfully registered'
    );
  }

  /**
   * @group Auth
   */
  public function login(CustomAuthRequest $request)
  {
    return apiResponse(
      $this->service->login($request->email, $request->password),
      'Success'
    );
  }

  /**
   * @group Auth
   * @authenticated
   *
   * @header Authorization Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
   */
  public function refresh(Request $request)
  {
    $token = $request->bearerToken();
    if (!$token) {
      throw new ApiException('Token not provided', 401);
    }

    return apiResponse(
      [
        'token' => JWTAuth::setToken($token)->refresh()
      ],
      'Success'
    );
  }
}
