<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
  /**
   * Exceptions that should not be reported.
   */
  protected $dontReport = [
    ApiException::class,
    ModelNotFoundException::class,
    ValidationException::class,
    TokenExpiredException::class,
    TokenInvalidException::class,
  ];

  /**
   * Register the exception handling callbacks.
   */
  public function register(): void
  {
    // HANDLE CUSTOM API EXCEPTION
    $this->renderable(function (ApiException $e, $request) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
      ], $e->getCode() ?: 400);
    });

    // HANDLE VALIDATION ERROR
    $this->renderable(function (ValidationException $e, $request) {
      return response()->json([
        'success' => false,
        'message' => 'Validation failed',
        'errors'  => $e->errors(),
      ], 422);
    });

    // MODEL NOT FOUND
    $this->renderable(function (ModelNotFoundException $e, $request) {
      return response()->json([
        'success' => false,
        'message' => 'Resource not found'
      ], 404);
    });

    // AUTH FAILED (JWT NOT PRESENT)
    $this->renderable(function (AuthenticationException $e, $request) {
      return response()->json([
        'success' => false,
        'message' => 'Unauthenticated'
      ], 401);
    });

    // TOKEN EXPIRED
    $this->renderable(function (TokenExpiredException $e, $request) {
      return response()->json([
        'success' => false,
        'message' => 'Token expired'
      ], 401);
    });

    // INVALID TOKEN
    $this->renderable(function (TokenInvalidException $e, $request) {
      return response()->json([
        'success' => false,
        'message' => 'Invalid token'
      ], 401);
    });

    // ROUTE NOT FOUND
    $this->renderable(function (NotFoundHttpException $e, $request) {
      return response()->json([
        'success' => false,
        'message' => 'Endpoint not found'
      ], 404);
    });

    $this->renderable(function (BusinessException $e, $request) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        // optional: bisa tambah field tambahan misal error code
      ], $e->getStatusCode());
    });

    // DEFAULT ERROR (CATCH ALL)
    $this->renderable(function (Throwable $e, $request) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
      ], 500);
    });
  }

  protected function shouldReturnJson($request, Throwable $e)
  {
    return true; // API only
  }
}
