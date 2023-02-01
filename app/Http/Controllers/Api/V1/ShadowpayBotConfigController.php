<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexShadowpayBotConfigRequest;
use App\Http\Requests\Api\V1\UpsertShadowpayBotConfigRequest;
use App\Models\ShadowpayBotConfig;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ShadowpayBotConfigController extends Controller
{
    public function index(IndexShadowpayBotConfigRequest $request): JsonResponse
    {
        $configs = ShadowpayBotConfig::where('user_id', $request->user()->id)
            ->filter($request->validated())
            ->get();

        return response()->apiSuccess($configs, 200);
    }

    public function store(UpsertShadowpayBotConfigRequest $request): JsonResponse
    {
        $config = ShadowpayBotConfig::updateOrCreate(['user_id' => $request->user()->id], $request->validated());

        return response()->apiSuccess($config, 201);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(ShadowpayBotConfig $config): JsonResponse
    {
        $this->authorize('view', $config);

        return response()->apiSuccess($config, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpsertShadowpayBotConfigRequest $request, ShadowpayBotConfig $config): JsonResponse
    {
        $this->authorize('update', $config);

        $config->update($request->validated());

        return response()->apiSuccess($config, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(ShadowpayBotConfig $config): JsonResponse
    {
        $this->authorize('delete', $config);

        $config->delete();

        return response()->apiSuccess($config, 200);
    }
}
