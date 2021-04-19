<?php

namespace App\Http\Controllers\Api\DoubleEntry\ChartOfAccount;

use App\Traits\Api\ApiResponser;
use App\Models\ChartOfAccountType;
use App\Http\Controllers\Controller;
use App\Http\Requests\DoubleEntry\ChartOfAccountType\StoreRequest;
use App\Http\Requests\DoubleEntry\ChartOfAccountType\DeleteRequest;
use App\Http\Requests\DoubleEntry\ChartOfAccountType\UpdateRequest;
use Illuminate\Support\Facades\Cache;

class ChartOfAccountTypesController extends Controller
{
    use ApiResponser;

    private ChartOfAccountType $accountType;
    
    public function __construct(ChartOfAccountType $accountType)
    {
        $this->accountType = $accountType;
        $this->middleware(['auth:api', 'permission:Manage Chart of Account Types']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = Cache::remember('chart_of_account_types', 1, function () 
        {
            $accountTypes = $this->accountType->latest()->get(['id', ...$this->accountType->getFillable()]);

            $data = [];

            foreach ($accountTypes as $accountType) {
                $data[$accountType->category][] = $accountType->name;
            }

            return $data;
        });

        return !count($result)
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
        $accountType = $this->accountType->create($request->validated());

        return $this->success($accountType, 'Chart of account type created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param App\Models\ChartOfAccountType $accountType
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ChartOfAccountType $accountType)
    {
        return !$accountType
            ? $this->noContent()
            : $this->success($accountType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param App\Models\ChartOfAccountType $accountType
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, ChartOfAccountType $accountType)
    {
        $accountType->update($request->except('id'));

        return $this->success(null, 'Chart of account type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->accountType->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Chart of account type or types deleted successfully.');
    }
}
