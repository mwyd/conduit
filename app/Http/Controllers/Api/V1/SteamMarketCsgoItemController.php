<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexSteamMarketCsgoItemRequest;
use App\Http\Requests\Api\V1\UpsertSteamMarketCsgoItemRequest;
use App\Models\SteamMarketCsgoItem;
use App\Services\SteamMarketCsgoItemService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class SteamMarketCsgoItemController extends Controller
{
    public function index(IndexSteamMarketCsgoItemRequest $request): JsonResponse
    {
        $items = SteamMarketCsgoItem::filter($request->validated())->get();

        return response()->apiSuccess($items, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(UpsertSteamMarketCsgoItemRequest $request, SteamMarketCsgoItemService $service): JsonResponse
    {
        $this->authorize('api-create');

        $item = $service->createFromRequestData($request->validated());

        return response()->apiSuccess($item, 201);
    }

    public function show(SteamMarketCsgoItem $item): JsonResponse
    {
        return response()->apiSuccess($item, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpsertSteamMarketCsgoItemRequest $request, SteamMarketCsgoItem $item): JsonResponse
    {
        $this->authorize('api-update');

        $item->update($request->validated());

        return response()->apiSuccess($item, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(SteamMarketCsgoItem $item): JsonResponse
    {
        $this->authorize('api-delete');

        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
