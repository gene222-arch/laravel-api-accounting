<?php

namespace App\Http\Controllers\Api\HumanResource\Payroll\SalaryBenefit;

use App\Models\SalaryBenefit;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\HumanResource\Payroll\SalaryBenefit\StoreRequest;
use App\Http\Requests\HumanResource\Payroll\SalaryBenefit\DeleteRequest;
use App\Http\Requests\HumanResource\Payroll\SalaryBenefit\UpdateRequest;

class SalaryBenefitsController extends Controller
{
    use ApiResponser;

    private SalaryBenefit $salaryBenefit;
    
    public function __construct(SalaryBenefit $salaryBenefit)
    {
        $this->salaryBenefit = $salaryBenefit;
        $this->middleware(['auth:api', 'permission:Manage Salary Benefits']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->salaryBenefit
            ->latest()
            ->get([
                'id', 
                ...(new SalaryBenefit())->getFillable()
            ]);;

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
        $salaryBenefit = $this->salaryBenefit->create($request->all());

        return $this->success($salaryBenefit, 'Salary benefit created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param SalaryBenefit $salaryBenefit
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SalaryBenefit $salaryBenefit)
    {
        return !$salaryBenefit
            ? $this->noContent()
            : $this->success($salaryBenefit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param SalaryBenefit $salaryBenefit
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, SalaryBenefit $salaryBenefit)
    {
        $salaryBenefit->update($request->except('id'));

        return $this->success(null, 'Salary benefit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->salaryBenefit->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Salary benefit or benefits deleted successfully.');
    }
}
