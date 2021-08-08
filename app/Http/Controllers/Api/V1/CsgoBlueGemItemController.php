<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexCsgoBlueGemItemRequest;
use App\Http\Requests\Api\V1\UpsertCsgoBlueGemItemRequest;
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
        $items = CsgoBlueGemItem::filter($request->validated())->get();

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
