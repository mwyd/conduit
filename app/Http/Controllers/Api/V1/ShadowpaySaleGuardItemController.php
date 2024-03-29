<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexShadowpaySaleGuardItemRequest;
use App\Http\Requests\Api\V1\UpsertShadowpaySaleGuardItemRequest;
use App\Models\ShadowpaySaleGuardItem;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ShadowpaySaleGuardItemController extends Controller
{
    public function index(IndexShadowpaySaleGuardItemRequest $request): JsonResponse
    {
        $items = ShadowpaySaleGuardItem::where('user_id', $request->user()->id)
            ->filter($request->validated())
            ->get();

        return response()->apiSuccess($items, 200);
    }

    public function store(UpsertShadowpaySaleGuardItemRequest $request): JsonResponse
    {
        $item = ShadowpaySaleGuardItem::create(['user_id' => $request->user()->id, ...$request->validated()]);

        return response()->apiSuccess($item, 201);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(ShadowpaySaleGuardItem $item): JsonResponse
    {
        $this->authorize('view', $item);

        return response()->apiSuccess($item, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpsertShadowpaySaleGuardItemRequest $request, ShadowpaySaleGuardItem $item): JsonResponse
    {
        $this->authorize('update', $item);

        $item->update($request->validated());

        return response()->apiSuccess($item, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(ShadowpaySaleGuardItem $item): JsonResponse
    {
        $this->authorize('delete', $item);

        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
