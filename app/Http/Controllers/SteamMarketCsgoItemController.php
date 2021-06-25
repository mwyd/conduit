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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'offset'        => 'integer|min:0',
            'limit'         => 'integer|between:0,50',
            'order_by'      => Rule::in([
                'hash_name',
                'updated_at', 
                'volume', 
                'price'
            ]),
            'order_dir'     => Rule::in(['desc', 'asc'])
        ]);

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('api-create');
   
        $request->validate([
            'hash_name' => 'required|string',
            'volume'    => 'required|integer',
            'price'     => 'required|numeric',
            'icon'      => 'required|string'
        ]);

        $data = SteamMarketCsgoItem::create($request->all());

        return response()->apiSuccess($data, 201);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $hashName
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $hashName)
    {
        $this->authorize('api-update');

        $request->validate([
            'hash_name' => 'string',
            'volume'    => 'integer',
            'price'     => 'numeric',
            'icon'      => 'string'
        ]);

        $item = SteamMarketCsgoItem::findOrFail($hashName);
        $item->update($request->all());

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
