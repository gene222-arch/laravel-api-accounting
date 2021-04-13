<?php

namespace App\Http\Controllers\Api\ImportsControllers\Item;

use Illuminate\Http\Request;
use App\Traits\Api\ApiResponser;
use App\Imports\Items\ItemImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Imports\InventoryManagement\Stock\StockImport;
use App\Http\Requests\ImportsRequest\ImportRequest;


class ImportItemsController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:Import Items']);
    }

    /**
     * Import item
     *
     * @param ImportRequest $request
     * @return Illuminate\Http\JsonResponse
     */
    public function import(ImportRequest $request)
    {
        try {
            DB::transaction(function () use($request)
            {
                (new ItemImport)->import($request->file);
                (new StockImport)->import($request->file);
            });
        }
        catch (ValidationException $e)
        {
            return $this->error([
                'errors' => $e->failures(),
                'errorHeader' => 'Errors found in the file, refreshing selected file in order to apply upcoming changes.'
            ], 
            422);
        }

        return $this->success(null, 'Database updated');
    }
}
