<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ShadowpayBotPreset;

class ShadowpayBotPresetController extends Controller
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
            'order_by' => Rule::in(['updated_at']),
            'order_dir' => Rule::in(['desc', 'asc']),
        ]);

        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 50);
        $orderBy = $request->input('order_by', 'updated_at');
        $orderDir = $request->input('order_dir', 'desc');

        $items = ShadowpayBotPreset::select('*')
                    ->where('user_id', $request->user()->id)
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
        $request->merge([
            'user_id' => $request->user()->id,
            'preset' => json_decode($request->preset, true)
        ]);

        $request->validate([
            'preset' => 'array'
        ]);

        $data = ShadowpayBotPreset::create($request->all());
        return response()->apiSuccess($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $presetId)
    {
        $item = ShadowpayBotPreset::where('user_id', $request->user()->id)->findOrFail($presetId);
        return response()->apiSuccess($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $presetId)
    {
        $request->merge([
            'preset' => json_decode($request->preset, true)
        ]);

        $request->validate([
            'preset' => 'array'
        ]);

        
        $item = ShadowpayBotPreset::where('user_id', $request->user()->id)->findOrFail($presetId);
        $item->update($request->all());

        return response()->apiSuccess($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $presetId)
    {
        $item = ShadowpayBotPreset::where('user_id', $request->user()->id)->findOrFail($presetId);
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
