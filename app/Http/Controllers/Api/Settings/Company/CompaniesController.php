<?php

namespace App\Http\Controllers\Api\Settings\Company;

use App\Models\Company;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Company\StoreRequest;
use App\Http\Requests\Settings\Company\UpdateRequest;

class CompaniesController extends Controller
{
    use ApiResponser;

    private Company $company;
    
    public function __construct(Company $company)
    {
        $this->company = $company;
        $this->middleware(['auth:api', 'permission:Manage Company']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $company = $this->company->createCompany(
            $request->name,
            $request->email,
            $request->taxNumber,
            $request->phone,
            $request->address,
            $request->logo
        );

        return $this->success($company, 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->company->getCompanyById($id);

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
        $this->company->updateCompany(
            $request->id,
            $request->name,
            $request->email,
            $request->taxNumber,
            $request->phone,
            $request->address,
            $request->logo
        );

        return $this->success(null, 'Company updated successfully.');
    }

}
