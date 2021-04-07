<?php

namespace App\Http\Controllers\Api\Purchases\Purchase;

use App\Models\Purchase;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Purchases\Purchase\StoreRequest;
use App\Http\Requests\Purchases\Purchase\DeleteRequest;
use App\Http\Requests\Purchases\Purchase\UpdateRequest;

class PurchasesController extends Controller
{
    use ApiResponser;

    private Purchase $purchase;
    
    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
        $this->middleware(['auth:api', 'permission:Manage Purchases']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->purchase->getAllPurchases();

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
        $purchase = $this->purchase->createPurchase(
            $request->number,
            $request->accountId,
            $request->vendorId,
            $request->expenseCategoryId,
            $request->paymentMethodId,
            $request->currencyId,
            $request->date,
            $request->amount,
            $request->description,
            $request->recurring,
            $request->reference,
            $request->file
        );

        return $this->success($purchase, 'Purchase created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->purchase->getPurchaseById($id);

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
        $this->purchase->updatePurchase(
            $request->id,
            $request->number,
            $request->accountId,
            $request->vendorId,
            $request->expenseCategoryId,
            $request->paymentMethodId,
            $request->currencyId,
            $request->date,
            $request->amount,
            $request->description,
            $request->recurring,
            $request->reference,
            $request->file
        );

        return $this->success(null, 'Purchase updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->purchase->deletePurchases($request->ids);

        return $this->success(null, 'Purchase or purchases deleted successfully.');
    }
}
