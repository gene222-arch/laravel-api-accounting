<?php

namespace App\Http\Controllers\Api\HumanResource\Payroll\PayCalendar;

use App\Models\PayCalendar;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\HumanResource\Payroll\PayCalendar\StoreRequest;
use App\Http\Requests\HumanResource\Payroll\PayCalendar\DeleteRequest;
use App\Http\Requests\HumanResource\Payroll\PayCalendar\UpdateRequest;

class PayCalendarsController extends Controller
{
    use ApiResponser;

    private PayCalendar $payCalendar;
    
    public function __construct(PayCalendar $payCalendar)
    {
        $this->payCalendar = $payCalendar;
        $this->middleware(['auth:api', 'permission:Manage Pay Calendars']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->payCalendar
            ->with('employees:id,first_name,last_name,email')
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
        $result = $this->payCalendar->createPayCalendar(
            $request->name,
            $request->type,
            $request->employee_ids
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Pay calendar created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param PayCalendar $payCalendar
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PayCalendar $payCalendar)
    {
        $payCalendar = $payCalendar->with([
            'employees' => fn($q) => $q->selectRaw('
                employees.id,
                employees.first_name,
                employees.last_name,
                employees.email
            ')
        ])
        ->first();

        return !$payCalendar
            ? $this->noContent()
            : $this->success($payCalendar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param PayCalendar $payCalendar
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, PayCalendar $payCalendar)
    {
        $result = $this->payCalendar->updatePayCalendar(
            $payCalendar,
            $request->name,
            $request->type,
            $request->employee_ids
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Pay calendar updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {   
        $this->payCalendar->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Pay calendar or calendars deleted successfully.');
    }
}
