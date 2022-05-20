<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\ShadowpayBotConfigFilter;
use App\Http\Requests\Api\V1\UpsertShadowpayBotConfigRequest;
use App\Models\ShadowpayBotConfig;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ShadowpayBotConfigController extends Controller
{
    public function index(ShadowpayBotConfigFilter $filter): JsonResponse
    {
        $configs = ShadowpayBotConfig::where('user_id', $filter->request()->user()->id)
            ->filter($filter)
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
    public function show(int $id): JsonResponse
    {
        $config = ShadowpayBotConfig::findOrFail($id);

        $this->authorize('view', $config);

        return response()->apiSuccess($config, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpsertShadowpayBotConfigRequest $request, int $id): JsonResponse
    {
        $config = ShadowpayBotConfig::findOrFail($id);

        $this->authorize('update', $config);

        $config->update($request->validated());

        return response()->apiSuccess($config, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(int $id): JsonResponse
    {
        $config = ShadowpayBotConfig::findOrFail($id);

        $this->authorize('delete', $config);

        $config->delete();

        return response()->apiSuccess($config, 200);
    }
}
