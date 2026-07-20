<x-layouts.app>
    <section class="view view-detail">
        <a href="{{ url('/') }}" class="btn btn-ghost back-btn" id="backToLive">
            <i class="ph ph-arrow-left"></i>
            <span>Kembali ke Layar Langsung</span>
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
                        <span>Tangkapan Layar</span>
                    </button>
                    <button class="btn btn-outline btn-sm" id="btn-fullscreen">
                        <i class="ph ph-arrows-out"></i>
                        <span>Layar Penuh</span>
                    </button>
                </div>

                <!-- Location Map Card -->
                <div class="detail-card" style="margin-top: 20px;">
                    <h3 class="detail-card-title">
                        <i class="ph ph-map-pin"></i>
                        Peta Lokasi (<span class="location-city-name">{{ $data['city'] ?? 'Unknown' }}</span>)
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
                                Data Lokasi Tidak Tersedia</div>
                        @endif
                    </div>
                </div>

                <!-- Live Activity Timeline Card -->
                <div class="detail-card" style="margin-top: 20px;">
                    <h3 class="detail-card-title">
                        <i class="ph ph-list-dashes"></i>
                        Lini Masa Aktivitas Langsung
                    </h3>
                    <div class="detail-card-grid activity-timeline" style="max-height: 250px; overflow-y: auto;">
                        <div class="detail-info-row">
                            <span class="detail-info-label" style="display:flex; align-items:center; gap:8px;">
                                <i class="ph ph-clock" style="color:var(--gray-600);"></i>
                                Menunggu aktivitas...
                            </span>
                        </div>
                    </div>
                <!-- Historical Screenshots -->
                <div class="detail-card" style="margin-top: 20px;">
                    <h3 class="detail-card-title">
                        <i class="ph ph-images"></i>
                        Riwayat Tangkapan Layar
                    </h3>
                    <div style="display:flex; overflow-x:auto; gap:10px; padding:10px 0;">
                        @forelse($screenshots ?? [] as $shot)
                            @php
                                $disk = env('FILESYSTEM_DISK', 'public');
                                $imgUrl = \Illuminate\Support\Facades\Storage::disk($disk)->url($shot->file_path);
                            @endphp
                            <div style="min-width: 150px; border:1px solid var(--gray-700); border-radius:8px; overflow:hidden;">
                                <a href="{{ $imgUrl }}" target="_blank">
                                    <img src="{{ $imgUrl }}" style="width:100%; height:90px; object-fit:cover;" alt="Screenshot">
                                </a>
                                <div style="padding:5px; font-size:0.7rem; color:var(--gray-400); background:var(--gray-800);">
                                    {{ $shot->captured_at->format('H:i') }}<br>
                                    <span style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; display:block;" title="{{ $shot->active_window }}">
                                        {{ $shot->active_window ?? 'Unknown' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p style="color:var(--gray-500); font-size:0.8rem;">Belum ada riwayat tangkapan layar.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Security Alerts -->
                <div class="detail-card" style="margin-top: 20px;">
                    <h3 class="detail-card-title" style="color: #ef4444;">
                        <i class="ph ph-shield-warning"></i>
                        Peringatan Keamanan & USB
                    </h3>
                    <div class="detail-card-grid" style="max-height: 200px; overflow-y: auto;">
                        @forelse($alerts ?? [] as $alert)
                            <div class="detail-info-row">
                                <span class="detail-info-label" style="display:flex; align-items:center; gap:8px;">
                                    @if(str_contains($alert->type, 'inserted'))
                                        <i class="ph ph-usb" style="color:#ef4444;"></i>
                                    @else
                                        <i class="ph ph-usb" style="color:#10b981;"></i>
                                    @endif
                                    {{ $alert->description }}
                                </span>
                                <span class="detail-info-value" style="font-size:0.75rem;">{{ $alert->logged_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <p style="color:var(--gray-500); font-size:0.8rem; padding: 10px;">Tidak ada peringatan.</p>
                        @endforelse
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
                        Info Perangkat & Perangkat Keras
                    </h3>
                    <div class="detail-card-grid">
                        <div class="detail-info-row">
                            <span class="detail-info-label">Sistem Operasi</span>
                            <span class="detail-info-value">{{ $data['device'] ?? 'Windows' }}</span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">Prosesor (CPU)</span>
                            <span class="detail-info-value cpu-name-value">{{ $data['cpu_name'] ?? 'Unknown' }}</span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">Total Memori (RAM)</span>
                            <span class="detail-info-value total-ram-value">{{ $data['total_ram'] ?? 'Unknown' }}</span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">Waktu Aktif Sistem</span>
                            <span class="detail-info-value uptime-value">{{ isset($data['uptime']) ? gmdate("H:i:s", $data['uptime']) : '00:00:00' }}</span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">Alamat IP</span>
                            <span class="detail-info-value ip-value">{{ $data['ip'] ?? '127.0.0.1' }}</span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">Jaringan</span>
                            <span class="detail-info-value ssid-value">{{ $data['ssid'] ?? 'Unknown' }}</span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">Baterai</span>
                            <span class="detail-info-value battery-value">
                                @if (isset($data['battery_percent']))
                                    {{ $data['battery_percent'] }}%
                                    ({{ $data['battery_plugged'] ? 'Mengisi Daya' : 'Pada Baterai' }})
                                @else
                                    N/A (Desktop)
                                @endif
                            </span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">Waktu Menganggur</span>
                            <span
                                class="detail-info-value idle-value">{{ isset($data['idle_time']) ? gmdate('H:i:s', $data['idle_time']) : '00:00:00' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Top Apps Duration Card -->
                <div class="detail-card">
                    <h3 class="detail-card-title">
                        <i class="ph ph-clock"></i>
                        Aplikasi Teratas (Durasi)
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
                        Performa
                    </h3>
                    <div class="detail-card-grid">
                        <div class="detail-info-row">
                            <span class="detail-info-label">Penggunaan CPU</span>
                            <span class="detail-info-value cpu-value">{{ $data['cpu'] ?? 0 }}%</span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">Penggunaan RAM</span>
                            <span class="detail-info-value ram-value">{{ $data['ram'] ?? 0 }}%</span>
                        </div>
                        <div class="detail-info-row">
                            <span class="detail-info-label">Penyimpanan</span>
                            <span class="detail-info-value storage-value">{{ $data['storage'] ?? 0 }}%</span>
                        </div>
                    </div>
                </div>

                <!-- Network Traffic Card -->
                <div class="detail-card">
                    <h3 class="detail-card-title">
                        <i class="ph ph-wifi-high"></i>
                        Lalu Lintas Jaringan (KB/s)
                    </h3>
                    <div style="width: 100%; height: 200px; margin-top: 10px;">
                        <canvas id="networkChart"></canvas>
                    </div>
                </div>

                <!-- Current Activity Card -->
                <div class="detail-card">
                    <h3 class="detail-card-title">
                        <i class="ph ph-app-window"></i>
                        Aktivitas Saat Ini
                    </h3>
                    <div class="detail-card-grid">
                        <div class="detail-info-row">
                            <span class="detail-info-label">Jendela Aktif</span>
                            <span class="detail-info-value window-value">{{ $data['window'] ?? 'Unknown' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Open Apps Card -->
                <div class="detail-card">
                    <h3 class="detail-card-title">
                        <i class="ph ph-squares-four"></i>
                        Aplikasi Terbuka di Taskbar
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
