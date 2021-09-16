<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\CsgoRarePaintSeedItemFilter;
use App\Http\Requests\Api\V1\UpsertCsgoRarePaintSeedItemRequest;
use App\Models\CsgoRarePaintSeedItem;

class CsgoRarePaintSeedItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Filters\CsgoRarePaintSeedItemFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(CsgoRarePaintSeedItemFilter $filter)
    {
        $items = CsgoRarePaintSeedItem::filter($filter)->get();

        return response()->apiSuccess($items, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UpsertCsgoRarePaintSeedItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpsertCsgoRarePaintSeedItemRequest $request)
    {
        $this->authorize('api-create');

        $item = CsgoRarePaintSeedItem::create($request->validated());

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
        $item = CsgoRarePaintSeedItem::findOrFail($id);

        return response()->apiSuccess($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpsertCsgoRarePaintSeedItemRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpsertCsgoRarePaintSeedItemRequest $request, $id)
    {
        $this->authorize('api-update');

        $item = CsgoRarePaintSeedItem::findOrFail($id);
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

        $item = CsgoRarePaintSeedItem::findOrFail($id);
        $item->delete();

        return response()->apiSuccess($item, 200);
    }
}
