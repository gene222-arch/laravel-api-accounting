<?php

namespace App\Http\Controllers\Api\Banking\BankAccountReconciliation;

use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Models\BankAccountReconciliation;
use App\Http\Requests\Banking\BankAccountReconciliation\StoreRequest;
use App\Http\Requests\Banking\BankAccountReconciliation\DeleteRequest;
use App\Http\Requests\Banking\BankAccountReconciliation\UpdateRequest;


class BankAccountReconciliationsController extends Controller
{
    use ApiResponser;

    private BankAccountReconciliation $bankAccountReconciliation;
    
    public function __construct(BankAccountReconciliation $bankAccountReconciliation)
    {
        $this->bankAccountReconciliation = $bankAccountReconciliation;
        $this->middleware(['auth:api', 'permission:Manage Bank Account Reconciliations']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->bankAccountReconciliation->getAllBankAccountReconciliations();

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
        $result = $this->bankAccountReconciliation->createBankAccountReconciliation(
            $request->accountId,
            $request->startedAt,
            $request->endedAt,
            $request->closingBalance,
            $request->clearedAmount,
            $request->difference,
            $request->reconciled
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success($result, 'Bank account reconciliation created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->bankAccountReconciliation->getBankAccountReconciliationById($id);

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
        $result = $this->bankAccountReconciliation->updateBankAccountReconciliation(
            $request->id,
            $request->accountId,
            $request->startedAt,
            $request->endedAt,
            $request->closingBalance,
            $request->clearedAmount,
            $request->difference,
            $request->reconciled
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
        $this->bankAccountReconciliation->deleteBankAccountReconciliations($request->ids);

        return $this->success(null, 'Bank account reconciliation or reconciliations deleted successfully.');
    }
}
