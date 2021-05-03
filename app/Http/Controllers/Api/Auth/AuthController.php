<?php

namespace App\Http\Controllers\Api\Auth;

use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Traits\Auth\Auth\AuthServices;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponser, AuthServices;


    public function __construct()
    {
        $this->middleware(['auth:api']);
    }


    /**
     * Show the currently authenticated user
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $user = Auth::user();

        return $this->success([
            'user' => $user,
            'company' => $user->company,
            'permissions' => $this->authPermissionViaRoles()
        ]);
    }
}
