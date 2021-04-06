<?php

namespace App\Http\Controllers\Api\Banking\BankAccountTransfer;

use App\Traits\Api\ApiResponser;
use App\Models\BankAccountTransfer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banking\BankAccountTransfer\StoreRequest;
use App\Http\Requests\Banking\BankAccountTransfer\DeleteRequest;
use App\Http\Requests\Banking\BankAccountTransfer\UpdateRequest;

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
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $result = $this->bankAccountTransfer->createBankAccountTransfer(
            $request->fromAccountId,
            $request->toAccountId,
            $request->paymentMethodId,
            $request->amount,
            $request->transferredAt,
            $request->description,
            $request->reference
        );

        return $result !== true
            ? $this->error($result, 500)
            : $this->success(null, 'Bank account transferred successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->bankAccountTransfer->getBankAccountTransferById($id);

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
        $result = $this->bankAccountTransfer->updateBankAccountTransfer(
            $request->id,
            $request->fromAccountId,
            $request->toAccountId,
            $request->paymentMethodId,
            $request->amount,
            $request->transferredAt,
            $request->description,
            $request->reference
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
        $this->bankAccountTransfer->deleteBankAccountTransfers($request->ids);

        return $this->success(null, 'Bank account transfer or transfers deleted successfully.');
    }
}
