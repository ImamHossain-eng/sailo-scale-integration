@extends('layouts.operator.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Operator Dashboard</h2>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="bi bi-weight me-2"></i>XK3190-D10 Weight Scale</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="display-1 text-center my-4" id="weight-display">0.000 kg</h3>
                            <p class="text-center text-muted">Live Weight Reading</p>
                            <button class="btn btn-primary w-100" id="connect-device">Connect to Device</button>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <h6>Device Status</h6>
                                <p>Status: <span id="device-status" class="badge bg-secondary">Disconnected</span></p>
                                <p>Port: COM1 (XK3190-D10)</p>
                            </div>
                            <div class="mt-3">
                                <h6>Recent Readings</h6>
                                <ul class="list-group" id="readings-list">
                                    <li class="list-group-item text-muted">No readings yet</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('connect-device').addEventListener('click', function() {
        const status = document.getElementById('device-status');
        status.textContent = 'Connected';
        status.className = 'badge bg-success';
        this.disabled = true;
        this.textContent = 'Device Connected';
    });
</script>
@endpush