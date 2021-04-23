<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\SaleGuardItem;

class SaleGuardItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try
        {
            $request->validate([
                'offset' => 'gte:0|numeric',
                'limit' => 'gt:0|lte:50|numeric',
                'order_by' => Rule::in(['updated_at', 'minimum_price', 'maximum_price']),
                'order_dir' => Rule::in(['desc', 'asc']),
            ]);

            $offset = $request->input('offset', 0);
            $limit = $request->input('limit', 50);
            $search = $request->input('search', '');
            $orderBy = $request->input('order_by', 'updated_at');
            $orderDir = $request->input('order_dir', 'desc');

            $items = SaleGuardItem::select('*')
                        ->where('hash_name', 'like', "%$search%")
                        ->offset($offset)
                        ->limit($limit)
                        ->orderBy($orderBy, $orderDir)
                        ->get();

            $response = response()->apiSuccess($items, 200);
        }
        catch(\Exception $e)
        {
            $err = exceptionToHttpCode($e);
            $response = response()->apiFail($err['message'], $err['code']);
        }

        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $data = SaleGuardItem::create($request->all());
            $response = response()->apiSuccess($data, 201);
        }
        catch(\Exception $e)
        {
            $err = exceptionToHttpCode($e);
            $response = response()->apiFail($err['message'], $err['code']);
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($itemId)
    {
        try
        {
            $item = SaleGuardItem::findOrFail($itemId);
            $response = response()->apiSuccess($item, 200);
        }
        catch(\Exception $e)
        {
            $err = exceptionToHttpCode($e);
            $response = response()->apiFail($err['message'], $err['code']);
        }

        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $itemId)
    {
        try
        {
            $item = SaleGuardItem::findOrFail($itemId);
            $item->update($request->all());

            $response = response()->apiSuccess($item, 200);
        }
        catch(\Exception $e)
        {
            $err = exceptionToHttpCode($e);
            $response = response()->apiFail($err['message'], $err['code']);
        }
        
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($itemId)
    {
        try
        {
            $item = SaleGuardItem::findOrFail($itemId);
            $item->delete();

            $response = response()->apiSuccess($item, 200);
        }
        catch(\Exception $e)
        {
            $err = exceptionToHttpCode($e);
            $response = response()->apiFail($err['message'], $err['code']);
        }
        
        return $response;
    }
}
