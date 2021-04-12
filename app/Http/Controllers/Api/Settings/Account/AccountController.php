<?php

namespace App\Http\Controllers\Api\Settings\Account;

use App\Models\User;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Settings\Account\UpdateRequest;
use App\Http\Requests\Settings\Account\VerifyUserRequest;

class AccountController extends Controller
{
    use ApiResponser;

    private User $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware(['auth:api']);
    }

    /**
     * Check if the user password is correct.
     *
     * @param VerifyUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(VerifyUserRequest $request)
    {
        $result = Hash::check($request->password, Auth::user()->password);

        return !$result
            ? $this->noContent()
            : $this->success(null, 'Account verified successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        Auth::user()->update($request->all());

        return $this->success(null, 'Account updated successfully.');
    }

}
