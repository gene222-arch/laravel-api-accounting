<?php

namespace App\Http\Controllers\Api\HumanResource\Employee;

use App\Models\Employee;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Upload\UploadImageRequest;
use App\Http\Requests\HumanResource\Employee\StoreRequest;
use App\Http\Requests\HumanResource\Employee\DeleteRequest;
use App\Http\Requests\HumanResource\Employee\UpdateRequest;
use App\Traits\Upload\UploadServices;

class EmployeesController extends Controller
{
    use ApiResponser, UploadServices;

    private Employee $employee;
    
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
        $this->middleware(['auth:api', 'permission:Manage Employees']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->employee
            ->with('salary')
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
        $result = $this->employee->createEmployee(
            $request->employee,
            $request->salary,
            $request->create_user,
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Employee $employee
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Employee $employee)
    {
        $employee = $this->employee
            ->with([
                'salary',
                'role:id,name',
                'payrolls',
                'benefits',
                'contributions',
                'taxes'
            ])
            ->find($employee->id);

        return !$employee
            ? $this->noContent()
            : $this->success($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Employee $employee
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Employee $employee)
    {
        $result = $this->employee->updateEmployee(
            $employee,
            $request->employee,
            $request->salary,
            $request->create_user,
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Employee updated successfully.');
    }

    /**
     * Upload the specified resource.
     *
     * @param UploadImageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */   
    public function upload(UploadImageRequest $request)
    {
        $data = $this->uploadImage(
            $request,
            'employees'
        );

        return $this->success($data, 'Image uploaded successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->employee->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Employee or employees deleted successfully.');
    }
}
