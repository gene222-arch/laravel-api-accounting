<?php

namespace App\Http\Controllers\Api\Banking\BankAccountTransfer;

use App\Traits\Api\ApiResponser;
use App\Models\BankAccountTransfer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banking\BankAccountTransfer\UpdateStoreRequest;
use App\Http\Requests\Banking\BankAccountTransfer\DeleteRequest;

class BankAccountTransfersController extends Controller
{
    use ApiResponser;

    private BankAccountTransfer $bankAccountTransfer;
    
    public function __construct(BankAccountTransfer $bankAccountTransfer)
    {
        $this->bankAccountTransfer = $bankAccountTransfer;
        $this->middleware(['auth:api', 'permission:Manage Bank Account Transfers']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->bankAccountTransfer->getAllBankAccountTransfers();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UpdateStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UpdateStoreRequest $request)
    {
        $result = $this->bankAccountTransfer->createBankAccountTransfer(
            $request->all(),
            $request->from_account_id,
            $request->to_account_id,
            $request->amount
        );

        return $result !== true
            ? $this->error($result, 500)
            : $this->success(null, 'Bank account transferred successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param BankAccountTransfer $transfer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(BankAccountTransfer $transfer)
    {
        $transfer = $transfer->with(['from', 'to', 'paymentMethod'])->firstOrFail();

        return !$transfer
            ? $this->noContent()
            : $this->success($transfer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStoreRequest $request
     * @param BankAccountTransfer $transfer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateStoreRequest $request, BankAccountTransfer $transfer)
    {
        $result = $this->bankAccountTransfer->updateBankAccountTransfer(
            $transfer,
            $request->all(),
            $request->from_account_id,
            $request->to_account_id,
            $request->amount
        );

        return $result !== true
            ? $this->error($result, 500)
            : $this->success(null, 'Bank account transfer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->bankAccountTransfer->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Bank account transfer or transfers deleted successfully.');
    }
}
