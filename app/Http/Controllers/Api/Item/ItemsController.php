<?php

namespace App\Http\Controllers\Api\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\Item\DeleteRequest;
use App\Http\Requests\Item\Item\StoreRequest;
use App\Http\Requests\Item\Item\UpdateRequest;
use App\Http\Requests\Upload\UploadImageRequest;
use App\Models\Item;
use App\Traits\Api\ApiResponser;

class ItemsController extends Controller
{
    use ApiResponser;

    private Item $item;
    
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->item->getAllItems();

        return !$result->count()
            ? $this->noContent()
            : $this->success([
                'data' => $result
            ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $item = $this->item->createItem(
            $request->categoryId,
            $request->sku,
            $request->barcode,
            $request->name,
            $request->description,
            $request->price,
            $request->cost,
            $request->soldBy,
            $request->isForSale,
            $request->image
        );

        return $this->success($item, 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->item->getItemById($id);

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
        $this->item->updateItem(
            $request->id,
            $request->categoryId,
            $request->sku,
            $request->barcode,
            $request->name,
            $request->description,
            $request->price,
            $request->cost,
            $request->soldBy,
            $request->isForSale,
            $request->image,
        );

        return $this->success(null, 'Item updated successfully.');
    }

    /**
     * Upload the specified resource.
     *
     * @param UploadImageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */   
    public function upload(UploadImageRequest $request)
    {
        $data = $this->item->uploadImage(
            $request,
            'items/images'
        );

        return $this->success($data, 'Image uploaded successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->item->deleteItems($request->ids);

        return $this->success(null, 'Item or items deleted successfully.');
    }
}
