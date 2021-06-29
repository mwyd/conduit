<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexCsgoBlueGemItemRequest;
use App\Http\Requests\UpsertCsgoBlueGemItemRequest;
use App\Models\CsgoBlueGemItem;

class CsgoBlueGemItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\IndexCsgoBlueGemItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexCsgoBlueGemItemRequest $request)
    {
        $offset     = $request->input('offset', 0);
        $limit      = $request->input('limit', 50);
        $orderBy    = $request->input('order_by', 'paint_seed');
        $orderDir   = $request->input('order_dir', 'desc');

        $search     = $request->input('search');
        $paintSeed  = $request->input('paint_seed');
        $gemType    = $request->input('gem_type');

        $items = CsgoBlueGemItem::select('*')
                    ->when($search, function($query, $search) {
                        return $query->where('item_type', 'like', "%$search%");
                    })
                    ->when($paintSeed, function($query, $paintSeed) {
                        return $query->where('paint_seed', $paintSeed);
                    })
                    ->when($gemType, function($query, $gemType) {
                        return $query->where('gem_type', $gemType);
                    })
                    ->offset($offset)
                    ->limit($limit)
                    ->orderBy($orderBy, $orderDir)
                    ->get();

        return response()->apiSuccess($items, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UpsertCsgoBlueGemItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpsertCsgoBlueGemItemRequest $request)
    {
        $this->authorize('api-create');

        $item = CsgoBlueGemItem::create($request->validated());

        return response()->apiSuccess($item, 201);
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
     * @param  \App\Http\Requests\UpsertCsgoBlueGemItemRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpsertCsgoBlueGemItemRequest $request, $id)
    {
        $this->authorize('api-update');

        $item = CsgoBlueGemItem::findOrFail($id);
        $item->update($request->validated());

        return response()->apiSuccess($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('api-delete');

        $item = CsgoBlueGemItem::findOrFail($id);
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
