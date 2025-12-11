<?php

namespace App\Actions\DashBoard;

use App\Repositories\Interfaces\DashboardRepositoryInterface;

class GetDashboardStatsAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected DashboardRepositoryInterface $repo
    ) {
    }

      public function execute(): array
    {
        return [
            'overall' => [
                'total_visitors' => $this->repo->totalVisitorsAllTime(),
                'total_orders' => $this->repo->totalOrdersCountAllTime(),
                'total_revenue' => $this->repo->totalOrdersRevenueAllTime(),
                'total_products' => $this->repo->totalProductCountAllTime(),
            ],
            'daily' => [
                'visitors' => $this->repo->totalVisitors('daily'),
                'orders_count' => $this->repo->totalOrdersCount('daily'),
                'revenue' => $this->repo->totalOrdersRevenue('daily'),
            ],
            'monthly' => [
                'visitors' => $this->repo->totalVisitors('monthly'),
                'orders_count' => $this->repo->totalOrdersCount('monthly'),
                'revenue' => $this->repo->totalOrdersRevenue('monthly'),
            ],
            'yearly' => [
                'visitors' => $this->repo->totalVisitors('yearly'),
                'orders_count' => $this->repo->totalOrdersCount('yearly'),
                'revenue' => $this->repo->totalOrdersRevenue('yearly'),
            ],
        ];
    }
}
