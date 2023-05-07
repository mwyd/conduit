<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ShadowpaySoldItemRepository
{
    public function getItemHistory(string $hashName, int $perPage): LengthAwarePaginator
    {
        return DB::table('shadowpay_sold_items')
            ->select([
                'transaction_id',
                'discount',
                DB::raw('suggested_price * (100 - discount) / 100 as price'),
                'steam_price',
                'sold_at'
            ])
            ->where('hash_name', '=', $hashName)
            ->orderBy('sold_at', 'desc')
            ->paginate($perPage);
    }
}
