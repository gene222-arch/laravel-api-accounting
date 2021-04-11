<?php

namespace App\Http\Controllers\Api\Item\Item;

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
        $this->middleware(['auth:api', 'permission:Manage Items']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->item
            ->latest()
            ->get(['id', ...$this->item->getFillable()]);

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
        $result = $this->item->createItem(
            $request->item,
            $request->stock,
            $request->taxes,
            $request->track_stock,
        );

        return $result !== true 
            ? $this->error(null, $result, 500)
            : $this->success(null, 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Item $item)
    {
        return !$item
            ? $this->noContent()
            : $this->success($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $result = $this->item->updateItem(
            $request->id,
            $request->item,
            $request->stock,
            $request->taxes,
            $request->track_stock,
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Item updated successfully.');
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
        $this->item->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Item or items deleted successfully.');
    }
}
