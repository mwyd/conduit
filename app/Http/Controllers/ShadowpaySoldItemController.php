<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ShadowpaySoldItem;
use Carbon\Carbon;

class ShadowpaySoldItemController extends Controller
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
                'sold', 
                'avg_discount', 
                'avg_sell_price', 
                'avg_steam_price', 
                'last_sold'
            ]),
            'order_dir'     => Rule::in(['desc', 'asc']),
            'date_start'    => 'date',
            'date_end'      => 'date',
            'price_from'    => 'numeric',
            'price_to'      => 'numeric',
            'min_sold'      => 'integer',
            'max_sold'      => 'integer'
        ]);

        $offset     = $request->input('offset', 0);
        $limit      = $request->input('limit', 50);
        $orderBy    = $request->input('order_by', 'sold');
        $orderDir   = $request->input('order_dir', 'desc');
        $dateStart  = $request->input('date_start', (new Carbon)->subWeek());
        $dateEnd    = $request->input('date_end');

        $search     = $request->input('search');
        $priceFrom  = $request->input('price_from');
        $priceTo    = $request->input('price_to');
        $minSold    = $request->input('min_sold');
        $maxSold    = $request->input('max_sold');

        $items = ShadowpaySoldItem::selectRaw(
                        'hash_name, ' .
                        'count(hash_name) as sold, ' . 
                        'round(avg(discount), 2) as avg_discount, ' . 
                        'round(avg(sell_price), 2) as avg_sell_price, '. 
                        'round(avg(steam_price), 2) as avg_steam_price, ' . 
                        'max(sold_at) as last_sold'
                    )
                    ->when($search, function($query, $search) {
                        return $query->where('hash_name', 'like', "%$search%");
                    })
                    ->when($dateStart, function($query, $dateStart) {
                        return $query->whereDate('sold_at', '>', $dateStart);
                    })
                    ->when($dateEnd, function($query, $dateEnd) {
                        return $query->whereDate('sold_at', '<=', $dateEnd);
                    })
                    ->when($priceFrom, function($query, $priceFrom) {
                        return $query->having('avg_steam_price', '>=', $priceFrom);
                    })
                    ->when($priceTo, function($query, $priceTo) {
                        return $query->having('avg_steam_price', '<=', $priceTo);
                    })
                    ->when($minSold, function($query, $minSold) {
                        return $query->having('sold', '>=', $minSold);
                    })
                    ->when($maxSold, function($query, $maxSold) {
                        return $query->having('sold', '<=', $maxSold);
                    })
                    ->with('steamMarketCsgoItem')
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
        $this->authorize('api-create');

        $request->validate([
            'transaction_id'    => 'required|string',
            'hash_name'         => 'required|string',
            'discount'          => 'required|integer',
            'sell_price'        => 'numeric',
            'steam_price'       => 'numeric',
            'sold_at'           => 'required|date'
        ]);

        $data = ShadowpaySoldItem::create($request->all());

        return response()->apiSuccess($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $transactionId
     * @return \Illuminate\Http\Response
     */
    public function show($transactionId)
    {
        $item = ShadowpaySoldItem::with('steamMarketCsgoItem')
                    ->findOrFail($transactionId);

        return response()->apiSuccess($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $transactionId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $transactionId)
    {
        $this->authorize('api-update');

        $request->validate([
            'transaction_id'    => 'string',
            'hash_name'         => 'string',
            'discount'          => 'integer',
            'sell_price'        => 'numeric',
            'steam_price'       => 'numeric',
            'sold_at'           => 'date'
        ]);

        $item = ShadowpaySoldItem::findOrFail($transactionId);
        $item->update($request->all());

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
