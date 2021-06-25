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

        $presets = ShadowpayBotPreset::select('*')
                    ->where('user_id', $user->id)
                    ->offset($offset)
                    ->limit($limit)
                    ->orderBy($orderBy, $orderDir)
                    ->get();

        return response()->apiSuccess($presets, 200);
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

        $preset = ShadowpayBotPreset::create($request->all());

        return response()->apiSuccess($preset, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $presetId
     * @return \Illuminate\Http\Response
     */
    public function show($presetId)
    {
        $preset = ShadowpayBotPreset::findOrFail($presetId);

        $this->authorize('view', $preset);

        return response()->apiSuccess($preset, 200);
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
        $request->merge([
            'preset'    => json_decode($request->preset, true)
        ]);

        $request->validate([
            'preset'    => 'array'
        ]);
        
        $preset = ShadowpayBotPreset::findOrFail($presetId);

        $this->authorize('update', $preset);

        $preset->update($request->all());

        return response()->apiSuccess($preset, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $presetId
     * @return \Illuminate\Http\Response
     */
    public function destroy($presetId)
    {
        $preset = ShadowpayBotPreset::findOrFail($presetId);

        $this->authorize('delete', $preset);
                    
        $preset->delete();

        return response()->apiSuccess($preset, 200);
    }
}
