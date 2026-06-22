@extends('layouts.super-admin.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Super Admin Dashboard</h2>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-people me-2"></i>Total Users</h5>
                    <p class="card-text display-4">{{ $usersCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-person-badge me-2"></i>Admins</h5>
                    <p class="card-text display-4">{{ $adminsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-person-gear me-2"></i>Operators</h5>
                    <p class="card-text display-4">{{ $operatorsCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('super-admin.users.create') }}" class="btn btn-primary mb-2"><i class="bi bi-person-plus me-1"></i> Add New User</a>
                    <a href="{{ route('super-admin.roles.create') }}" class="btn btn-outline-primary"><i class="bi bi-shield-plus me-1"></i> Add New Role</a>
                </div>
            </div>
        </div>
    </div>
@endsection