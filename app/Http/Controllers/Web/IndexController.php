<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ShadowpayWeeklySoldItemService;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
{
    public function __invoke(ShadowpayWeeklySoldItemService $shadowpayWeeklySoldItemService): Response
    {
        return Inertia::render('index', [
            'statistics' => $shadowpayWeeklySoldItemService->getStatistics(),
            'paginator' => $shadowpayWeeklySoldItemService->getItemsSummary()
        ]);
    }
}
