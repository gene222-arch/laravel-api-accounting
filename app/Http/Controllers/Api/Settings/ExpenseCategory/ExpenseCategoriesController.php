<?php

namespace App\Http\Controllers\Api\Settings\ExpenseCategory;

use App\Models\ExpenseCategory;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ExpenseCategory\StoreRequest;
use App\Http\Requests\Settings\ExpenseCategory\DeleteRequest;
use App\Http\Requests\Settings\ExpenseCategory\UpdateRequest;

class ExpenseCategoriesController extends Controller
{
    use ApiResponser;

    private ExpenseCategory $expenseCategory;
    
    public function __construct(ExpenseCategory $expenseCategory)
    {
        $this->expenseCategory = $expenseCategory;
        $this->middleware(['auth:api', 'permission:Manage Expense Categories']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->expenseCategory
            ->latest()
            ->get(['id', ...$this->expenseCategory->getFillable()]);

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
        $expenseCategory = $this->expenseCategory->create($request->all());

        return $this->success($expenseCategory, 'Expense category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param ExpenseCategory $expenseCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        return !$expenseCategory
            ? $this->noContent()
            : $this->success($expenseCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param ExpenseCategory $expenseCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, ExpenseCategory $expenseCategory)
    {
        $expenseCategory->update($request->except('id'));

        return $this->success(null, 'Expense category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->expenseCategory->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Expense category or categories deleted successfully.');
    }
}
