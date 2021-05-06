<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\SteamMarketCsgoItem;

class SteamMarketCsgoItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'offset' => 'gte:0|numeric',
            'limit' => 'gt:0|lte:50|numeric',
            'order_by' => Rule::in(['updated_at', 'volume', 'price']),
            'order_dir' => Rule::in(['desc', 'asc']),
        ]);

        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 50);
        $search = $request->input('search', '');
        $orderBy = $request->input('order_by', 'updated_at');
        $orderDir = $request->input('order_dir', 'desc');

        $items = SteamMarketCsgoItem::select('*')
                    ->where('hash_name', 'like', "%$search%")
                    ->offset($offset)
                    ->limit($limit)
                    ->orderBy($orderBy, $orderDir)
                    ->get();

        return response()->apiSuccess($items, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if(!$user->tokenCan('api:post')) abort(403, 'forbidden');
   
        $data = SteamMarketCsgoItem::create($request->all());

        return response()->apiSuccess($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $hashName)
    {
        $user = $request->user();

        if(!$user->tokenCan('api:put')) abort(403, 'forbidden');

        $item = SteamMarketCsgoItem::findOrFail($hashName);
        $item->update($request->all());

        return response()->apiSuccess($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $hashName)
    {
        $user = $request->user();

        if(!$user->tokenCan('api:delete')) abort(403, 'forbidden');

        $item = SteamMarketCsgoItem::findOrFail($hashName);
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
