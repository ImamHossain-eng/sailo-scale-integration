<div class="sidebar bg-dark text-white" style="width: 250px; min-height: 100vh;">
    <div class="p-3">
        <h5 class="text-white mb-3">Navigation</h5>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                   href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.vessels.*') ? 'active' : '' }}" 
                   href="{{ route('admin.vessels.index') }}">
                    <i class="bi bi-ship me-2"></i> Vessel Billing
                </a>
            </li>
        </ul>
    </div>
</div>