<div class="sidebar bg-dark text-white" style="width: 250px; min-height: 100vh;">
    <div class="p-3">
        <h5 class="text-white mb-3">Navigation</h5>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('super-admin.dashboard') ? 'active' : '' }}" 
                   href="{{ route('super-admin.dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('super-admin.users.*') ? 'active' : '' }}" 
                   href="{{ route('super-admin.users.index') }}">
                    <i class="bi bi-people me-2"></i> Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('super-admin.roles.*') ? 'active' : '' }}" 
                   href="{{ route('super-admin.roles.index') }}">
                    <i class="bi bi-shield-check me-2"></i> Roles
                </a>
            </li>
        </ul>
    </div>
</div>