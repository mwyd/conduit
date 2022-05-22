<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexShadowpayFriendRequest;
use App\Http\Requests\Api\V1\UpsertShadowpayFriendRequest;
use App\Models\ShadowpayFriend;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ShadowpayFriendController extends Controller
{
    public function index(IndexShadowpayFriendRequest $request): JsonResponse
    {
        $friends = ShadowpayFriend::where('user_id', $request->user()->id)
            ->filter($request->validated())
            ->get();

        return response()->apiSuccess($friends, 200);
    }

    public function store(UpsertShadowpayFriendRequest $request): JsonResponse
    {
        $friend = ShadowpayFriend::create(['user_id' => $request->user()->id, ...$request->validated()]);

        return response()->apiSuccess($friend, 201);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(int $id): JsonResponse
    {
        $friend = ShadowpayFriend::findOrFail($id);

        $this->authorize('view', $friend);

        return response()->apiSuccess($friend, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpsertShadowpayFriendRequest $request, int $id): JsonResponse
    {
        $friend = ShadowpayFriend::findOrFail($id);

        $this->authorize('update', $friend);

        $friend->update($request->validated());

        return response()->apiSuccess($friend, 200);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(int $id): JsonResponse
    {
        $friend = ShadowpayFriend::findOrFail($id);

        $this->authorize('delete', $friend);

        $friend->delete();

        return response()->apiSuccess($friend, 200);
    }
}
