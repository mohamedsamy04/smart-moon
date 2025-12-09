<?php

namespace App\Repositories\Eloquents;

use Carbon\Carbon;
use App\Models\Guest;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Interfaces\DashboardRepositoryInterface;

class DashboardRepository implements DashboardRepositoryInterface
{
    protected function getDateRange(string $period): array
    {
        $today = Carbon::today();

        return match($period) {
            'daily' => [$today->copy()->startOfDay(), $today->copy()->endOfDay()],
            'monthly' => [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()],
            'yearly' => [$today->copy()->startOfYear(), $today->copy()->endOfYear()],
            default => [$today->copy()->startOfDay(), $today->copy()->endOfDay()],
        };
    }

    public function totalVisitors(string $period = 'daily'): int
    {
        [$start, $end] = $this->getDateRange($period);
        return Guest::whereBetween('created_at', [$start, $end])->count();
    }

    public function totalOrdersCount(string $period = 'daily'): int
    {
        [$start, $end] = $this->getDateRange($period);
        return Order::whereBetween('created_at', [$start, $end])->count();
    }

    public function totalOrdersRevenue(string $period = 'daily'): float
    {
        [$start, $end] = $this->getDateRange($period);
        return (float) Order::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->sum('total_price');
    }

    public function totalProductCount(): int
    {
        return Product::count();
    }
}
