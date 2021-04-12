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
        setSqlModeEmpty();

        $result = $this->payroll
            ->selectRaw('
                payrolls.name,
                payrolls.from_date,
                payrolls.to_date,
                payrolls.payment_date,
                COUNT(employee_payroll.employee_id) as employee_count,
                payrolls.status,
                SUM(employee_payroll.total_amount) as amount
            ')
            ->join('employee_payroll', 'employee_payroll.payroll_id', '=', 'payrolls.id')
            ->groupBy('payrolls.id')
            ->latest()
            ->get();

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
            $request->except('details', 'benefits', 'contributions'),
            $request->status,
            $request->details,
            $request->taxes,
            $request->benefits,
            $request->contributions
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Payroll created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Payroll $payroll
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Payroll $payroll)
    {
        $payroll = $payroll->with([
            'details',
            'employeeTaxes',
            'employeeBenefits',
            'employeeContributions'
        ])
            ->first();

        return !$payroll
            ? $this->noContent()
            : $this->success($payroll);
    }

    /**
     * Update a specified resource storage as approve.
     *
     * @param Payroll $payroll
     * @return \Illuminate\Http\JsonResponse
     */
    public function approve(Payroll $payroll)
    {
        $result = $this->payroll->approve($payroll);

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Payroll status successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Payroll $payroll
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Payroll $payroll)
    {
        $result = $this->payroll->updatePayroll(
            $payroll,
            $request->except('details', 'benefits', 'contributions'),
            $request->status,
            $request->details,
            $request->taxes,
            $request->benefits,
            $request->contributions
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
