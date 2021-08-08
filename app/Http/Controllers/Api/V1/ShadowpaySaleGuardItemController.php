<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexShadowpaySaleGuardItemRequest;
use App\Http\Requests\Api\V1\UpsertShadowpaySaleGuardItemRequest;
use App\Models\ShadowpaySaleGuardItem;

class ShadowpaySaleGuardItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\IndexShadowpaySaleGuardItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexShadowpaySaleGuardItemRequest $request)
    {
        $items = ShadowpaySaleGuardItem::where('user_id', $request->user()->id)
                    ->filter($request->validated())
                    ->get();

        return response()->apiSuccess($items, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UpsertShadowpaySaleGuardItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpsertShadowpaySaleGuardItemRequest $request)
    {
        $item = ShadowpaySaleGuardItem::create(['user_id' => $request->user()->id] + $request->validated());

        return response()->apiSuccess($item, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $itemId
     * @return \Illuminate\Http\Response
     */
    public function show($itemId)
    {
        $item = ShadowpaySaleGuardItem::findOrFail($itemId);

        $this->authorize('view', $item);

        return response()->apiSuccess($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpsertShadowpaySaleGuardItemRequest  $request
     * @param  int  $itemId
     * @return \Illuminate\Http\Response
     */
    public function update(UpsertShadowpaySaleGuardItemRequest $request, $itemId)
    {
        $item = ShadowpaySaleGuardItem::findOrFail($itemId);

        $this->authorize('update', $item);

        $item->update($request->validated());

        return response()->apiSuccess($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $itemId
     * @return \Illuminate\Http\Response
     */
    public function destroy($itemId)
    {
        $item = ShadowpaySaleGuardItem::findOrFail($itemId);

        $this->authorize('delete', $item);
                    
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
