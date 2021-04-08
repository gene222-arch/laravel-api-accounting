<?php

namespace App\Http\Controllers\Api\HumanResource\Employee;

use App\Models\Employee;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\HumanResource\Employee\StoreRequest;
use App\Http\Requests\HumanResource\Employee\DeleteRequest;
use App\Http\Requests\HumanResource\Employee\UpdateRequest;

class EmployeesController extends Controller
{
    use ApiResponser;

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
        $result = $this->employee->getAllEmployees();

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
            $request->firstName,
            $request->lastName,
            $request->email,
            $request->birthDate,
            $request->gender,
            $request->phone,
            $request->address,
            $request->roleId,
            $request->enabled,
            $request->currencyId,
            $request->amount,
            $request->taxNumber,
            $request->bankAccountNumber,
            $request->hiredAt,
            $request->createUser
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->employee->getEmployeeById($id);

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
        $result = $this->employee->updateEmployee(
            $request->id,
            $request->firstName,
            $request->lastName,
            $request->email,
            $request->birthDate,
            $request->gender,
            $request->phone,
            $request->address,
            $request->roleId,
            $request->enabled,
            $request->currencyId,
            $request->amount,
            $request->taxNumber,
            $request->bankAccountNumber,
            $request->hiredAt,
            $request->updateUser
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->employee->deleteEmployees($request->ids);

        return $this->success(null, 'Employee or employees deleted successfully.');
    }
}
