<?php

namespace App\Repositories;

use App\Http\Filters\SummaryItemFilter;
use App\Models\ShadowpayWeeklySoldItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ShadowpayWeeklySoldItemRepository
{
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

    public function getItemsSummary(\DateTimeInterface $start, \DateTimeInterface $end, array $filters, int $perPage): LengthAwarePaginator
    {
        $groupedItems = DB::table('shadowpay_weekly_sold_items')
            ->select([
                'hash_name',
                'sold_at',
                DB::raw('count(hash_name) as sold'),
                DB::raw('avg(discount) as discount'),
                DB::raw('avg(price) as price'),
            ])
            ->where('sold_at', '>=', $start)
            ->where('sold_at', '<=', $end)
            ->groupBy('hash_name')
            ->orderBy('sold', 'desc');

        $query = DB::table('steam_market_csgo_items', 'sm')
            ->select([
                'sp.*',
                'sm.name',
                'sm.icon',
                'sm.exterior',
                'sm.phase',
                'sm.is_stattrak',
                'sm.price as steam_price',
                'bm.price as buff_price',
                'bm.good_id as good_id',
            ])
            ->joinSub(
                $groupedItems,
                'sp',
                'sm.hash_name',
                '=',
                'sp.hash_name'
            )
            ->leftJoin(
                'buff_market_csgo_items as bm',
                'bm.hash_name',
                '=',
                'sp.hash_name'
            );

        return (new SummaryItemFilter())->apply($query, $filters)->paginate($perPage);
    }

    /**
     * @return Collection<string, Collection>
     */
    public function getItemsPriceHistory(): Collection
    {
        $items = DB::table('shadowpay_weekly_sold_items')
            ->select([
                'hash_name',
                'price',
                'sold_at',
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
