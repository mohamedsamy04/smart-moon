<?php

namespace App\Repositories\Interfaces;

interface DashboardRepositoryInterface
{
    public function totalVisitors(string $period = 'daily');
    public function totalOrdersCount(string $period = 'daily');
    public function totalOrdersRevenue(string $period = 'daily');
    public function totalProductCount();
}
