<?php

namespace App\Http\Controllers\Api\DoubleEntry\ChartOfAccount;

use App\Models\ChartOfAccount;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\DoubleEntry\ChartOfAccount\StoreRequest;
use App\Http\Requests\DoubleEntry\ChartOfAccount\DeleteRequest;
use App\Http\Requests\DoubleEntry\ChartOfAccount\UpdateRequest;

class ChartOfAccountsController extends Controller
{
    use ApiResponser;

    private ChartOfAccount $chartOfAccount;
    
    public function __construct(ChartOfAccount $chartOfAccount)
    {
        $this->chartOfAccount = $chartOfAccount;
        $this->middleware(['auth:api', 'permission:Manage Chart Of Accounts']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->chartOfAccount
            ->latest()
            ->get(['id', ...$this->chartOfAccount->getFillable()]);

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
        $chartOfAccount = $this->chartOfAccount->create($request->all());

        return $this->success($chartOfAccount, 'Chart of account created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param ChartOfAccount $chartOfAccount
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ChartOfAccount $chartOfAccount)
    {
        return !$chartOfAccount
            ? $this->noContent()
            : $this->success($chartOfAccount);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param ChartOfAccount $chartOfAccount
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, ChartOfAccount $chartOfAccount)
    {
        $chartOfAccount->update($request->all());

        return $this->success(null, 'Chart of account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->chartOfAccount->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Chart of account or accounts deleted successfully.');
    }
}
