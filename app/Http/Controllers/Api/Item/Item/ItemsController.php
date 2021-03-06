<?php

namespace App\Http\Controllers\Api\Item\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\Item\DeleteRequest;
use App\Http\Requests\Item\Item\StoreRequest;
use App\Http\Requests\Item\Item\UpdateRequest;
use App\Http\Requests\Upload\UploadImageRequest;
use App\Models\Item;
use App\Traits\Api\ApiResponser;
use App\Traits\Upload\UploadServices;

class ItemsController extends Controller
{
    use ApiResponser, UploadServices;

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
            ->when(request()->get('isForSale'), fn ($q) => $q->where('is_for_sale', true));

        if (request()->get('includeStockTable')) {
            $result = $result
                ->whereHas('stock', fn ($q) => request()->get('hasStocks', false) ? $q->where('in_stock', '>', 0) : $q )
                ->with('stock');
        }

        $result = $result
            ->with('category')
            ->latest()
            ->get(['id', ...$this->item->getFillable()]);

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
        $result = $this->item->createItem(
            $request->item,
            $request->stock,
            $request->track_stock,
        );

        return $result !== true 
            ? $this->error(null, $result, 500)
            : $this->success(null, 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Item $item)
    {
        return !$item
            ? $this->noContent()
            : $this->success($item->with('stock')->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Item $item)
    {
        $result = $this->item->updateItem(
            $item,
            $request->item,
            $request->stock,
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
        $data = $this->uploadImage(
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
