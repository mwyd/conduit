<?php

namespace App\Http\Validation;

use Illuminate\Http\Request;

trait HasSteamMarketCsgoItemRules
{
    public function prepareSteamMarketCsgoItemRules(Request $request)
    {
        $params = [];

        if($request->has('is_stattrak'))
        {
            $params['is_stattrak'] = $request->boolean('is_stattrak');
        }

        if($request->has('exteriors'))
        {
            $params['exteriors'] = explode(',', $request->input('exteriors'));
        }

        if($request->has('tags'))
        {
            $params['tags'] = explode(',', $request->input('tags'));
        }

        $request->merge($params);
    }

    public function steamMarketCsgoItemRules()
    {
        return [
            'is_stattrak'   => 'sometimes|boolean',
            'exteriors'     => 'sometimes|array|max:5',
            'tags'          => 'sometimes|array|max:3'
        ];
    }
}