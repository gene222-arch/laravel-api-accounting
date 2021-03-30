<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Account\UpdateRequest;
use App\Http\Requests\Settings\Account\VerifyUserRequest;
use App\Traits\Api\ApiResponser;
use App\Traits\Settings\AccountServices;

class AccountController extends Controller
{
    use ApiResponser, AccountServices;

    
    public function __construct()
    {
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
        $result = $this->verifyAccountViaPassword(
            $request->userId,
            $request->password 
        );

        return !$result
            ? $this->noContent()
            : $this->success();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $this->updateAccount(
            $request->userId,
            $request->firstName,
            $request->lastName,
            $request->email,
            $request->password
        );

        return $this->success();
    }

}
