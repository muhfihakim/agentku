<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgentKu - Employee Screen Monitor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ global_asset('style.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('styles')
    <style>
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeOutToast {
            from { opacity: 1; }
            to { opacity: 0; display: none; }
        }
        .toast-item {
            animation: slideInRight 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards, fadeOutToast 0.3s ease-in-out forwards 4.7s;
        }
        
        .profile-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            width: 200px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 50;
            overflow: hidden;
        }
        .profile-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .dropdown-header {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #4b5563;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .dropdown-item:hover {
            background: #f9fafb;
            color: #ef4444;
        }
        .dropdown-item i {
            font-size: 1.25rem;
        }
    </style>
</head>

<body>

    <!-- Sidebar Overlay (mobile backdrop) -->
    <div class="sidebar-overlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <i class="ph ph-monitor"></i>
            </div>
            <div class="sidebar-logo-text">
                <span class="sidebar-logo-title">AgentKu</span>
                <span class="sidebar-logo-subtitle">Monitor</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            @if(auth()->check() && auth()->user()->hasRole('Owner'))
            <div class="sidebar-nav-section">
                <span class="sidebar-nav-label">SAAS MANAGEMENT</span>
                <a href="{{ route('owner.dashboard') }}" class="sidebar-nav-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                    <i class="ph ph-buildings"></i>
                    <span>Daftar Client</span>
                </a>
                <a href="{{ route('owner.billing') }}" class="sidebar-nav-item {{ request()->routeIs('owner.billing') ? 'active' : '' }}">
                    <i class="ph ph-currency-circle-dollar"></i>
                    <span>Billing & Paket</span>
                </a>
                <a href="{{ route('owner.settings') }}" class="sidebar-nav-item {{ request()->routeIs('owner.settings') ? 'active' : '' }}">
                    <i class="ph ph-gear"></i>
                    <span>Pengaturan Global</span>
                </a>
            </div>
            @else
            <div class="sidebar-nav-section">
                <span class="sidebar-nav-label">MAIN</span>
                <a href="{{ route('dashboard') }}" class="sidebar-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="ph ph-squares-four"></i>
                    <span>Dasbor</span>
                </a>
                <a href="{{ route('client.live') }}" class="sidebar-nav-item {{ request()->routeIs('client.live') ? 'active' : '' }}">
                    <i class="ph ph-monitor"></i>
                    <span>Layar Langsung</span>
                </a>
            </div>

            <div class="sidebar-nav-section">
                <span class="sidebar-nav-label">MANAGEMENT</span>
                <a href="{{ route('client.employees.index') }}" class="sidebar-nav-item {{ request()->routeIs('client.employees.index') ? 'active' : '' }}">
                    <i class="ph ph-users"></i>
                    <span>Karyawan</span>
                </a>
                <a href="{{ route('client.departments.index') }}" class="sidebar-nav-item {{ request()->routeIs('client.departments.index') ? 'active' : '' }}">
                    <i class="ph ph-buildings"></i>
                    <span>Departemen</span>
                </a>
            </div>

            <div class="sidebar-nav-section">
                <span class="sidebar-nav-label">SYSTEM</span>
                <a href="{{ route('client.reports.index') }}" class="sidebar-nav-item {{ request()->routeIs('client.reports.index') ? 'active' : '' }}">
                    <i class="ph ph-chart-bar"></i>
                    <span>Laporan</span>
                </a>
                <a href="{{ route('client.settings.index') }}" class="sidebar-nav-item {{ request()->routeIs('client.settings.index') ? 'active' : '' }}">
                    <i class="ph ph-gear"></i>
                    <span>Pengaturan</span>
                </a>
            </div>
            @endif
        </nav>

        <div class="sidebar-bottom">
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a href="#" onclick="document.getElementById('logout-form').submit();" class="sidebar-nav-item sidebar-signout">
                    <i class="ph ph-sign-out"></i>
                    <span>Keluar</span>
                </a>
            </form>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle" aria-label="Toggle sidebar">
                    <i class="ph ph-sidebar-simple"></i>
                </button>
                <div class="topbar-search">
                    <i class="ph ph-magnifying-glass"></i>
                    <input type="text" placeholder="Search employees, departments...">
                </div>
            </div>

            @php
                $totalAgents = 0;
                $onlineAgents = 0;
                
                if (function_exists('tenant') && tenant()) {
                    try {
                        $totalAgents = \App\Models\Employee::count();
                        $onlineAgents = \App\Models\Employee::whereIn('status', ['online', 'active'])->count();
                    } catch(\Exception $e) {}
                } elseif (auth()->check() && auth()->user()->hasRole('Owner')) {
                    $tenants = \App\Models\Tenant::all();
                    foreach($tenants as $t) {
                        $t->run(function () use (&$totalAgents, &$onlineAgents) {
                            try {
                                $totalAgents += \App\Models\Employee::count();
                                $onlineAgents += \App\Models\Employee::whereIn('status', ['online', 'active'])->count();
                            } catch(\Exception $e) {}
                        });
                    }
                }
            @endphp

            <div class="topbar-right">
                <div class="topbar-status-badge disconnected" id="wsConnectionBadge">
                    <span class="status-dot red"></span>
                    <span>Server: Disconnected</span>
                </div>
                <div class="topbar-status-badge agents">
                    <span>Agents: {{ $onlineAgents }}/{{ $totalAgents }} Online</span>
                </div>
                <button class="topbar-notification" aria-label="Notifications">
                    <i class="ph ph-bell"></i>
                    <span class="notification-count">3</span>
                </button>
                <div class="topbar-divider"></div>
                <div class="topbar-admin" style="position: relative; cursor: pointer;" onclick="document.getElementById('profileDropdown').classList.toggle('active')">
                    <div class="topbar-avatar">{{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'US' }}</div>
                    <div class="topbar-admin-info">
                        <span class="topbar-admin-name">{{ auth()->check() ? auth()->user()->name : 'Guest' }}</span>
                        <span class="topbar-admin-role">{{ auth()->check() && auth()->user()->hasRole('Owner') ? 'SaaS Owner' : 'Tenant Admin' }}</span>
                    </div>
                    <i class="ph ph-caret-down"></i>
                    
                    <!-- Dropdown -->
                    <div id="profileDropdown" class="profile-dropdown">
                        <div class="dropdown-header">
                            <span style="display: block; font-weight: 600; color: #111827;">{{ auth()->check() ? auth()->user()->name : 'Guest' }}</span>
                            <span style="display: block; font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">{{ auth()->check() ? auth()->user()->email : '' }}</span>
                        </div>
                        <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ph ph-sign-out"></i> Keluar
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content">
            {{ $slot }}
        </main>
    </div>

    <!-- Toast Notifications -->
    <div id="toast-container" style="position: fixed; top: 1.5rem; right: 1.5rem; z-index: 9999; display: flex; flex-direction: column; gap: 0.75rem; pointer-events: none;">
        @if (session('success'))
            <div class="toast-item" style="pointer-events: auto; background: white; border-left: 4px solid #10b981; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); padding: 1rem 1.25rem; border-radius: 0.5rem; display: flex; align-items: flex-start; gap: 0.75rem; min-width: 320px; max-width: 400px; transform: translateX(100%); opacity: 0;">
                <i class="ph ph-check-circle" style="color: #10b981; font-size: 1.5rem; margin-top: 0.125rem;"></i>
                <div style="flex: 1;">
                    <h4 style="margin: 0 0 0.25rem 0; font-size: 0.875rem; font-weight: 600; color: #111827;">Berhasil</h4>
                    <p style="margin: 0; font-size: 0.875rem; color: #4b5563;">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" style="background: transparent; border: none; color: #9ca3af; cursor: pointer; padding: 0.25rem; margin-top: -0.25rem; margin-right: -0.5rem; transition: color 0.2s;" onmouseover="this.style.color='#4b5563'" onmouseout="this.style.color='#9ca3af'"><i class="ph ph-x" style="font-size: 1.25rem;"></i></button>
            </div>
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="toast-item" style="pointer-events: auto; background: white; border-left: 4px solid #ef4444; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); padding: 1rem 1.25rem; border-radius: 0.5rem; display: flex; align-items: flex-start; gap: 0.75rem; min-width: 320px; max-width: 400px; transform: translateX(100%); opacity: 0;">
                    <i class="ph ph-warning-circle" style="color: #ef4444; font-size: 1.5rem; margin-top: 0.125rem;"></i>
                    <div style="flex: 1;">
                        <h4 style="margin: 0 0 0.25rem 0; font-size: 0.875rem; font-weight: 600; color: #111827;">Kesalahan</h4>
                        <p style="margin: 0; font-size: 0.875rem; color: #4b5563;">{{ $error }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" style="background: transparent; border: none; color: #9ca3af; cursor: pointer; padding: 0.25rem; margin-top: -0.25rem; margin-right: -0.5rem; transition: color 0.2s;" onmouseover="this.style.color='#4b5563'" onmouseout="this.style.color='#9ca3af'"><i class="ph ph-x" style="font-size: 1.25rem;"></i></button>
                </div>
            @endforeach
        @endif
    </div>

    <script src="{{ global_asset('app.js') }}?v={{ time() + 10 }}"></script>
    @stack('scripts')
</body>

</html>
