<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\CsgoRarePaintSeedItemFilter;
use App\Http\Requests\Api\V1\UpsertCsgoRarePaintSeedItemRequest;
use App\Models\CsgoRarePaintSeedItem;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class CsgoRarePaintSeedItemController extends Controller
{
    public function index(CsgoRarePaintSeedItemFilter $filter): JsonResponse
    {
        $items = CsgoRarePaintSeedItem::filter($filter)->get();

        return response()->apiSuccess($items, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(UpsertCsgoRarePaintSeedItemRequest $request): JsonResponse
    {
        $this->authorize('api-create');

        $item = CsgoRarePaintSeedItem::create($request->validated());

        return response()->apiSuccess($item, 201);
    }

    public function show(int $id): JsonResponse
    {
        $item = CsgoRarePaintSeedItem::findOrFail($id);

        return response()->apiSuccess($item, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpsertCsgoRarePaintSeedItemRequest $request, int $id): JsonResponse
    {
        $this->authorize('api-update');

        $item = CsgoRarePaintSeedItem::findOrFail($id);
        $item->update($request->validated());

        return response()->apiSuccess($item, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(int $id): JsonResponse
    {
        $this->authorize('api-delete');

        $item = CsgoRarePaintSeedItem::findOrFail($id);
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
