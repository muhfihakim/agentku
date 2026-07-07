<x-layouts.app>
    <section class="view view-detail">
        <a href="{{ url('/') }}" class="btn btn-ghost back-btn" id="backToLive">
            <i class="ph ph-arrow-left"></i>
            <span>Back to Live Screens</span>
        </a>

        <div class="detail-layout">
            <!-- Left: Screen Viewer -->
            <div class="detail-screen">
                <div class="detail-screen-viewer"
                    style="background: var(--gray-900) url('{{ $data['screen'] }}') center/cover no-repeat; position: relative; overflow: hidden;">
                    <div class="detail-screen-live-badge">
                        <span class="live-dot"></span>
                        LIVE
                    </div>
                </div>
                <div class="detail-screen-toolbar">
                    <button class="btn btn-outline btn-sm" id="btn-screenshot">
                        <i class="ph ph-camera"></i>
                        <span>Screenshot</span>
                    </button>
                    <button class="btn btn-outline btn-sm" id="btn-fullscreen">
                        <i class="ph ph-arrows-out"></i>
                        <span>Full Screen</span>
                    </button>
                </div>

                <!-- Location Map Card -->
                <div class="detail-card" style="margin-top: 20px;">
                    <h3 class="detail-card-title">
                        <i class="ph ph-map-pin"></i>
                        Location Map (<span class="location-city-name">{{ $data['city'] ?? 'Unknown' }}</span>)
                    </h3>
                    <div class="map-container"
                        style="width: 100%; height: 300px; border-radius: 8px; overflow: hidden; background:var(--gray-800);">
                        @if (isset($data['lat']) && isset($data['lng']))
                            <iframe id="mapFrame" width="100%" height="100%" frameborder="0" scrolling="no"
                                marginheight="0" marginwidth="0"
                                src="https://www.openstreetmap.org/export/embed.html?bbox={{ $data['lng'] - 0.01 }}%2C{{ $data['lat'] - 0.01 }}%2C{{ $data['lng'] + 0.01 }}%2C{{ $data['lat'] + 0.01 }}&amp;layer=mapnik&amp;marker={{ $data['lat'] }}%2C{{ $data['lng'] }}"></iframe>
                        @else
                            <div id="mapFramePlaceholder"
                                style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:var(--gray-400);">
                                Location Data Unavailable</div>
                        @endif
                    </div>
                </div>

                <!-- Live Activity Timeline Card -->
                <div class="detail-card" style="margin-top: 20px;">
                    <h3 class="detail-card-title">
                        <i class="ph ph-list-dashes"></i>
                        Live Activity Timeline
                    </h3>
                    <div class="activity-timeline" style="max-height: 250px; overflow-y: auto; padding-right: 5px; margin-top: 10px;">
                        <!-- Javascript will populate this -->
                        <div style="color:var(--gray-500); text-align:center; padding: 20px 0;">Waiting for activity...</div>
                    </div>
                </div>
            </div>

            <!-- Right: Detail Info -->
            <div class="detail-info">
                <!-- Employee Header -->
                <div class="detail-employee-header">
                    <div class="detail-employee-avatar" style="background: #6366f1;">
                        {{ strtoupper(substr($data['user'], 0, 2)) }}</div>
                    <div class="detail-employee-meta">
                        <h2 class="detail-employee-name">{{ $data['user'] }}</h2>
                        <p class="detail-employee-dept">Agent</p>
                    </div>
                    <span class="badge badge-{{ $data['status'] }}">{{ ucfirst($data['status']) }}</span>
                </div>

                <!-- Device Info Card -->
                <div class="detail-card">
                    <h3 class="detail-card-title">
                        <i class="ph ph-desktop"></i>
                        Device & Hardware Info
                    </h3>
                    <div class="detail-card-grid">
                        <div class="detail-info-row">
                            <span class="detail-info-label">Operating System</span>
                            <span class="detail-info-value">{{ $data['device'] ?? 'Windows' }}</span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">Processor (CPU)</span>
                            <span class="detail-info-value cpu-name-value">{{ $data['cpu_name'] ?? 'Unknown' }}</span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">Total Memory (RAM)</span>
                            <span class="detail-info-value total-ram-value">{{ $data['total_ram'] ?? 'Unknown' }}</span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">System Uptime</span>
                            <span class="detail-info-value uptime-value">{{ isset($data['uptime']) ? gmdate("H:i:s", $data['uptime']) : '00:00:00' }}</span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">IP Address</span>
                            <span class="detail-info-value ip-value">{{ $data['ip'] ?? '127.0.0.1' }}</span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">Network</span>
                            <span class="detail-info-value ssid-value">{{ $data['ssid'] ?? 'Unknown' }}</span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">Battery</span>
                            <span class="detail-info-value battery-value">
                                @if (isset($data['battery_percent']))
                                    {{ $data['battery_percent'] }}%
                                    ({{ $data['battery_plugged'] ? 'Charging' : 'On Battery' }})
                                @else
                                    N/A (Desktop)
                                @endif
                            </span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">Idle Time</span>
                            <span
                                class="detail-info-value idle-value">{{ isset($data['idle_time']) ? gmdate('H:i:s', $data['idle_time']) : '00:00:00' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Top Apps Duration Card -->
                <div class="detail-card">
                    <h3 class="detail-card-title">
                        <i class="ph ph-clock"></i>
                        Top Apps (Duration)
                    </h3>
                    <div class="detail-card-grid top-apps-list">
                        @foreach ($data['top_apps'] ?? [] as $app)
                            <div class="detail-info-row">
                                <span class="detail-info-label"><i class="ph ph-app-window"></i>
                                    {{ $app['name'] }}</span>
                                <span class="detail-info-value">{{ gmdate('H:i:s', $app['duration']) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Performance Card -->
                <div class="detail-card">
                    <h3 class="detail-card-title">
                        <i class="ph ph-cpu"></i>
                        Performance
                    </h3>
                    <div class="detail-card-grid">
                        <div class="detail-info-row">
                            <span class="detail-info-label">CPU Usage</span>
                            <span class="detail-info-value cpu-value">{{ $data['cpu'] ?? 0 }}%</span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">RAM Usage</span>
                            <span class="detail-info-value ram-value">{{ $data['ram'] ?? 0 }}%</span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">Storage</span>
                            <span class="detail-info-value storage-value">{{ $data['storage'] ?? 0 }}%</span>
                        </div>
                    </div>
                </div>

                <!-- Network Traffic Card -->
                <div class="detail-card">
                    <h3 class="detail-card-title">
                        <i class="ph ph-wifi-high"></i>
                        Network Traffic (KB/s)
                    </h3>
                    <div style="width: 100%; height: 200px; margin-top: 10px;">
                        <canvas id="networkChart"></canvas>
                    </div>
                </div>

                <!-- Current Activity Card -->
                <div class="detail-card">
                    <h3 class="detail-card-title">
                        <i class="ph ph-app-window"></i>
                        Current Activity
                    </h3>
                    <div class="detail-card-grid">
                        <div class="detail-info-row">
                            <span class="detail-info-label">Active Window</span>
                            <span class="detail-info-value window-value">{{ $data['window'] ?? 'Unknown' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Open Apps Card -->
                <div class="detail-card">
                    <h3 class="detail-card-title">
                        <i class="ph ph-squares-four"></i>
                        Open Apps in Taskbar
                    </h3>
                    <div class="detail-card-grid apps-list">
                        @foreach ($data['apps'] ?? [] as $app)
                            <div class="detail-info-row">
                                <span class="detail-info-label" style="display:flex; align-items:center; gap:8px;">
                                    <i class="ph ph-app-window" style="color:var(--primary);"></i>
                                    {{ $app }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>


</x-layouts.app>
