<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middlewares\ForceJsonResponse;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    api: __DIR__ . '/../routes/api.php',
    web: __DIR__ . '/../routes/web.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware): void {
    $middleware->prependToGroup('api', ForceJsonResponse::class);
    $middleware->alias([
      'jwt' => \App\Http\Middlewares\JWTMiddleware::class,
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions): void {
    $exceptions->renderable(function (Throwable $e, $request) {
      $handler = new \App\Exceptions\Handler(app());
      return $handler->render($request, $e);
    });
  })->create();
