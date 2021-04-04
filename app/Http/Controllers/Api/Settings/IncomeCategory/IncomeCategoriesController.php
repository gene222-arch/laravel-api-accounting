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
        $result = $this->incomeCategory->getAllIncomeCategories();

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
        $incomeCategory = $this->incomeCategory->createIncomeCategory(
            $request->name,
            $request->hexCode
        );

        return $this->success($incomeCategory, 'Income Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->incomeCategory->getIncomeCategoryById($id);

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
        $this->incomeCategory->updateIncomeCategory(
            $request->id,
            $request->name,
            $request->hexCode
        );

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
        $this->incomeCategory->deleteIncomeCategories($request->ids);

        return $this->success(null, 'Income Category or categories deleted successfully.');
    }
}
