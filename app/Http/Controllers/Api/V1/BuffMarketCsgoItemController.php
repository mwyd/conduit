<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexBuffMarketCsgoItemRequest;
use App\Http\Requests\Api\V1\UpsertBuffMarketCsgoItemRequest;
use App\Models\BuffMarketCsgoItem;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class BuffMarketCsgoItemController extends Controller
{
    public function index(IndexBuffMarketCsgoItemRequest $request): JsonResponse
    {
        $items = BuffMarketCsgoItem::filter($request->validated())->get();

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
