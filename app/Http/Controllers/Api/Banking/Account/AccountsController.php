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
        $result = $this->account
            ->latest()
            ->get(['id', ...$this->account->getFillable()]);

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
        $account = $this->account->create($request->all());

        return $this->success($account, 'Account created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Account $account
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Account $account)
    {
        return !$account
            ? $this->noContent()
            : $this->success($account);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Account $account
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Account $account)
    {
        $account->update($request->except('id'));

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
        $this->account->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Account or accounts deleted successfully.');
    }
}
