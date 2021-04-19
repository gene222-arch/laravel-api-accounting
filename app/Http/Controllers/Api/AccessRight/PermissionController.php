<?php

namespace App\Http\Controllers\Api\AccessRight;

use Illuminate\Http\Request;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    use ApiResponser;

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
        $result = Cache::remember('permissions', 1, function () {
            return Permission::all('id', 'name');
        });

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }
}
