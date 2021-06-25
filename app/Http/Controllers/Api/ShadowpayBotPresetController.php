<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\ShadowpayBotPreset;

class ShadowpayBotPresetController extends Controller
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

        $items = ShadowpayBotPreset::select('*')
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
            'preset'    => json_decode($request->preset, true)
        ]);

        $request->validate([
            'preset'    => 'required|array'
        ]);

        $data = ShadowpayBotPreset::create($request->all());

        return response()->apiSuccess($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $presetId
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $presetId)
    {
        $user = $request->user();

        $item = ShadowpayBotPreset::where('user_id', $user->id)
                    ->findOrFail($presetId);

        return response()->apiSuccess($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $presetId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $presetId)
    {
        $user = $request->user();

        $request->merge([
            'preset'    => json_decode($request->preset, true)
        ]);

        $request->validate([
            'preset'    => 'array'
        ]);
        
        $item = ShadowpayBotPreset::where('user_id', $user->id)
                    ->findOrFail($presetId);

        $item->update($request->all());

        return response()->apiSuccess($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $presetId
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $presetId)
    {
        $user = $request->user();

        $item = ShadowpayBotPreset::where('user_id', $user->id)
                    ->findOrFail($presetId);
                    
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
