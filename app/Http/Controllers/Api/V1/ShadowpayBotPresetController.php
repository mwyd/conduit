<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexShadowpayBotPresetRequest;
use App\Http\Requests\Api\V1\UpsertShadowpayBotPresetRequest;
use App\Models\ShadowpayBotPreset;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ShadowpayBotPresetController extends Controller
{
    public function index(IndexShadowpayBotPresetRequest $request): JsonResponse
    {
        $presets = ShadowpayBotPreset::where('user_id', $request->user()->id)
            ->filter($request->validated())
            ->get();

        return response()->apiSuccess($presets, 200);
    }

    public function store(UpsertShadowpayBotPresetRequest $request): JsonResponse
    {
        $preset = ShadowpayBotPreset::create(['user_id' => $request->user()->id, ...$request->validated()]);

        return response()->apiSuccess($preset, 201);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(ShadowpayBotPreset $preset): JsonResponse
    {
        $this->authorize('view', $preset);

        return response()->apiSuccess($preset, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpsertShadowpayBotPresetRequest $request, ShadowpayBotPreset $preset): JsonResponse
    {
        $this->authorize('update', $preset);

        $preset->update($request->validated());

        return response()->apiSuccess($preset, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(ShadowpayBotPreset $preset): JsonResponse
    {
        $this->authorize('delete', $preset);

        $preset->delete();

        return response()->apiSuccess($preset, 200);
    }
}
