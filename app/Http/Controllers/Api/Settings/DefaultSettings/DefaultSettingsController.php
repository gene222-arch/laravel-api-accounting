<?php

namespace App\Http\Controllers\Api\Settings\DefaultSettings;

use App\Models\DefaultSetting;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\DefaultSettings\DeleteRequest;
use App\Http\Requests\Settings\DefaultSettings\UpdateRequest;

class DefaultSettingsController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:Manage Default Settings']);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        return $this->success(DefaultSetting::first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param DefaultSetting $defaultSetting
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        DefaultSetting::first()->update($request->validated());

        return $this->success(null, 'Default settings updated successfully.');
    }
}
