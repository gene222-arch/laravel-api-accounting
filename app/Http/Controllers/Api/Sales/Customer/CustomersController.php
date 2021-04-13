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
        $result = $this->customer
            ->latest()
            ->get(['id', ...(new Customer())->getFillable()]);

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
        $customer = $this->customer->create($request->validated());

        return $this->success($customer, 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Customer $customer)
    {
        return !$customer
            ? $this->noContent()
            : $this->success($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Customer $customer)
    {
        $customer->update($request->except('id'));

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
        $this->customer->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Customer or customers deleted successfully.');
    }
}
