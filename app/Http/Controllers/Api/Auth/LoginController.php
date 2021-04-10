<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\Api\ApiResponser;
use App\Traits\Api\ApiServices;
use App\Traits\Auth\Auth\AuthServices;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use ApiResponser, ApiServices, AuthServices;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:api')->except('logout');
    }


    /**
     * Login's the user
     *
     * @param LoginRequest $request
     * @return json
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated()))
        {
            return $this->error('Credentials mismatch');
        }

        return $this->token(
            $this->getPersonalAccessToken($request),
            'User logged in successfully.',
            [
                'user' => Auth::user(),
                'permissions' => $this->authPermissionViaRoles()
            ]
        );
    }


    /**
     * Sign out's the currently authenticated user
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()
            ->user()
            ->token()
            ->revoke();
        
        return $this->success([], 'User logged out successfully.');
    }
}
