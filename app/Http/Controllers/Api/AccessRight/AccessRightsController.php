<?php

namespace App\Http\Controllers\Api\AccessRight;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccessRight\DestroyRequest;
use App\Http\Requests\AccessRight\StoreRequest;
use App\Http\Requests\AccessRight\UpdateRequest;
use App\Models\Role as ModelsRole;
use App\Traits\AccessRight\AccessRightServices;
use App\Traits\Api\ApiResponser;
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
        $roles = Role::latest()->get(['id', 'name', 'enabled']);

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
     * @param ModelsRole $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ModelsRole $role)
    {
        return !$role
            ? $this->noContent()
            : $this->success([
                'role' => $role->name,
                'permissions' => $role->permissions->map->name
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Role $role)
    {
        $result = $this->updateAccessRight(
            $role,
            $request->role_name,
            $request->permissions,
            $request->enabled
        );

        return $result !== true 
            ? $this->error($result, 500)
            : $this->success(null, 'Access right created successfully.');
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
