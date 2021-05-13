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
        $result = $this->transaction
            ->with('account:id,name')
            ->latest()
            ->get();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Display the specified resource.
     *
     * @param Transaction $transaction
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Transaction $transaction)
    {
        $transaction = $transaction->with([
            'account',
            'incomeCategory',
            'expenseCategory'
        ])
            ->latest()
            ->get(['id', ...$transaction->getFillable()]);

        return !$transaction
            ? $this->noContent()
            : $this->success($transaction);
    }

    /**
     * Display the specified resource via account.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByAccount($id)
    {
        $result = $this->transaction
            ->where('account_id', $id)
            ->with([
                'account:id,name',
                'incomeCategory:id,name',
                'expenseCategory:id,name'
            ])
            ->latest()
            ->get();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }
}
