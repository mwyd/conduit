<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\ShadowpaySoldItem;

class ShadowpaySoldItemController extends Controller
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
            'order_by' => Rule::in(['sold', 'avg_sell_price', 'last_sold']),
            'order_dir' => Rule::in(['desc', 'asc']),
        ]);

        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 50);
        $search = $request->input('search', '');
        $orderBy = $request->input('order_by', 'sold');
        $orderDir = $request->input('order_dir', 'desc');

        $items = ShadowpaySoldItem::select(
                        DB::raw(
                            'hash_name, ' .
                            'count(hash_name) as sold, ' . 
                            'round(avg(discount), 2) as avg_discount, ' . 
                            'round(avg(sell_price), 2) as avg_sell_price, '. 
                            'round(avg(steam_price), 2) as avg_steam_price, ' . 
                            'max(sold_at) as last_sold'
                        )
                    )
                    ->where('hash_name', 'like', "%$search%")
                    ->groupBy('hash_name')
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

        $request->validate([
            'transaction_id' => 'required|string',
            'hash_name' => 'required|string',
            'discount' => 'required|integer',
            'sell_price' => 'numeric',
            'steam_price' => 'numeric',
            'sold_at' => 'required|date'
        ]);

        $data = ShadowpaySoldItem::create($request->all());

        return response()->apiSuccess($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($transactionId)
    {
        $item = ShadowpaySoldItem::findOrFail($transactionId);

        return response()->apiSuccess($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $transactionId)
    {
        $user = $request->user();

        if(!$user->tokenCan('api:put')) abort(403, 'forbidden');

        $request->validate([
            'transaction_id' => 'string',
            'hash_name' => 'string',
            'discount' => 'integer',
            'sell_price' => 'numeric',
            'steam_price' => 'numeric',
            'sold_at' => 'date'
        ]);

        $item = ShadowpaySoldItem::findOrFail($transactionId);
        $item->update($request->all());

        return response()->apiSuccess($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $transactionId)
    {
        $user = $request->user();

        if(!$user->tokenCan('api:delete')) abort(403, 'forbidden');

        $item = ShadowpaySoldItem::findOrFail($transactionId);
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
