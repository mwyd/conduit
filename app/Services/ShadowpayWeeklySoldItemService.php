<?php

namespace App\Services;

use App\Repositories\ShadowpayWeeklySoldItemRepository;
use Illuminate\Support\Collection;

class ShadowpayWeeklySoldItemService
{
    public function __construct(
        private readonly ShadowpayWeeklySoldItemRepository $shadowpayWeeklySoldItemRepository
    ) {}

    public function getStatistics(): Collection
    {
        $now = new \DateTimeImmutable();

        $todayStats = $this->buildStatistics(
            $now->modify('-1 day'),
            $now
        );

        $yesterdayStats = $this->buildStatistics(
            $now->modify('-2 days'),
            $now->modify('-1 day')
        );

        return $todayStats->map(fn ($stat, $key) => $this->transformStatistic($stat, $yesterdayStats[$key]));
    }

    public function getItemsSummary(): Collection
    {
        $now = new \DateTimeImmutable();

        $paginator = $this->shadowpayWeeklySoldItemRepository->getItemsSummary(
            $now->modify('-7 day'),
            $now,
            100
        );

        $offset = ($paginator->currentPage() - 1) * $paginator->perPage();

        return collect([
            'links' => $paginator->onEachSide(2)->linkCollection(),
            'data' => $paginator->map(fn ($item, $index) => $this->transformSummaryItem($item, $index + $offset))
        ]);
    }

    private function buildStatistics(\DateTimeInterface $start, \DateTimeInterface $end): Collection
    {
        return collect([
            'count' => $this->shadowpayWeeklySoldItemRepository->getItemsCount($start, $end),
            'sum' => $this->shadowpayWeeklySoldItemRepository->getItemsValue($start, $end),
            'discount' => $this->shadowpayWeeklySoldItemRepository->getItemsAverageDiscount($start, $end),
            'star' => $this->shadowpayWeeklySoldItemRepository->getStarItemsCount($start, $end)
        ]);
    }

    private function transformStatistic(int|float $fresh, int|float $old): array
    {
        return [
            'value' => $fresh,
            'difference' => $fresh != 0 ? 100 - ($old / $fresh * 100) : 0
        ];
    }

    private function transformSummaryItem(object $item, int $position): array
    {
        $hashName = $item->hash_name;
        $name = $item->name;

        if ($item->phase) {
            $hashName = str_replace(" {$item->phase}", '', $hashName);
            $name = str_replace(" {$item->phase}", '', $name);
        }

        return [
            'position' => $position + 1,
            'hashName' => $hashName,
            'name' => $name,
            'icon' => $item->icon,
            'exterior' => $item->exterior,
            'phase' => $item->phase,
            'isStattrak' => (bool) $item->is_stattrak,
            'discount' => (float) $item->discount,
            'price' => (float) $item->price,
            'steamPrice' => (float) $item->steam_price,
            'buffPrice' => is_null($item->buff_price) ? null : (float) $item->buff_price,
            'goodId' => $item->good_id,
            'sold' => $item->sold,
            'sparkline' => md5($item->hash_name)
        ];
    }
}
