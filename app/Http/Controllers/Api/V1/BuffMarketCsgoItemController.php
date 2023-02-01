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

    public function show(BuffMarketCsgoItem $item): JsonResponse
    {
        return response()->apiSuccess($item, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpsertBuffMarketCsgoItemRequest $request, BuffMarketCsgoItem $item): JsonResponse
    {
        $this->authorize('api-update');

        $item->update($request->validated());

        return response()->apiSuccess($item, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(BuffMarketCsgoItem $item): JsonResponse
    {
        $this->authorize('api-delete');

        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
