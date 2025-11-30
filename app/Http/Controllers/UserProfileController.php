<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomAuthRequest;

class UserProfileController extends Controller
{
  /**
   * @group Users
   * @authenticated
   *
   * @header Authorization Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
   */
  public function profile(Request $request)
  {
    return apiResponse($request->user(), 'Profile retrieved');
  }

  /**
   * @group Users
   * @authenticated
   *
   * @header Authorization Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
   */
  public function update(CustomAuthRequest $request)
  {
    $user = $request->user();
    $user->update($request->all());

    return apiResponse($user, "Profile Updated");
  }
}
