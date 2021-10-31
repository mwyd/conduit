<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\ShadowpaySaleGuardItemFilter;
use App\Http\Requests\Api\V1\UpsertShadowpaySaleGuardItemRequest;
use App\Models\ShadowpaySaleGuardItem;

class ShadowpaySaleGuardItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Filters\ShadowpaySaleGuardItemFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(ShadowpaySaleGuardItemFilter $filter)
    {
        $items = ShadowpaySaleGuardItem::where('user_id', $filter->request()->user()->id)
                    ->with('steamMarketCsgoItem')
                    ->filter($filter)
                    ->get();

        return response()->apiSuccess($items, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\V1\UpsertShadowpaySaleGuardItemRequest  $request
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
        $item = ShadowpaySaleGuardItem::with('steamMarketCsgoItem')->findOrFail($itemId);

        $this->authorize('view', $item);

        return response()->apiSuccess($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\V1\UpsertShadowpaySaleGuardItemRequest  $request
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
