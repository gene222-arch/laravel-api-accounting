<?php

namespace App\Http\Controllers\Api\Sales\Customer;

use App\Models\Customer;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\Customer\DeleteRequest;
use App\Http\Requests\Sales\Customer\StoreRequest;
use App\Http\Requests\Sales\Customer\UpdateRequest;

class CustomersController extends Controller
{
    use ApiResponser;

    private Customer $customer;
    
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
        $this->middleware(['auth:api', 'permission:Manage Customers']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->customer->getAllCustomers();

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
        $model = $this->customer->createCustomer(
            $request->name, 
            $request->email, 
            $request->taxNumber, 
            $request->currency, 
            $request->phone, 
            $request->website, 
            $request->address, 
            $request->reference
        );

        return $this->success($model, 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->customer->getCustomerById($id);

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
        $this->customer->updateCustomer(
            $request->id,
            $request->name, 
            $request->email, 
            $request->taxNumber, 
            $request->currency, 
            $request->phone, 
            $request->website, 
            $request->address, 
            $request->reference
        );

        return $this->success(null, 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {   
        $this->customer->deleteCustomers($request->ids);

        return $this->success(null, 'Customer or customers deleted successfully.');
    }
}
