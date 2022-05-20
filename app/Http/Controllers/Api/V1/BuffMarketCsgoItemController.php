<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\BuffMarketCsgoItemFilter;
use App\Http\Requests\Api\V1\UpsertBuffMarketCsgoItemRequest;
use App\Models\BuffMarketCsgoItem;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class BuffMarketCsgoItemController extends Controller
{
    public function index(BuffMarketCsgoItemFilter $filter): JsonResponse
    {
        $items = BuffMarketCsgoItem::filter($filter)->get();

        return response()->apiSuccess($items, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(UpsertBuffMarketCsgoItemRequest $request): JsonResponse
    {
        $this->authorize('api-create');

        $item = BuffMarketCsgoItem::create($request->validated());

        return response()->apiSuccess($item, 201);
    }

    public function show(string $hashName): JsonResponse
    {
        $item = BuffMarketCsgoItem::findOrFail($hashName);

        return response()->apiSuccess($item, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpsertBuffMarketCsgoItemRequest $request, string $hashName): JsonResponse
    {
        $this->authorize('api-update');

        $item = BuffMarketCsgoItem::findOrFail($hashName);
        $item->update($request->validated());

        return response()->apiSuccess($item, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(string $hashName): JsonResponse
    {
        $this->authorize('api-delete');

        $item = BuffMarketCsgoItem::findOrFail($hashName);
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
