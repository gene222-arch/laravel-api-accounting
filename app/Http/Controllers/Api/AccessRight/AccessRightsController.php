<?php

namespace App\Http\Controllers\Api\AccessRight;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccessRight\DestroyRequest;
use App\Http\Requests\AccessRight\StoreRequest;
use App\Http\Requests\AccessRight\UpdateRequest;
use App\Models\Role;
use App\Traits\AccessRight\AccessRightServices;
use App\Traits\Api\ApiResponser;

class AccessRightsController extends Controller
{
    use ApiResponser, AccessRightServices;

    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:Manage Access Rights']);
    }

    /**
     * Display a listing of the resource access rights.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        setSqlModeEmpty();

        $roles = Role::selectRaw(
            'roles.id,
            roles.name,
            COUNT(model_has_roles.role_id) as employees'
        )
        ->leftJoin('model_has_roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->groupBy('roles.id')
        ->get();

        return !$roles->count()
            ? $this->noContent()
            : $this->success($roles);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $result = $this->createAccessRight(
            $request->role,
            $request->permissions,
            $request->enabled
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Access right created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role)
    {
        $result = Role::with('permissions')->find($role->id);

        return !$result
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Role $roleModel)
    {
        $result = $this->updateAccessRight(
            $roleModel,
            $request->role,
            $request->permissions,
            $request->enabled
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Access right updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DestroyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DestroyRequest $request)
    {
        Role::whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Access right or rights deleted successfully.');
    }

}
