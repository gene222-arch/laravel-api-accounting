<?php

namespace App\Http\Controllers\Api\AccessRight;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Traits\Cache\CacheServices;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class RolesController extends Controller
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
        $id = request()->input('exceptRoleId');
        $enabled = request()->input('enabled');

        $key = $this->cacheKey('role');

        $roles = Cache::store('redis')->remember($key, Carbon::now()->endOfDay()->addSecond(), 
            function () use ($id, $enabled) {
                return Role::when($id, fn ($q) => $q->where('id', '!=', $id))
                    ->when($enabled, fn ($q) => $q->where('enabled', $enabled))
                    ->latest()
                    ->get([ 'id', 'name', 'enabled' ]);
            });

        return !$roles->count()
            ? $this->noContent()
            : $this->success($roles);
    }
}
