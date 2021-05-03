<?php

namespace App\Http\Controllers\Api\Item\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\Category\DeleteRequest;
use App\Http\Requests\Item\Category\StoreRequest;
use App\Http\Requests\Item\Category\UpdateRequest;
use App\Models\Category;
use App\Traits\Api\ApiResponser;

class CategoriesController extends Controller
{
    use ApiResponser;

    private Category $category;
    
    public function __construct(Category $category)
    {
        $this->category = $category;
        $this->middleware(['auth:api', 'permission:Manage Categories']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->category
            ->latest()
            ->get(['id', ...(new Category())->getFillable()]);

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $category = $this->category->create($request->validated());

        return $this->success($category,'Category created successfully.' );
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return !$category
            ? $this->noContent()
            : $this->success($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Category $category)
    {   
        $category->update($request->except('id'));

        return $this->success(null, 'Category updated successfully.');
    }

    /**
     * Remove the specified or multiple resource from storage.
     *
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->category->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Category or categories deleted successfully.');
    }
}
