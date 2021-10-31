<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\ShadowpayBotPresetFilter;
use App\Http\Requests\Api\V1\UpsertShadowpayBotPresetRequest;
use App\Models\ShadowpayBotPreset;

class ShadowpayBotPresetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Api\V1\IndexShadowpayBotPresetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(ShadowpayBotPresetFilter $filter)
    {
        $presets = ShadowpayBotPreset::where('user_id', $filter->request()->user()->id)
                    ->filter($filter)
                    ->get();

        return response()->apiSuccess($presets, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\V1\UpsertShadowpayBotPresetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpsertShadowpayBotPresetRequest $request)
    {
        $preset = ShadowpayBotPreset::create(['user_id' => $request->user()->id] + $request->validated());

        return response()->apiSuccess($preset, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $presetId
     * @return \Illuminate\Http\Response
     */
    public function show($presetId)
    {
        $preset = ShadowpayBotPreset::findOrFail($presetId);

        $this->authorize('view', $preset);

        return response()->apiSuccess($preset, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\V1\UpsertShadowpayBotPresetRequest  $request
     * @param  int  $presetId
     * @return \Illuminate\Http\Response
     */
    public function update(UpsertShadowpayBotPresetRequest $request, $presetId)
    {
        $preset = ShadowpayBotPreset::findOrFail($presetId);

        $this->authorize('update', $preset);

        $preset->update($request->validated());

        return response()->apiSuccess($preset, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $presetId
     * @return \Illuminate\Http\Response
     */
    public function destroy($presetId)
    {
        $preset = ShadowpayBotPreset::findOrFail($presetId);

        $this->authorize('delete', $preset);

        $preset->delete();

        return response()->apiSuccess($preset, 200);
    }
}
