<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Transport;
use App\Models\WorkGroup;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'transports' => Transport::count(),
            'departments' => Department::count(),
            'work_groups' => WorkGroup::count(),
            'employees' => [
                'count' => Employee::count(),
                'change' => Employee::whereDate('created_at', '>=', now()->subDays(7))
                    ->count(),
            ],
        ];

        return view('dashboards.index', compact('stats'));
    }
}
