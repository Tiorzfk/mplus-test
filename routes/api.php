<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserProfileController;

Route::prefix('v1')->group(function () {

  // SOCIAL LOGIN
  Route::post('/auth/google', [SocialAuthController::class, 'google']);
  Route::post('/auth/facebook', [SocialAuthController::class, 'facebook']);

  // CUSTOM AUTH
  Route::post('/auth/register', [AuthController::class, 'register'])->name('api.register');
  Route::post('/auth/login', [AuthController::class, 'login'])->name('api.login');
  Route::post('/auth/token/refresh', [AuthController::class, 'refresh'])->name('api.refreshToken');

  // PROTECTED ROUTES
  Route::middleware('jwt')->prefix('users')->name('api.profile')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'profile'])->name('get');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('update');
  });
});
