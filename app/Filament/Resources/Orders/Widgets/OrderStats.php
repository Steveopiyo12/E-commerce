<?php

namespace App\Filament\Resources\Orders\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        $averagePrice = Order::query()->avg('grand_total');

        return [
            Stat::make('New Orders', Order::query()->where('status', 'new')->count()),

            Stat::make('Order Processing', Order::query()->where('status', 'processing')->count()),

            Stat::make('Order Shipped', Order::query()->where('status', 'shipped')->count()),

            Stat::make('Average Price', $averagePrice ? 'KES ' . number_format($averagePrice, 2) : 'KES 0.00'),
        ];
    }
}
