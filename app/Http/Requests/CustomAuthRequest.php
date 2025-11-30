<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomAuthRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    $routeName = $this->route()->getName();

    if ($routeName === 'api.login') {
      return [
        'email' => 'required|email|string',
        'password' => 'required|string|min:6',
      ];
    }

    $routeUserRule = ['api.register', 'api.profile.update'];

    if (in_array($routeName, $routeUserRule)) {
      return [
        'password' => 'required|string|min:8|confirmed',
        'email'    => 'required|email|unique:users,email',
        'name'     => 'required|string',
        'avatar'   => 'nullable|url|string'
      ];
    }

    return [];
  }
}
