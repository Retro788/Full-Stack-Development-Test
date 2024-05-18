<?php

namespace App\Http\Controllers\Api;

use App\Enums\CustomerStatus;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Traits\ReportTrait;

class DashboardController extends Controller
{
    use ReportTrait;

    public function activeCustomers()
    {
        return Customer::where('status', CustomerStatus::Active->value)->count();
    }

    public function latestCustomers()
    {
        return Customer::query()
            ->select(['id', 'first_name', 'last_name', 'u.email', 'phone', 'u.created_at'])
            ->join('users AS u', 'u.id', '=', 'customers.user_id')
            ->where('status', CustomerStatus::Active->value)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    
}