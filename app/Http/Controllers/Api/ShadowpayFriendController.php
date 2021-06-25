<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\ShadowpayFriend;

class ShadowpayFriendController extends Controller
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
            'order_by'      => Rule::in(['updated_at', 'name']),
            'order_dir'     => Rule::in(['desc', 'asc'])
        ]);

        $user = $request->user();

        $offset     = $request->input('offset', 0);
        $limit      = $request->input('limit', 50);
        $orderBy    = $request->input('order_by', 'name');
        $orderDir   = $request->input('order_dir', 'asc');

        $friends = ShadowpayFriend::select('*')
                    ->where('user_id', $user->id)
                    ->offset($offset)
                    ->limit($limit)
                    ->orderBy($orderBy, $orderDir)
                    ->get();

        return response()->apiSuccess($friends, 200);
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
            'name'          => 'required|string',
            'shadowpay_id'  => 'required|integer'
        ]);

        $friend = ShadowpayFriend::create($request->all());

        return response()->apiSuccess($friend, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $shadowpayId
     * @return \Illuminate\Http\Response
     */
    public function show($shadowpayId)
    {
        $friend = ShadowpayFriend::findOrFail($shadowpayId);

        $this->authorize('view', $friend);

        return response()->apiSuccess($friend, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $shadowpayId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $shadowpayId)
    {
        $request->validate([
            'name'          => 'string',
            'shadowpay_id'  => 'integer'
        ]);
        
        $friend = ShadowpayFriend::findOrFail($shadowpayId);

        $this->authorize('update', $friend);

        $friend->update($request->all());

        return response()->apiSuccess($friend, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $shadowpayId
     * @return \Illuminate\Http\Response
     */
    public function destroy($shadowpayId)
    {
        $friend = ShadowpayFriend::findOrFail($shadowpayId);

        $this->authorize('delete', $friend);
                    
        $friend->delete();

        return response()->apiSuccess($friend, 200);
    }
}
