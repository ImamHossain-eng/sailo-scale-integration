@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-dark fw-bold">Admin Control Panel</h2>
        <span class="text-muted fw-semibold">Sailo Weighbridge Management</span>
    </div>
    
    <!-- Operational Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-primary text-white h-100">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-white-50 text-uppercase fw-bold fs-7 mb-1">Total Transactions</h6>
                            <span class="fs-2 fw-bold">{{ $totalTickets }}</span>
                        </div>
                        <i class="bi bi-file-earmark-text fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-warning text-dark h-100">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-dark-50 text-uppercase fw-bold fs-7 mb-1">Vehicles in Yard</h6>
                            <span class="fs-2 fw-bold">{{ $pendingTickets }}</span>
                        </div>
                        <i class="bi bi-truck fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-success text-white h-100">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-white-50 text-uppercase fw-bold fs-7 mb-1">Completed Slips</h6>
                            <span class="fs-2 fw-bold">{{ $completedTickets }}</span>
                        </div>
                        <i class="bi bi-check2-circle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-danger text-white h-100">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-white-50 text-uppercase fw-bold fs-7 mb-1">Tonnage Processed</h6>
                            <span class="fs-2 fw-bold">{{ number_format($totalTonnage, 2) }} <span class="fs-5">MT</span></span>
                        </div>
                        <i class="bi bi-activity fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Livewire Weighing History -->
    <div class="row">
        <div class="col-md-12">
            <livewire:admin.weighing-history />
        </div>
    </div>
</div>
@endsection