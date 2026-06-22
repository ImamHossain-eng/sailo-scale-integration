<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $adminsCount = User::whereHas('role', fn($q) => $q->where('name', 'admin'))->count();
        $operatorsCount = User::whereHas('role', fn($q) => $q->where('name', 'operator'))->count();

        return view('super-admin.dashboard', compact('usersCount', 'adminsCount', 'operatorsCount'));
    }
}