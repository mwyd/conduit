<?php

namespace App\Repositories;

use App\Models\ShadowpaySoldItem;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ShadowpaySoldItemRepository
{
    public function getItemHistory(string $hashName, int $perPage): LengthAwarePaginator
    {
        return ShadowpaySoldItem::query()
            ->select([
                'transaction_id',
                'discount',
                DB::raw('suggested_price * (100 - discount) / 100 as price'),
                'sold_at'
            ])
            ->where('hash_name', '=', $hashName)
            ->orderBy('sold_at', 'desc')
            ->paginate($perPage);
    }
}
