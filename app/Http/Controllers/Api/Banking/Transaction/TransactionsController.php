<?php

namespace App\Http\Controllers\Api\Banking\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Traits\Api\ApiResponser;

class TransactionsController extends Controller
{
    use ApiResponser;

    private Transaction $transaction;
    
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->middleware(['auth:api', 'permission:View Transactions']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->transaction->getAllTransactions();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->transaction->getTransactionById($id);

        return !$result
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Display the specified resource via account.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByAccount($id)
    {
        $result = $this->transaction->getTransactionByAccountId($id);

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }
}
