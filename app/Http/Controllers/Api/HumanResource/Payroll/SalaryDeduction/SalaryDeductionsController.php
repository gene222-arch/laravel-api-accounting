<?php

namespace App\Http\Controllers\Api\HumanResource\Payroll\SalaryDeduction;

use App\Models\SalaryDeduction;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\HumanResource\Payroll\SalaryDeduction\StoreRequest;
use App\Http\Requests\HumanResource\Payroll\SalaryDeduction\DeleteRequest;
use App\Http\Requests\HumanResource\Payroll\SalaryDeduction\UpdateRequest;

class SalaryDeductionsController extends Controller
{
    use ApiResponser;

    private SalaryDeduction $salaryDeduction;
    
    public function __construct(SalaryDeduction $salaryDeduction)
    {
        $this->salaryDeduction = $salaryDeduction;
        $this->middleware(['auth:api', 'permission:Manage Salary Deductions']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->salaryDeduction->getAllSalaryDeductions();

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
        $salaryDeduction = $this->salaryDeduction->createSalaryDeduction(
            $request->type,
            $request->rate,
            $request->enabled
        );

        return $this->success($salaryDeduction, 'Salary deduction created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->salaryDeduction->getSalaryDeductionById($id);

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
        $this->salaryDeduction->updateSalaryDeduction(
            $request->id,
            $request->type,
            $request->rate,
            $request->enabled
        );

        return $this->success(null, 'Salary deduction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->salaryDeduction->deleteSalaryDeductions($request->ids);

        return $this->success(null, 'Salary deduction or deductions deleted successfully.');
    }
}
