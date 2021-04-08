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
        $result = $this->salaryBenefit->getAllSalaryBenefits();

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
        $salaryBenefit = $this->salaryBenefit->createSalaryBenefit(
            $request->type,
            $request->amount,
            $request->enabled
        );

        return $this->success($salaryBenefit, 'Salary benefit created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->salaryBenefit->getSalaryBenefitById($id);

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
        $this->salaryBenefit->updateSalaryBenefit(
            $request->id,
            $request->type,
            $request->amount,
            $request->enabled
        );

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
        $this->salaryBenefit->deleteSalaryBenefits($request->ids);

        return $this->success(null, 'Salary benefit or benefits deleted successfully.');
    }
}
