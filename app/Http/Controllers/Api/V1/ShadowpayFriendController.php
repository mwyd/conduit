<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexShadowpayFriendRequest;
use App\Http\Requests\Api\V1\UpsertShadowpayFriendRequest;
use App\Models\ShadowpayFriend;

class ShadowpayFriendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\IndexShadowpayFriendRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexShadowpayFriendRequest $request)
    {
        $friends = ShadowpayFriend::where('user_id', $request->user()->id)
                    ->filter($request->validated())
                    ->get();

        return response()->apiSuccess($friends, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UpsertShadowpayFriendRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpsertShadowpayFriendRequest $request)
    {
        $friend = ShadowpayFriend::create(['user_id' => $request->user()->id] + $request->validated());

        return response()->apiSuccess($friend, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $shadowpayId
     * @return \Illuminate\Http\Response
     */
    public function show($shadowpayId)
    {
        $friend = ShadowpayFriend::findOrFail($shadowpayId);

        $this->authorize('view', $friend);

        return response()->apiSuccess($friend, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpsertShadowpayFriendRequest $request
     * @param  int  $shadowpayId
     * @return \Illuminate\Http\Response
     */
    public function update(UpsertShadowpayFriendRequest $request, $shadowpayId)
    {
        $friend = ShadowpayFriend::findOrFail($shadowpayId);

        $this->authorize('update', $friend);

        $friend->update($request->validated());

        return response()->apiSuccess($friend, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $shadowpayId
     * @return \Illuminate\Http\Response
     */
    public function destroy($shadowpayId)
    {
        $friend = ShadowpayFriend::findOrFail($shadowpayId);

        $this->authorize('delete', $friend);
                    
        $friend->delete();

        return response()->apiSuccess($friend, 200);
    }
}
