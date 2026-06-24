<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Weighing;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $adminsCount = User::whereHas('role', fn($q) => $q->where('name', 'admin'))->count();
        $operatorsCount = User::whereHas('role', fn($q) => $q->where('name', 'operator'))->count();

        // Operational stats
        $totalTickets = Weighing::count();
        $pendingTickets = Weighing::pending()->count();
        $completedTickets = Weighing::completed()->count();
        $totalTonnage = Weighing::completed()->sum('net_weight') / 1000;

        return view('super-admin.dashboard', compact(
            'usersCount', 
            'adminsCount', 
            'operatorsCount',
            'totalTickets',
            'pendingTickets',
            'completedTickets',
            'totalTonnage'
        ));
    }
}