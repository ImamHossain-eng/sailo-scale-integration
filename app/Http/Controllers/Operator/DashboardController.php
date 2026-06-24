<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Weighing;
use App\Models\CompanySetting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('operator.dashboard');
    }

    public function print(Weighing $weighing)
    {
        // Fetch company settings (defaulting to empty if not seeded yet)
        $company = CompanySetting::first() ?? new CompanySetting([
            'company_name' => 'SAILOGHAT DIGITAL SCALE',
            'company_address' => 'Sailoghat, Bangladesh',
            'company_phone' => '01700000000',
        ]);

        return view('operator.print', compact('weighing', 'company'));
    }
}