<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShadowpayFriend;
use Illuminate\Validation\Rule;

class ShadowpayFriendController extends Controller
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
            'order_by' => Rule::in(['updated_at', 'name']),
            'order_dir' => Rule::in(['desc', 'asc']),
        ]);

        $user = $request->user();

        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 50);
        $orderBy = $request->input('order_by', 'name');
        $orderDir = $request->input('order_dir', 'asc');

        $items = ShadowpayFriend::select('*')
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
            'name' => 'required|string',
            'shadowpay_id' => 'required|integer'
        ]);

        $data = ShadowpayFriend::create($request->all());

        return response()->apiSuccess($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $shadowpayId)
    {
        $user = $request->user();

        $item = ShadowpayFriend::where('user_id', $user->id)
                    ->findOrFail($shadowpayId);

        return response()->apiSuccess($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $shadowpayId)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'string',
            'shadowpay_id' => 'integer'
        ]);
        
        $item = ShadowpayFriend::where('user_id', $user->id)
                    ->findOrFail($shadowpayId);

        $item->update($request->all());

        return response()->apiSuccess($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $shadowpayId)
    {
        $user = $request->user();

        $item = ShadowpayFriend::where('user_id', $user->id)
                    ->findOrFail($shadowpayId);
                    
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
