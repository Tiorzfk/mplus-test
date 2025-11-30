<?php

namespace App\Http\Middlewares;

use App\Exceptions\ApiException;
use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
  public function handle($request, Closure $next)
  {
    try {
      $user = JWTAuth::parseToken()->authenticate();
    } catch (\Exception $e) {
      throw new ApiException('Invalid or expired token', 401);
    }

    $request->merge(['user' => $user]);

    return $next($request);
  }
}
