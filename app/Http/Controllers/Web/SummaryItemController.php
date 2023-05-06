<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\IndexRequest;
use App\Services\SummaryItemService;
use Inertia\Inertia;
use Inertia\Response;

class SummaryItemController extends Controller
{
    public function __construct(
        private readonly SummaryItemService $service
    ) {}

    public function index(IndexRequest $request): Response
    {
        return Inertia::render('index', [
            'filters' => fn () => $request->validated(),
            'statistics' => fn () => $this->service->getStatistics(),
            'paginator' => $this->service->getItemsSummary($request->validated()),
        ]);
    }

    public function show(string $hashName): Response
    {
        return Inertia::render('item', [
            'hashName' => $hashName,
            'paginator' => $this->service->getItemHistory($hashName)
        ]);
    }
}
