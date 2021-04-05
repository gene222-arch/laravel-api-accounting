<?php

namespace App\Http\Controllers\Api\Banking\Account;

use App\Models\Account;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banking\Account\DeleteRequest;
use App\Http\Requests\Banking\Account\StoreRequest;
use App\Http\Requests\Banking\Account\UpdateRequest;

class AccountsController extends Controller
{
    use ApiResponser;

    private Account $account;
    
    public function __construct(Account $account)
    {
        $this->account = $account;
        $this->middleware(['auth:api', 'permission:Manage Accounts']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->account->getAllAccounts();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $account = $this->account->createAccount(
            $request->currencyId,
            $request->name,
            $request->number,
            $request->openingBalance
        );

        return $this->success($account, 'Account created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->account->getAccountById($id);

        return !$result
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $this->account->updateAccount(
            $request->id,
            $request->currencyId,
            $request->name,
            $request->number,
            $request->openingBalance
        );

        return $this->success(null, 'Account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->account->deleteAccounts($request->ids);

        return $this->success(null, 'Account or accounts deleted successfully.');
    }
}
