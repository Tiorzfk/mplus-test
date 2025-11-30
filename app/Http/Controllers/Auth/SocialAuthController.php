<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SocialAuthService;
use App\Http\Requests\SocialAuthRequest;

class SocialAuthController extends Controller
{
  protected $service;

  public function __construct(SocialAuthService $service)
  {
    $this->service = $service;
  }

  /**
   * @group Auth
   */
  public function google(SocialAuthRequest $request)
  {
    $accessToken = $request->input('access_token');

    return response()->json(
      $this->service->handleProviderCallback('google', $accessToken)
    );
  }

  /**
   * @group Auth
   */
  public function facebook(SocialAuthRequest $request)
  {
    $accessToken = $request->input('access_token');

    return response()->json(
      $this->service->handleProviderCallback('facebook', $accessToken)
    );
  }
}
