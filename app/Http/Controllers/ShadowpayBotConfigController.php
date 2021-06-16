<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ShadowpayBotConfig;

class ShadowpayBotConfigController extends Controller
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
            'order_by'      => Rule::in(['updated_at']),
            'order_dir'     => Rule::in(['desc', 'asc'])
        ]);

        $user = $request->user();

        $offset     = $request->input('offset', 0);
        $limit      = $request->input('limit', 50);
        $orderBy    = $request->input('order_by', 'updated_at');
        $orderDir   = $request->input('order_dir', 'desc');

        $items = ShadowpayBotConfig::select('*')
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
            'user_id'   => $user->id,
            'config'    => json_decode($request->config, true)
        ]);

        $request->validate([
            'config'    => 'required|array'
        ]);

        $data = ShadowpayBotConfig::updateOrCreate([
                    'user_id' => $user->id
                ], $request->all());

        return response()->apiSuccess($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $configId
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $configId)
    {
        $user = $request->user();

        $item = ShadowpayBotConfig::where('user_id', $user->id)
                    ->findOrFail($configId);

        return response()->apiSuccess($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $configId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $configId)
    {
        $user = $request->user();

        $request->merge([
            'config'    => json_decode($request->config, true)
        ]);
        
        $request->validate([
            'config'    => 'array'
        ]);

        $item = ShadowpayBotConfig::where('user_id', $user->id)
                    ->findOrFail($configId);

        $item->update($request->all());

        return response()->apiSuccess($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $configId
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $configId)
    {
        $user = $request->user();

        $item = ShadowpayBotConfig::where('user_id', $user->id)
                    ->findOrFail($configId);
                    
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
