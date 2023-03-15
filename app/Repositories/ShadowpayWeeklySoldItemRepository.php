<?php

namespace App\Repositories;

use App\Models\ShadowpayWeeklySoldItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ShadowpayWeeklySoldItemRepository
{
    private const TABLE = 'shadowpay_weekly_sold_items';

    public function getItemsCount(\DateTimeInterface $start, \DateTimeInterface $end): int
    {
        return $this->withDateRange($start, $end)->count();
    }

    public function getItemsValue(\DateTimeInterface $start, \DateTimeInterface $end): float
    {
        return $this->withDateRange($start, $end)->sum('price');
    }

    public function getItemsAverageDiscount(\DateTimeInterface $start, \DateTimeInterface $end): float
    {
        return $this->withDateRange($start, $end)->avg('discount') ?? 0;
    }

    public function getStarItemsCount(\DateTimeInterface $start, \DateTimeInterface $end): int
    {
        return $this->withDateRange($start, $end)
            ->where('hash_name', 'like', '★%')
            ->count();
    }

    public function getItemsSummary(\DateTimeInterface $start, \DateTimeInterface $end, int $perPage): LengthAwarePaginator
    {
        return DB::table(self::TABLE, 'sp')
            ->select([
                'sp.hash_name',
                DB::raw('count(sp.hash_name) as sold'),
                DB::raw('avg(sp.discount) as discount'),
                DB::raw('avg(sp.price) as price'),
                'sm.name',
                'sm.icon',
                'sm.exterior',
                'sm.phase',
                'sm.is_stattrak',
                'sm.price as steam_price',
                'bm.price as buff_price',
                'bm.good_id as good_id'
            ])
            ->join(
                'steam_market_csgo_items as sm',
                'sm.hash_name',
                '=',
                'sp.hash_name'
            )
            ->leftJoin(
                'buff_market_csgo_items as bm',
                'bm.hash_name',
                '=',
                'sp.hash_name'
            )
            ->where('sold_at', '>=', $start)
            ->where('sold_at', '<=', $end)
            ->groupBy('sp.hash_name')
            ->orderBy('sold', 'desc')
            ->paginate($perPage);
    }

    /**
     * @return Collection<string, Collection>
     */
    public function getItemsPriceHistory(): Collection
    {
        $items = DB::table(self::TABLE, 'sp')
            ->select([
                'hash_name',
                'price',
                'sold_at'
            ])
            ->orderBy('sold_at')
            ->get();

        return $items->groupBy('hash_name');
    }

    private function withDateRange(\DateTimeInterface $start, \DateTimeInterface $end): Builder
    {
        return ShadowpayWeeklySoldItem::query()
            ->where('sold_at', '>=', $start)
            ->where('sold_at', '<=', $end);
    }
}
