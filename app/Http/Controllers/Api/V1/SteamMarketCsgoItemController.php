<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexSteamMarketCsgoItemRequest;
use App\Http\Requests\Api\V1\UpsertSteamMarketCsgoItemRequest;
use App\Models\SteamMarketCsgoItem;

class SteamMarketCsgoItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\IndexSteamMarketCsgoItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexSteamMarketCsgoItemRequest $request)
    {
        $offset     = $request->input('offset', 0);
        $limit      = $request->input('limit', 50);
        $search     = $request->input('search');
        $orderBy    = $request->input('order_by', 'updated_at');
        $orderDir   = $request->input('order_dir', 'desc');

        $items = SteamMarketCsgoItem::select('*')
                    ->when($search, function($query, $search) {
                        return $query->where('hash_name', 'like', "%$search%");
                    })
                    ->offset($offset)
                    ->limit($limit)
                    ->orderBy($orderBy, $orderDir)
                    ->get();

        return response()->apiSuccess($items, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UpsertSteamMarketCsgoItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpsertSteamMarketCsgoItemRequest $request)
    {
        $this->authorize('api-create');

        $item = SteamMarketCsgoItem::create($request->validated());

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
     * @param  \App\Http\Requests\UpsertSteamMarketCsgoItemRequest  $request
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
