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
        $result = $this->expenseCategory->getAllExpenseCategories();

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
        $expenseCategory = $this->expenseCategory->createExpenseCategory(
            $request->name,
            $request->hexCode
        );

        return $this->success($expenseCategory, 'Expense category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->expenseCategory->getExpenseCategoryById($id);

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
        $this->expenseCategory->updateExpenseCategory(
            $request->id,
            $request->name,
            $request->hexCode
        );

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
        $this->expenseCategory->deleteExpenseCategories($request->ids);

        return $this->success(null, 'Expense category or categories deleted successfully.');
    }
}
