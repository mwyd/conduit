<?php

namespace App\Api;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

final class BuffApi
{
    private const URL = 'https://buff.163.com/api';

    public function getSellOrders(int $goodId): Response
    {
        return Http::get(self::URL.'/market/goods/sell_order', [
            'game' => 'csgo',
            'goods_id' => $goodId,
            'page_num' => 1,
            'sort_by' => 'default',
            'mode' => '',
            'allow_tradable_cooldown' => 1,
            '_' => time(),
        ]);
    }
}
