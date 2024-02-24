<?php

namespace App\Console\Commands;

use App\Repositories\ShadowpayWeeklySoldItemRepository;
use App\Utility\Sparkline\Sparkline;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class GenerateShadowpayWeeklySoldItemSparklines extends Command
{
    protected $signature = 'shadowpay-weekly-sold-item:generate-sparklines';

    protected $description = 'Generate sparklines for all weekly sold shadowpay items';

    public function handle(ShadowpayWeeklySoldItemRepository $shadowpayWeeklySoldItemRepository): void
    {
        $history = $shadowpayWeeklySoldItemRepository->getItemsPriceHistory();

        $bar = $this->output->createProgressBar($history->count());

        $this->output->info('Generating sparklines');

        foreach ($history as $hashName => $rows) {
            $prices = $this->reducePrices($rows, 8);

            $first = $prices->first();
            $last = $prices->last();

            $color = $first < $last ? '#57bd0f' : '#ed5565';

            $sparkline = Sparkline::make($prices)
                ->withColor($color)
                ->render();

            Storage::put(
                'public/sparkline/7d/'.md5($hashName).'.svg',
                $sparkline
            );

            $bar->advance();
        }

        $bar->finish();

        $this->output->newLine(2);
        $this->output->info('Done');
    }

    /**
     * @param  Collection<int, object>  $rows
     * @return Collection<int, float>
     */
    private function reducePrices(Collection $rows, int $chunkSize): Collection
    {
        $result = collect();

        $groupedByDate = $rows->groupBy(fn ($item) => substr($item->sold_at, 0, strpos($item->sold_at, ' ')));

        foreach ($groupedByDate as $prices) {
            $size = (int) ceil(count($prices) / $chunkSize);

            $values = $prices->chunk($size)->map(fn ($chunk) => $chunk->avg('price'));

            $result->push(...$values);
        }

        return $result;
    }
}
