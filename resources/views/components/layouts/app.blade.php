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
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <div class="sidebar-nav-section">
                <span class="sidebar-nav-label">MAIN</span>
                <a href="#" class="sidebar-nav-item" data-view="dashboard">
                    <i class="ph ph-squares-four"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="sidebar-nav-item active" data-view="live">
                    <i class="ph ph-monitor"></i>
                    <span>Live Screens</span>
                </a>
            </div>

            <div class="sidebar-nav-section">
                <span class="sidebar-nav-label">MANAGEMENT</span>
                <a href="#" class="sidebar-nav-item" data-view="employees">
                    <i class="ph ph-users"></i>
                    <span>Employees</span>
                </a>
                <a href="#" class="sidebar-nav-item" data-view="departments">
                    <i class="ph ph-buildings"></i>
                    <span>Departments</span>
                </a>
            </div>

            <div class="sidebar-nav-section">
                <span class="sidebar-nav-label">SYSTEM</span>
                <a href="#" class="sidebar-nav-item" data-view="reports">
                    <i class="ph ph-chart-bar"></i>
                    <span>Reports</span>
                </a>
                <a href="#" class="sidebar-nav-item" data-view="settings">
                    <i class="ph ph-gear"></i>
                    <span>Settings</span>
                </a>
            </div>
        </nav>

        <div class="sidebar-bottom">
            <a href="#" class="sidebar-nav-item sidebar-signout">
                <i class="ph ph-sign-out"></i>
                <span>Sign Out</span>
            </a>
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

            <div class="topbar-right">
                <div class="topbar-status-badge connected">
                    <span class="status-dot green"></span>
                    <span>WebSocket: Connected</span>
                </div>
                <div class="topbar-status-badge agents">
                    <span>Agents: 24/30 Online</span>
                </div>
                <button class="topbar-notification" aria-label="Notifications">
                    <i class="ph ph-bell"></i>
                    <span class="notification-count">3</span>
                </button>
                <div class="topbar-divider"></div>
                <div class="topbar-admin">
                    <div class="topbar-avatar">BS</div>
                    <div class="topbar-admin-info">
                        <span class="topbar-admin-name">Admin Boss</span>
                        <span class="topbar-admin-role">Super Admin</span>
                    </div>
                    <i class="ph ph-caret-down"></i>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content">
            {{ $slot }}
        </main>
    </div>

    <script src="{{ asset('app.js') }}?v={{ time() + 10 }}"></script>
</body>

</html>
