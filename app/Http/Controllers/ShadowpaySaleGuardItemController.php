<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ShadowpaySaleGuardItem;

class ShadowpaySaleGuardItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'offset' => 'gte:0|integer',
            'limit' => 'gt:0|lte:50|integer',
            'order_by' => Rule::in([
                'updated_at', 
                'shadowpay_item_id', 
                'min_price', 
                'max_price'
            ]),
            'order_dir' => Rule::in(['desc', 'asc']),
        ]);

        $user = $request->user();

        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 50);
        $orderBy = $request->input('order_by', 'updated_at');
        $orderDir = $request->input('order_dir', 'desc');

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
            'user_id' => $user->id
        ]);

        $request->validate([
            'shadowpay_item_id' => 'required|numeric',
            'min_price' => 'required|numeric',
            'max_price' => 'required|numeric'
        ]);

        $data = ShadowpaySaleGuardItem::create($request->all());

        return response()->apiSuccess($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $itemId)
    {
        $user = $request->user();

        $item = ShadowpaySaleGuardItem::where('user_id', $user->id)
                    ->findOrFail($itemId);

        return response()->apiSuccess($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $itemId)
    {
        $user = $request->user();

        $request->validate([
            'shadowpay_item_id' => 'numeric',
            'min_price' => 'numeric',
            'max_price' => 'numeric'
        ]);

        $item = ShadowpaySaleGuardItem::where('user_id', $user->id)
                    ->findOrFail($itemId);

        $item->update($request->all());

        return response()->apiSuccess($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $itemId)
    {
        $user = $request->user();

        $item = ShadowpaySaleGuardItem::where('user_id', $user->id)
                    ->findOrFail($itemId);
                    
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
