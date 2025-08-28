<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Orders\Widgets\OrderStats;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderStats::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('ALL'),
            'new' => Tab::make()->query(fn ($query) => $query->where('status', 'new')),
            'processing' => Tab::make()->query(fn ($query) => $query->where('status', 'processing')),
            'shipped' => Tab::make()->query(fn ($query) => $query->where('status', 'shipped')),
            'delivered' => Tab::make()->query(fn ($query) => $query->where('status', 'delivered')),
            'cancelled' => Tab::make()->query(fn ($query) => $query->where('status', 'cancelled')),
        ];
    }
}
