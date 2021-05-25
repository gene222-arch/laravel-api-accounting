<?php

namespace App\Http\Controllers\Api\AccessRight;

use Illuminate\Http\Request;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Traits\Cache\CacheServices;
use Illuminate\Support\Facades\Cache;
use App\Models\Permission;

class PermissionController extends Controller
{
    use ApiResponser, CacheServices;

    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:Manage Access Rights']);
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {   
        $key = $this->cacheKey('permissions');

        $result = Cache::store('redis')
            ->remember($key, 15, function () 
            {
                $permissions = Permission::all('id', 'name', 'batch_name');
                $groupedData = [];

                foreach ($permissions as $permission) {
                    $groupedData[$permission->batch_name][] = $permission;
                }

                uasort($groupedData, function ($permissionOne, $permissionTwo) {
                    return count($permissionOne) <=> count($permissionTwo);
                });

                return $groupedData;
            });

        return $this->success($result);
    }
}
