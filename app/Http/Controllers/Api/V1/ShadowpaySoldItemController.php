<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\ShadowpaySoldItemFilter;
use App\Http\Filters\ShadowpaySoldItemShowFilter;
use App\Http\Filters\ShadowpaySoldItemTrendFilter;
use App\Http\Requests\Api\V1\UpsertShadowpaySoldItemRequest;
use App\Models\ShadowpaySoldItem;

class ShadowpaySoldItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Filters\ShadowpaySoldItemFilter  $request
     * @return \Illuminate\Http\Response
     */
    public function index(ShadowpaySoldItemFilter $filter)
    {
        $items = ShadowpaySoldItem::rawItem()
                    ->with('steamMarketCsgoItem')
                    ->groupBy('hash_name')
                    ->filter($filter)
                    ->get();

        return response()->apiSuccess($items, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UpsertShadowpaySoldItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpsertShadowpaySoldItemRequest $request)
    {
        $this->authorize('api-create');

        $item = ShadowpaySoldItem::create($request->validated());

        return response()->apiSuccess($item, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Filters\ShadowpaySoldItemShowFilter  $filter
     * @param  string  $hashName
     * @return \Illuminate\Http\Response
     */
    public function show(ShadowpaySoldItemShowFilter $filter, $hashName)
    {
        $item = ShadowpaySoldItem::rawItem()
                    ->where('hash_name', $hashName)
                    ->with('steamMarketCsgoItem')
                    ->groupBy('hash_name')
                    ->filter($filter)
                    ->firstOrFail();

        return response()->apiSuccess($item, 200);
    }

    /**
     * Display trend of the specified resource.
     *
     * @param  \App\Http\Filters\ShadowpaySoldItemTrendFilter  $filter
     * @param  string  $hashName
     * @return \Illuminate\Http\Response
     */
    public function showTrend(ShadowpaySoldItemTrendFilter $filter, $hashName)
    {
        $trend = ShadowpaySoldItem::rawTrend()
                    ->where('hash_name', $hashName)
                    ->groupBy('date')
                    ->filter($filter)
                    ->get();

        return response()->apiSuccess($trend, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpsertShadowpaySoldItemRequest  $request
     * @param  int  $transactionId
     * @return \Illuminate\Http\Response
     */
    public function update(UpsertShadowpaySoldItemRequest $request, $transactionId)
    {
        $this->authorize('api-update');

        $item = ShadowpaySoldItem::findOrFail($transactionId);
        $item->update($request->validated());

        return response()->apiSuccess($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $transactionId
     * @return \Illuminate\Http\Response
     */
    public function destroy($transactionId)
    {
        $this->authorize('api-delete');

        $item = ShadowpaySoldItem::findOrFail($transactionId);
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
