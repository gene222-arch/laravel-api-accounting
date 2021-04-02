<?php

namespace App\Http\Controllers\Api\Item;

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
        $result = $this->tax->getAllTaxes();

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
        $tax = $this->tax->createTax(
            $request->name,
            $request->rate,
            $request->type,
            $request->enabled
        );

        return $this->success($tax, 'Tax created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->tax->getTaxById($id);

        return !$result
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $this->tax->updateTax(
            $request->id,
            $request->name,
            $request->rate,
            $request->type,
            $request->enabled
        );

        return $this->success(null, 'Tax updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->tax->deleteTaxes($request->ids);

        return $this->success(null, 'Tax or taxes deleted successfully.');
    }
}
