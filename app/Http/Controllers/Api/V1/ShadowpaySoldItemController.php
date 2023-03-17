<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexShadowpaySoldItemRequest;
use App\Http\Requests\Api\V1\UpsertShadowpaySoldItemRequest;
use App\Models\ShadowpaySoldItem;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ShadowpaySoldItemController extends Controller
{
    public function index(IndexShadowpaySoldItemRequest $request): JsonResponse
    {
        $items = ShadowpaySoldItem::filter($request->validated())->get();

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

    public function show(ShadowpaySoldItem $item): JsonResponse
    {
        return response()->apiSuccess($item, 200);
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
