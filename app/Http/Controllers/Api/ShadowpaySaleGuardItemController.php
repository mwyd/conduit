<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\ShadowpaySaleGuardItem;

class ShadowpaySaleGuardItemController extends Controller
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
                'updated_at', 
                'shadowpay_item_id', 
                'min_price', 
                'max_price'
            ]),
            'order_dir'     => Rule::in(['desc', 'asc'])
        ]);

        $user = $request->user();

        $offset     = $request->input('offset', 0);
        $limit      = $request->input('limit', 50);
        $orderBy    = $request->input('order_by', 'updated_at');
        $orderDir   = $request->input('order_dir', 'desc');

        $items = ShadowpaySaleGuardItem::select('*')
                    ->where('user_id', $user->id)
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

        $request->merge([
            'user_id'   => $user->id
        ]);

        $request->validate([
            'shadowpay_item_id' => 'required|numeric',
            'min_price'         => 'required|numeric',
            'max_price'         => 'required|numeric'
        ]);

        $item = ShadowpaySaleGuardItem::create($request->all());

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
        $item = ShadowpaySaleGuardItem::findOrFail($itemId);

        $this->authorize('view', $item);

        return response()->apiSuccess($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $itemId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'shadowpay_item_id' => 'numeric',
            'min_price'         => 'numeric',
            'max_price'         => 'numeric'
        ]);

        $item = ShadowpaySaleGuardItem::findOrFail($itemId);

        $this->authorize('update', $item);

        $item->update($request->all());

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
