<?php

namespace App\Http\Controllers\Api\Banking\BankAccountReconciliation;

use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Models\BankAccountReconciliation;
use App\Http\Requests\Banking\BankAccountReconciliation\UpdateStoreRequest;
use App\Http\Requests\Banking\BankAccountReconciliation\DeleteRequest;
use App\Models\Account;

class BankAccountReconciliationsController extends Controller
{
    use ApiResponser;

    private BankAccountReconciliation $reconciliation;
    
    public function __construct(BankAccountReconciliation $reconciliation)
    {
        $this->reconciliation = $reconciliation;
        $this->middleware(['auth:api', 'permission:Manage Bank Account Reconciliations']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->reconciliation
            ->with('account:id,name')
            ->latest()
            ->get();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UpdateStoreRequest $request
     * @param Account $account
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UpdateStoreRequest $request, Account $account)
    {
        $result = $this->reconciliation->createBankAccountReconciliation(
            $request->validated(),
            $account,
            $request->closing_balance,
            $request->difference,
            $request->status
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success($result, 'Bank account reconciliation created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param BankAccountReconciliation $reconciliation
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(BankAccountReconciliation $reconciliation)
    {
        $reconciliation = $reconciliation->with('account')->first();

        return !$reconciliation
            ? $this->noContent()
            : $this->success($reconciliation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateStoreRequest $request, BankAccountReconciliation $reconciliation, Account $account)
    {
        $result = $this->reconciliation->updateBankAccountReconciliation(
            $reconciliation,
            $request->validated(),
            $account,
            $request->closing_balance,
            $request->difference,
            $request->status
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success($result, 'Bank account reconciliation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->reconciliation->whereIn('id', $request->ids)->delete();;

        return $this->success(null, 'Bank account reconciliation or reconciliations deleted successfully.');
    }
}
