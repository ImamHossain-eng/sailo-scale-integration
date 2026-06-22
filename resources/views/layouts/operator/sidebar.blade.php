<div class="sidebar bg-dark text-white" style="width: 250px; min-height: 100vh;">
    <div class="p-3">
        <h5 class="text-white mb-3">Navigation</h5>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('operator.dashboard') ? 'active' : '' }}" 
                   href="{{ route('operator.dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('operator.scale.*') ? 'active' : '' }}" 
                   href="#weight-scale">
                    <i class="bi bi-weight me-2"></i> Weight Scale
                </a>
            </li>
        </ul>
    </div>
</div>