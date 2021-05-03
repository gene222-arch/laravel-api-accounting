<?php

namespace App\Http\Controllers\Api\Settings\Company;

use App\Models\Company;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Company\UpdateStoreRequest;

class CompaniesController extends Controller
{
    use ApiResponser;

    private Company $company;
    
    public function __construct(Company $company)
    {
        $this->company = $company;
        $this->middleware(['auth:api', 'permission:Manage Companies']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param UpdateStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UpdateStoreRequest $request)
    {
        $company = $this->company->create($request->validated());

        return $this->success($company, 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Company $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Company $company)
    {
        return !$company
            ? $this->noContent()
            : $this->success($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateStoreRequest $request, Company $company)
    {
        $company->update($request->except('id'));

        return $this->success(null, 'Company updated successfully.');
    }

}
