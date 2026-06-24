<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Weighing;
use App\Models\Vessel;
use App\Models\CompanySetting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Compute Weighbridge operational statistics
        $totalTickets = Weighing::count();
        $pendingTickets = Weighing::pending()->count();
        $completedTickets = Weighing::completed()->count();
        
        // Net weight in metric tons (sum of net_weight in kg / 1000)
        $totalTonnage = Weighing::completed()->sum('net_weight') / 1000;

        return view('admin.dashboard', compact(
            'totalTickets',
            'pendingTickets',
            'completedTickets',
            'totalTonnage'
        ));
    }

    public function printVessel(Vessel $vessel)
    {
        // Load company settings
        $company = CompanySetting::first() ?? new CompanySetting([
            'company_name' => 'SAILOGHAT DIGITAL SCALE',
            'company_address' => 'Sailoghat, Bangladesh',
            'company_phone' => '01700000000',
        ]);

        return view('admin.vessels.print', compact('vessel', 'company'));
    }
}