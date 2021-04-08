<?php

namespace App\Http\Controllers\Api\HumanResource\Payroll\Payroll;

use App\Models\Payroll;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\HumanResource\Payroll\Payroll\StoreRequest;
use App\Http\Requests\HumanResource\Payroll\Payroll\DeleteRequest;
use App\Http\Requests\HumanResource\Payroll\Payroll\UpdateRequest;

class PayrollsController extends Controller
{
    use ApiResponser;

    private Payroll $payroll;
    
    public function __construct(Payroll $payroll)
    {
        $this->payroll = $payroll;
        $this->middleware(['auth:api', 'permission:Manage Payrolls']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->payroll->getAllPayrolls();

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
        $result = $this->payroll->createPayroll(
            $request->name,
            $request->accountId,
            $request->expenseCategoryId,
            $request->paymentMethodId,
            $request->fromDate,
            $request->toDate,
            $request->paymentDate,
            $request->details,
            $request->taxes,
            $request->benefits,
            $request->approved
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Payroll created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->payroll->getPayrollById($id);

        return !$result
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Update a specified resource storage as approve.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function approve($id)
    {
        $result = $this->payroll->approve($id);

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Payroll approved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $result = $this->payroll->updatePayroll(
            $request->id,
            $request->name,
            $request->accountId,
            $request->expenseCategoryId,
            $request->paymentMethodId,
            $request->fromDate,
            $request->toDate,
            $request->paymentDate,
            $request->details,
            $request->taxes,
            $request->benefits,
            $request->approved
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Payroll updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->payroll->deletePayrolls($request->ids);

        return $this->success(null, 'Payroll or payrolls deleted successfully.');
    }
}
