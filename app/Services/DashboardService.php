<?php

namespace App\Services;

use App\Actions\DashBoard\GetDashboardStatsAction;

class DashboardService
{

    public function __construct(
        protected GetDashboardStatsAction $getDashboardStatsAction
    ) {}

    public function getStats(): array
    {
        return $this->getDashboardStatsAction->execute();
    }
}
