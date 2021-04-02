<?php

namespace App\Http\Controllers\Api\Item;

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
        $result = $this->category->getAllCategories();

        return !$result->count()
            ? $this->noContent()
            : $this->success([
                'data' => $result
            ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $category = $this->category->createCategory(
            $request->name,
            $request->hexCode
        );

        return $this->success(
            $category, 
            'Category created successfully.'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->category->getCategoryById($id);

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
        $this->category->updateCategory(
            $request->id,
            $request->name,
            $request->hexCode
        );

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
        $this->category->deleteCategories($request->ids);

        return $this->success(null, 'Category or categories deleted successfully.');
    }
}
