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
        $result = $this->payCalendar->getAllPayCalendars();

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
            $request->employeeIds
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Pay calendar created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->payCalendar->getPayCalendarById($id);

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
        $result = $this->payCalendar->updatePayCalendar(
            $request->id,
            $request->name,
            $request->type,
            $request->employeeIds
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
        $this->payCalendar->deletePayCalendars($request->ids);

        return $this->success(null, 'Pay calendar or calendars deleted successfully.');
    }
}
