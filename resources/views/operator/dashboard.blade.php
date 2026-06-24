@extends('layouts.operator.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-dark fw-bold">Weight Scale Operator Console</h2>
        <span class="text-muted fw-semibold">Location: Main Weighbridge Desk</span>
    </div>
    
    <livewire:operator.weight-scale />
</div>
@endsection