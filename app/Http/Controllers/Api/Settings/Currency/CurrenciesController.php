<?php

namespace App\Http\Controllers\Api\Settings\Currency;

use App\Models\Currency;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Currency\StoreRequest;
use App\Http\Requests\Settings\Currency\DeleteRequest;
use App\Http\Requests\Settings\Currency\UpdateRequest;

class CurrenciesController extends Controller
{
    use ApiResponser;

    private Currency $currency;
    
    public function __construct(Currency $currency)
    {
        $this->currency = $currency;
        $this->middleware(['auth:api', 'permission:Manage Currencies']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->currency
            ->latest()
            ->get(['id', ...(new Currency())->getFillable()]);

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
        $currency = $this->currency->create($request->validated());

        return $this->success($currency, 'Currency created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Currency $currency
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Currency $currency)
    {
        return !$currency
            ? $this->noContent()
            : $this->success($currency);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Currency $currency
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Currency $currency)
    {
        $currency->update($request->except('id'));

        return $this->success(null, 'Currency updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {   
        $this->currency->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Currency or currencies deleted successfully.');
    }
}
