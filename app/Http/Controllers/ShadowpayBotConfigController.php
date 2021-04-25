<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ShadowpayBotConfig;

use function Psy\sh;

class ShadowpayBotConfigController extends Controller
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

        $items = ShadowpayBotConfig::select('*')
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
        $request->validate([
            'config' => 'json'
        ]);

        $user = $request->user();
        $data = array_merge($request->all(), ['user_id' => $user->id]);
        $data['config'] = json_decode($data['config']);

        $data = ShadowpayBotConfig::updateOrCreate(['user_id' => $user->id], $data);
        return response()->apiSuccess($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $configId)
    {
        $item = ShadowpayBotConfig::where('user_id', $request->user()->id)->findOrFail($configId);
        return response()->apiSuccess($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $configId)
    {
        $request->validate([
            'config' => 'json'
        ]);

        $request->merge(['config' => json_decode($request->config)]);
        $item = ShadowpayBotConfig::where('user_id', $request->user()->id)->findOrFail($configId);
        $item->update($request->all());

        return response()->apiSuccess($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $configId)
    {
        $item = ShadowpayBotConfig::where('user_id', $request->user()->id)->findOrFail($configId);
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
