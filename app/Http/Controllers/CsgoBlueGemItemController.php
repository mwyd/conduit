<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\CsgoBlueGemItem;

class CsgoBlueGemItemController extends Controller
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
            'paint_seed' => 'numeric',
            'gem_type' => Rule::in(['blue', 'gold']),
            'order_by' => Rule::in(['updated_at', 'item_type', 'paint_seed']),
            'order_dir' => Rule::in(['desc', 'asc']),
        ]);

        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 50);
        $search = $request->input('search', '');
        $paintSeed = $request->input('paint_seed');
        $gemType = $request->input('gem_type');
        $orderBy = $request->input('order_by', 'paint_seed');
        $orderDir = $request->input('order_dir', 'desc');

        $items = CsgoBlueGemItem::select('*')
                    ->when($paintSeed, function($query, $paintSeed) {
                        return $query->where('paint_seed', $paintSeed);
                    })
                    ->when($gemType, function($query, $gemType) {
                        return $query->where('gem_type', $gemType);
                    })
                    ->where('item_type', 'like', "%$search%")
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

        if(!$user->tokenCan('api:post')) abort(403, 'forbidden');
   
        $request->validate([
            'item_type' => 'required|string',
            'paint_seed' => 'required|integer',
            'gem_type' => 'required|string'
        ]);

        $data = CsgoBlueGemItem::create($request->all());

        return response()->apiSuccess($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = CsgoBlueGemItem::findOrFail($id);

        return response()->apiSuccess($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();

        if(!$user->tokenCan('api:put')) abort(403, 'forbidden');

        $request->validate([
            'item_type' => 'string',
            'paint_seed' => 'integer',
            'gem_type' => 'string'
        ]);

        $item = CsgoBlueGemItem::findOrFail($id);
        $item->update($request->all());

        return response()->apiSuccess($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        if(!$user->tokenCan('api:delete')) abort(403, 'forbidden');

        $item = CsgoBlueGemItem::findOrFail($id);
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
