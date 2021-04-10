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
        $result = $this->chartOfAccount->getAllChartOfAccounts();

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
        $chartOfAccount = $this->chartOfAccount->createChartOfAccount(
            $request->name,
            $request->code,
            $request->type,
            $request->description,
            $request->enabled
        );

        return $this->success($chartOfAccount, 'Chart of account created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->chartOfAccount->getChartOfAccountById($id);

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
        $this->chartOfAccount->updateChartOfAccount(
            $request->id,
            $request->name,
            $request->code,
            $request->type,
            $request->description,
            $request->enabled
        );

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
        $this->chartOfAccount->deleteChartOfAccounts($request->ids);

        return $this->success(null, 'Chart of account or accounts deleted successfully.');
    }
}
