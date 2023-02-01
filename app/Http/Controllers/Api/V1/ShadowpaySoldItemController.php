<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexShadowpaySoldItemRequest;
use App\Http\Requests\Api\V1\ShowShadowpaySoldItemRequest;
use App\Http\Requests\Api\V1\ShowTrendShadowpaySoldItemRequest;
use App\Http\Requests\Api\V1\UpsertShadowpaySoldItemRequest;
use App\Models\ShadowpaySoldItem;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ShadowpaySoldItemController extends Controller
{
    public function index(IndexShadowpaySoldItemRequest $request): JsonResponse
    {
        $items = ShadowpaySoldItem::rawItem($request->validated())
            ->with('steamMarketCsgoItem')
            ->groupBy('hash_name')
            ->get();

        return response()->apiSuccess($items, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(UpsertShadowpaySoldItemRequest $request): JsonResponse
    {
        $this->authorize('api-create');

        $item = ShadowpaySoldItem::create($request->validated());

        return response()->apiSuccess($item, 201);
    }

    public function show(ShowShadowpaySoldItemRequest $request, string $hashName): JsonResponse
    {
        $item = ShadowpaySoldItem::rawItem($request->validated())
            ->where('hash_name', $hashName)
            ->with('steamMarketCsgoItem')
            ->groupBy('hash_name')
            ->firstOrFail();

        return response()->apiSuccess($item, 200);
    }

    public function showTrend(ShowTrendShadowpaySoldItemRequest $request, string $hashName): JsonResponse
    {
        $trend = ShadowpaySoldItem::rawTrend($request->validated())
            ->where('hash_name', $hashName)
            ->groupBy('date')
            ->get();

        return response()->apiSuccess($trend, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpsertShadowpaySoldItemRequest $request, ShadowpaySoldItem $item): JsonResponse
    {
        $this->authorize('api-update');

        $item->update($request->validated());

        return response()->apiSuccess($item, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(ShadowpaySoldItem $item): JsonResponse
    {
        $this->authorize('api-delete');

        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
