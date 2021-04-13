<?php

namespace App\Http\Controllers\Api\Settings\Tax;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\Tax\DeleteRequest;
use App\Http\Requests\Item\Tax\StoreRequest;
use App\Http\Requests\Item\Tax\UpdateRequest;
use App\Models\Tax;
use App\Traits\Api\ApiResponser;

class TaxController extends Controller
{
    use ApiResponser;

    private Tax $tax;
    
    public function __construct(Tax $tax)
    {
        $this->tax = $tax;
        $this->middleware('auth:api', ['permission:Manage Taxes']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->tax
            ->latest()
            ->get(['id', ...$this->tax->getFillable()]);

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $tax = $this->tax->create($request->all());

        return $this->success($tax, 'Tax created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Tax $tax
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Tax $tax)
    {
        return !$tax
            ? $this->noContent()
            : $this->success($tax);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Tax $tax
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Tax $tax)
    {
        $tax->update($request->except('id'));

        return $this->success(null, 'Tax updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->tax->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Tax or taxes deleted successfully.');
    }
}
