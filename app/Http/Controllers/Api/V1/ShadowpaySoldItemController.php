<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexShadowpaySoldItemRequest;
use App\Http\Requests\Api\V1\UpsertShadowpaySoldItemRequest;
use App\Http\Requests\Api\V1\ShowTrendShadowpaySoldItemRequest;
use App\Models\ShadowpaySoldItem;
use Carbon\Carbon;

class ShadowpaySoldItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\IndexShadowpaySoldItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexShadowpaySoldItemRequest $request)
    {
        $offset     = $request->input('offset', 0);
        $limit      = $request->input('limit', 50);
        $orderBy    = $request->input('order_by', 'sold');
        $orderDir   = $request->input('order_dir', 'desc');
        $dateStart  = $request->input('date_start', Carbon::now()->subWeek());
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
     * @param  int  $transactionId
     * @return \Illuminate\Http\Response
     */
    public function show($transactionId)
    {
        $item = ShadowpaySoldItem::findOrFail($transactionId)->with('steamMarketCsgoItem');

        return response()->apiSuccess($item, 200);
    }

    /**
     * Display trend of the specified resource.
     *
     * @param  \App\Http\Requests\Api\V1\ShowTrendShadowpaySoldItemRequest  $request
     * @param  string  $hashName
     * @return \Illuminate\Http\Response
     */
    public function showTrend(ShowTrendShadowpaySoldItemRequest $request, $hashName)
    {
        $offset     = $request->input('offset', 0);
        $limit      = $request->input('limit', 50);
        $orderBy    = $request->input('order_by', 'sold_at');
        $orderDir   = $request->input('order_dir', 'asc');
        $dateStart  = $request->input('date_start', Carbon::now()->subDays(30));
        $dateEnd    = $request->input('date_end');

        $trend = ShadowpaySoldItem::selectRaw(
                        'date_format(sold_at, "%M %d") as date, ' .
                        'count(hash_name) as sold, ' .
                        'round(avg(sell_price) * avg((100 - discount) / 100), 2) as avg_sell_price, ' .
                        'round(avg(steam_price), 2) as avg_steam_price'
                    )
                    ->when($dateStart, function($query, $dateStart) {
                        return $query->whereDate('sold_at', '>', $dateStart);
                    })
                    ->when($dateEnd, function($query, $dateEnd) {
                        return $query->whereDate('sold_at', '<=', $dateEnd);
                    })
                    ->where('hash_name', $hashName)
                    ->groupBy('date')
                    ->offset($offset)
                    ->limit($limit)
                    ->orderBy($orderBy, $orderDir)
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
