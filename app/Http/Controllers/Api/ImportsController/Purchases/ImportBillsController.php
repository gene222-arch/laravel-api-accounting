<?php

namespace App\Http\Controllers\Api\ImportsController\Purchases;

use App\Traits\Api\ApiResponser;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Imports\Purchases\BillImport;
use App\Http\Requests\ImportsRequest\ImportRequest;
use Maatwebsite\Excel\Validators\ValidationException;

class ImportBillsController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:Import Bills']);
    }

    /**
     * Import bills
     *
     * @param ImportRequest $request
     * @return Illuminate\Http\JsonResponse
     */
    public function import(ImportRequest $request)
    {
        try {
            DB::transaction(function () use($request)
            {
                (new BillImport)->import($request->file);
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
