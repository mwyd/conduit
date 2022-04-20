<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\BuffMarketCsgoItemFilter;
use App\Http\Requests\Api\V1\UpsertBuffMarketCsgoItemRequest;
use App\Models\BuffMarketCsgoItem;

class BuffMarketCsgoItemController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Filters\BuffMarketCsgoItemFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(BuffMarketCsgoItemFilter $filter)
    {
        $items = BuffMarketCsgoItem::filter($filter)->get();

        return response()->apiSuccess($items, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\V1\UpsertBuffMarketCsgoItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpsertBuffMarketCsgoItemRequest $request)
    {
        $this->authorize('api-create');

        $item = BuffMarketCsgoItem::create($request->validated());

        return response()->apiSuccess($item, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $hashName
     * @return \Illuminate\Http\Response
     */
    public function show($hashName)
    {
        $item = BuffMarketCsgoItem::findOrFail($hashName);

        return response()->apiSuccess($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\V1\UpsertBuffMarketCsgoItemRequest  $request
     * @param  string  $hashName
     * @return \Illuminate\Http\Response
     */
    public function update(UpsertBuffMarketCsgoItemRequest $request, $hashName)
    {
        $this->authorize('api-update');

        $item = BuffMarketCsgoItem::findOrFail($hashName);
        $item->update($request->validated());

        return response()->apiSuccess($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $hashName
     * @return \Illuminate\Http\Response
     */
    public function destroy($hashName)
    {
        $this->authorize('api-delete');

        $item = BuffMarketCsgoItem::findOrFail($hashName);
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
