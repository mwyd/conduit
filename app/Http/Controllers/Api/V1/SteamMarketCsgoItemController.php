<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\CreateSteamMarketCsgoItemAction;
use App\Http\Controllers\Controller;
use App\Http\Filters\SteamMarketCsgoItemFilter;
use App\Http\Requests\Api\V1\UpsertSteamMarketCsgoItemRequest;
use App\Models\SteamMarketCsgoItem;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class SteamMarketCsgoItemController extends Controller
{
    public function index(SteamMarketCsgoItemFilter $filter): JsonResponse
    {
        $items = SteamMarketCsgoItem::filter($filter)->get();

        return response()->apiSuccess($items, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(UpsertSteamMarketCsgoItemRequest $request, CreateSteamMarketCsgoItemAction $action): JsonResponse
    {
        $this->authorize('api-create');

        $item = $action->execute($request->validated());

        return response()->apiSuccess($item, 201);
    }

    public function show(string $hashName): JsonResponse
    {
        $item = SteamMarketCsgoItem::findOrFail($hashName);

        return response()->apiSuccess($item, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpsertSteamMarketCsgoItemRequest $request, string $hashName): JsonResponse
    {
        $this->authorize('api-update');

        $item = SteamMarketCsgoItem::findOrFail($hashName);
        $item->update($request->validated());

        return response()->apiSuccess($item, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(string $hashName): JsonResponse
    {
        $this->authorize('api-delete');

        $item = SteamMarketCsgoItem::findOrFail($hashName);
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
