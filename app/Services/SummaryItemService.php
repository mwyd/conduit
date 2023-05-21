<?php

namespace App\Services;

use App\Repositories\ShadowpaySoldItemRepository;
use App\Repositories\ShadowpayWeeklySoldItemRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SummaryItemService
{
    public function __construct(
        private readonly ShadowpayWeeklySoldItemRepository $shadowpayWeeklySoldItemRepository,
        private readonly ShadowpaySoldItemRepository $shadowpaySoldItemRepository
    ) {
    }

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

    public function getItemsSummary(array $filters): Collection
    {
        $now = new \DateTimeImmutable();

        $filters['date_start'] ??= $now->modify('-7 day');
        $filters['date_end'] ??= $now;

        $paginator = $this->shadowpayWeeklySoldItemRepository->getItemsSummary($filters, 100)->withQueryString();

        $offset = ($paginator->currentPage() - 1) * $paginator->perPage();

        return collect([
            'links' => $paginator->onEachSide(2)->linkCollection(),
            'data' => $paginator->map(fn ($item, $index) => $this->transformSummaryItem($item, $index + $offset)),
        ]);
    }

    public function getItemHistory(string $hashName): Collection
    {
        $paginator = $this->shadowpaySoldItemRepository->getItemHistory($hashName, 100)->withQueryString();

        $offset = ($paginator->currentPage() - 1) * $paginator->perPage();

        return collect([
            'links' => $paginator->onEachSide(2)->linkCollection(),
            'data' => $paginator->map(fn ($item, $index) => $this->transformItemHistory($item, $index + $offset)),
        ]);
    }

    private function buildStatistics(\DateTimeInterface $start, \DateTimeInterface $end): Collection
    {
        return collect([
            'count' => $this->shadowpayWeeklySoldItemRepository->getItemsCount($start, $end),
            'sum' => $this->shadowpayWeeklySoldItemRepository->getItemsValue($start, $end),
            'discount' => $this->shadowpayWeeklySoldItemRepository->getItemsAverageDiscount($start, $end),
            'star' => $this->shadowpayWeeklySoldItemRepository->getStarItemsCount($start, $end),
        ]);
    }

    private function transformStatistic(int|float $fresh, int|float $old): array
    {
        return [
            'value' => $fresh,
            'difference' => $fresh != 0 ? 100 - ($old / $fresh * 100) : 0,
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
            'isSouvenir' => (bool) $item->is_souvenir,
            'discount' => (float) $item->discount,
            'price' => (float) $item->price,
            'steamPrice' => (float) $item->steam_price,
            'buffPrice' => is_null($item->buff_price) ? null : (float) $item->buff_price,
            'goodId' => $item->good_id,
            'sold' => $item->sold,
            'sparkline' => md5($item->hash_name),
        ];
    }

    private function transformItemHistory(object $item, int $position): array
    {
        return [
            'position' => $position + 1,
            'transactionId' => $item->transaction_id,
            'discount' => (int) $item->discount,
            'price' => is_null($item->price) ? null : (float) $item->price,
            'steamPrice' => is_null($item->steam_price) ? null : (float) $item->steam_price,
            'date' => $item->sold_at,
            'dateDifference' => Carbon::create($item->sold_at)->diffForHumans(),
        ];
    }
}
