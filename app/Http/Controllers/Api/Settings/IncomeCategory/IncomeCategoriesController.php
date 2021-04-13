<?php

namespace App\Http\Controllers\Api\Settings\IncomeCategory;

use App\Models\IncomeCategory;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\IncomeCategory\StoreRequest;
use App\Http\Requests\Settings\IncomeCategory\DeleteRequest;
use App\Http\Requests\Settings\IncomeCategory\UpdateRequest;

class IncomeCategoriesController extends Controller
{
    use ApiResponser;

    private IncomeCategory $incomeCategory;
    
    public function __construct(IncomeCategory $incomeCategory)
    {
        $this->incomeCategory = $incomeCategory;
        $this->middleware(['auth:api', 'permission:Manage Income Categories']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->incomeCategory
            ->latest()
            ->get(['id', ...(new IncomeCategory())->getFillable()]);

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
        $incomeCategory = $this->incomeCategory->create($request->validated());

        return $this->success($incomeCategory, 'Income Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param IncomeCategory $incomeCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(IncomeCategory $incomeCategory)
    {
        return !$incomeCategory
            ? $this->noContent()
            : $this->success($incomeCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param IncomeCategory $incomeCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, IncomeCategory $incomeCategory)
    {
        $incomeCategory->update($request->except('id'));

        return $this->success(null, 'Income Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->incomeCategory->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Income Category or categories deleted successfully.');
    }
}
