<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexCsgoRarePaintSeedItemRequest;
use App\Http\Requests\Api\V1\UpsertCsgoRarePaintSeedItemRequest;
use App\Models\CsgoRarePaintSeedItem;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class CsgoRarePaintSeedItemController extends Controller
{
    public function index(IndexCsgoRarePaintSeedItemRequest $request): JsonResponse
    {
        $items = CsgoRarePaintSeedItem::filter($request->validated())->get();

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

    public function show(CsgoRarePaintSeedItem $item): JsonResponse
    {
        return response()->apiSuccess($item, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpsertCsgoRarePaintSeedItemRequest $request, CsgoRarePaintSeedItem $item): JsonResponse
    {
        $this->authorize('api-update');

        $item->update($request->validated());

        return response()->apiSuccess($item, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(CsgoRarePaintSeedItem $item): JsonResponse
    {
        $this->authorize('api-delete');

        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
