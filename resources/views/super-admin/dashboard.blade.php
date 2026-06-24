@extends('layouts.super-admin.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-dark fw-bold">Super Admin Console</h2>
        <span class="text-muted fw-semibold">Global System Administration</span>
    </div>
    
    <!-- User Management Overview -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card bg-dark text-white shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="text-white-50 text-uppercase fw-bold fs-7 mb-1"><i class="bi bi-people me-2"></i>Total Staff accounts</h6>
                    <p class="card-text display-5 fw-bold mb-0">{{ $usersCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-secondary text-white shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="text-white-50 text-uppercase fw-bold fs-7 mb-1"><i class="bi bi-person-badge me-2"></i>Admins</h6>
                    <p class="card-text display-5 fw-bold mb-0">{{ $adminsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="text-white-50 text-uppercase fw-bold fs-7 mb-1"><i class="bi bi-person-gear me-2"></i>Scale Operators</h6>
                    <p class="card-text display-5 fw-bold mb-0">{{ $operatorsCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Weighbridge Operational Statistics -->
    <h5 class="text-uppercase fw-bold text-secondary mb-3 fs-7">Weighbridge Operations Summary</h5>
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-primary text-white h-100">
                <div class="card-body py-3">
                    <h6 class="text-white-50 text-uppercase fw-bold fs-7 mb-1">Total Weighings</h6>
                    <span class="fs-3 fw-bold">{{ $totalTickets }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-warning text-dark h-100">
                <div class="card-body py-3">
                    <h6 class="text-dark-50 text-uppercase fw-bold fs-7 mb-1">Vehicles in Yard</h6>
                    <span class="fs-3 fw-bold">{{ $pendingTickets }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-success text-white h-100">
                <div class="card-body py-3">
                    <h6 class="text-white-50 text-uppercase fw-bold fs-7 mb-1">Completed Slips</h6>
                    <span class="fs-3 fw-bold">{{ $completedTickets }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-danger text-white h-100">
                <div class="card-body py-3">
                    <h6 class="text-white-50 text-uppercase fw-bold fs-7 mb-1">Tonnage Handled</h6>
                    <span class="fs-3 fw-bold">{{ number_format($totalTonnage, 2) }} MT</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Livewire Weighing History -->
    <div class="row mb-4">
        <div class="col-md-9">
            <livewire:admin.weighing-history />
        </div>
        <div class="col-md-3">
            <!-- Quick Actions -->
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-lightning-fill text-warning me-2"></i>Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('super-admin.users.create') }}" class="btn btn-primary text-start">
                            <i class="bi bi-person-plus-fill me-2"></i> Add New User
                        </a>
                        <a href="{{ route('super-admin.roles.create') }}" class="btn btn-outline-primary text-start">
                            <i class="bi bi-shield-plus me-2"></i> Add New Role
                        </a>
                        <a href="{{ route('super-admin.users.index') }}" class="btn btn-outline-secondary text-start">
                            <i class="bi bi-people-fill me-2"></i> Manage Users
                        </a>
                        <a href="{{ route('super-admin.roles.index') }}" class="btn btn-outline-secondary text-start">
                            <i class="bi bi-shield-lock-fill me-2"></i> Manage Roles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection