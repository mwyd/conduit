<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\IndexRequest;
use App\Services\ShadowpayWeeklySoldItemService;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
{
    public function __construct(
        private readonly ShadowpayWeeklySoldItemService $service
    ) {}

    public function __invoke(IndexRequest $request): Response
    {
        return Inertia::render('index', [
            'filters' => fn () => $request->validated(),
            'statistics' => fn () => $this->service->getStatistics(),
            'paginator' => $this->service->getItemsSummary($request->validated()),
        ]);
    }
}
