<?php

namespace App\Http\Controllers\Api\Settings\Contribution;

use App\Models\Contribution;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Contribution\StoreRequest;
use App\Http\Requests\Settings\Contribution\DeleteRequest;
use App\Http\Requests\Settings\Contribution\UpdateRequest;

class ContributionsController extends Controller
{
    use ApiResponser;

    private Contribution $contribution;
    
    public function __construct(Contribution $contribution)
    {
        $this->contribution = $contribution;
        $this->middleware(['auth:api', 'permission:Manage Contributions']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->contribution->getAllContributions();

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
        $contribution = $this->contribution->createContribution(
            $request->name,
            $request->rate,
            $request->enabled
        );

        return $this->success($contribution, 'Contribution created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->contribution->getContributionById($id);

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
        $this->contribution->updateContribution(
            $request->id,
            $request->name,
            $request->rate,
            $request->enabled
        );

        return $this->success(null, 'Contribution updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->contribution->deleteContributions($request->ids);

        return $this->success(null, 'Contribution or contributions deleted successfully.');
    }
}
