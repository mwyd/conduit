<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexShadowpayBotConfigRequest;
use App\Http\Requests\UpsertShadowpayBotConfigRequest;
use App\Models\ShadowpayBotConfig;

class ShadowpayBotConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\IndexShadowpayBotConfigRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexShadowpayBotConfigRequest $request)
    {
        $offset     = $request->input('offset', 0);
        $limit      = $request->input('limit', 50);
        $orderBy    = $request->input('order_by', 'updated_at');
        $orderDir   = $request->input('order_dir', 'desc');

        $configs = ShadowpayBotConfig::select('*')
                    ->where('user_id', $request->user()->id)
                    ->offset($offset)
                    ->limit($limit)
                    ->orderBy($orderBy, $orderDir)
                    ->get();

        return response()->apiSuccess($configs, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UpsertShadowpayBotConfigRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpsertShadowpayBotConfigRequest $request)
    {
        $config = ShadowpayBotConfig::updateOrCreate(['user_id' => $request->user()->id], $request->validated());

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
     * @param  \App\Http\Requests\UpsertShadowpayBotConfigRequest  $request
     * @param  int  $configId
     * @return \Illuminate\Http\Response
     */
    public function update(UpsertShadowpayBotConfigRequest $request, $configId)
    {
        $config = ShadowpayBotConfig::findOrFail($configId);

        $this->authorize('update', $config);

        $config->update($request->validated());

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
