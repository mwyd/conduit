<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
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

        $configs = ShadowpayBotConfig::select('*')
                    ->where('user_id', $user->id)
                    ->offset($offset)
                    ->limit($limit)
                    ->orderBy($orderBy, $orderDir)
                    ->get();

        return response()->apiSuccess($configs, 200);
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

        $config = ShadowpayBotConfig::updateOrCreate([
                    'user_id' => $user->id
                ], $request->all());

        return response()->apiSuccess($config, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $configId
     * @return \Illuminate\Http\Response
     */
    public function show($configId)
    {
        $config = ShadowpayBotConfig::findOrFail($configId);

        $this->authorize('view', $config);

        return response()->apiSuccess($config, 200);
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
        $request->merge([
            'config'    => json_decode($request->config, true)
        ]);
        
        $request->validate([
            'config'    => 'array'
        ]);

        $config = ShadowpayBotConfig::findOrFail($configId);

        $this->authorize('update', $config);

        $config->update($request->all());

        return response()->apiSuccess($config, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $configId
     * @return \Illuminate\Http\Response
     */
    public function destroy($configId)
    {
        $config = ShadowpayBotConfig::findOrFail($configId);
                    
        $this->authorize('delete', $config);

        $config->delete();

        return response()->apiSuccess($config, 200);
    }
}
