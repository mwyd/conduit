<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexShadowpaySaleGuardItemRequest;
use App\Http\Requests\UpsertShadowpaySaleGuardItemRequest;
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
        $offset     = $request->input('offset', 0);
        $limit      = $request->input('limit', 50);
        $orderBy    = $request->input('order_by', 'updated_at');
        $orderDir   = $request->input('order_dir', 'desc');

        $items = ShadowpaySaleGuardItem::select('*')
                    ->where('user_id', $request->user()->id)
                    ->offset($offset)
                    ->limit($limit)
                    ->orderBy($orderBy, $orderDir)
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
