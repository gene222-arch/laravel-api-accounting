<?php

namespace App\Http\Controllers\Api\AccessRight;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccessRight\DestroyRequest;
use App\Http\Requests\AccessRight\StoreRequest;
use App\Http\Requests\AccessRight\UpdateRequest;
use App\Traits\AccessRight\AccessRightServices;
use App\Traits\Api\ApiResponser;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AccessRightsController extends Controller
{
    use ApiResponser, AccessRightServices;

    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:Manage Access Rights']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = Role::all(['id', 'name']);

        return !$result->count()
            ? $this->noContent()
            : $this->success([
                'roles' => $result
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
        $this->createAccessRight(
            $request->role,
            $request->permissions,
            $request->enabled
        );

        return $this->success(null, 'Access right created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = Role::find($id);

        return !$result
            ? $this->noContent()
            : $this->success([
                'role' => $result->name,
                'permissions' => $result->permissions
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $this->updateAccessRight(
            $request->id,
            $request->role,
            $request->permissions,
            $request->enabled
        );

        return $this->success(null, 'Access right updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DestroyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DestroyRequest $request)
    {
        $this->deleteAccessRights($request->ids);

        return $this->success(null, 'Access right or rights deleted successfully.');
    }

}
