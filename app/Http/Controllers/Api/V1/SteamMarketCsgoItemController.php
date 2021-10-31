<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\CreateSteamMarketCsgoItemAction;
use App\Http\Controllers\Controller;
use App\Http\Filters\SteamMarketCsgoItemFilter;
use App\Http\Requests\Api\V1\UpsertSteamMarketCsgoItemRequest;
use App\Models\SteamMarketCsgoItem;

class SteamMarketCsgoItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Filters\SteamMarketCsgoItemFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(SteamMarketCsgoItemFilter $filter)
    {
        $items = SteamMarketCsgoItem::filter($filter)->get();

        return response()->apiSuccess($items, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\V1\UpsertSteamMarketCsgoItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpsertSteamMarketCsgoItemRequest $request, CreateSteamMarketCsgoItemAction $action)
    {
        $this->authorize('api-create');

        $item = $action->execute($request->validated());

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
        $item = SteamMarketCsgoItem::findOrFail($hashName);

        return response()->apiSuccess($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\V1\UpsertSteamMarketCsgoItemRequest  $request
     * @param  string  $hashName
     * @return \Illuminate\Http\Response
     */
    public function update(UpsertSteamMarketCsgoItemRequest $request, $hashName)
    {
        $this->authorize('api-update');

        $item = SteamMarketCsgoItem::findOrFail($hashName);
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

        $item = SteamMarketCsgoItem::findOrFail($hashName);
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
