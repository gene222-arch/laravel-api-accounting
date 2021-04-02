<?php

namespace App\Http\Controllers\Api\Settings;

use App\Models\User;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
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
        $result = $this->user->verifyAccountViaPassword(
            $request->userId,
            $request->password 
        );

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
        $this->user->updateAccount(
            $request->userId,
            $request->firstName,
            $request->lastName,
            $request->email,
            $request->password
        );

        return $this->success(null, 'Account updated successfully.');
    }

}
