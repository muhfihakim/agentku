<x-layouts.app>
@push('styles')
<style>
/* ─── Detail Page Override ─────────────────────────────── */
.view-detail { padding: 0 !important; background: #f0f2f7; min-height: 100vh; }

.detail-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 28px;
    background: #fff;
    border-bottom: 1px solid #e5e7eb;
    gap: 12px;
    flex-wrap: wrap;
}

.detail-topbar-left { display: flex; align-items: center; gap: 14px; }

.detail-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    font-size: 13px;
    font-weight: 500;
    color: #6b7280;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s;
    background: #fff;
}
.detail-back-btn:hover { background: #f9fafb; color: #111827; border-color: #d1d5db; }

.detail-identity { display: flex; align-items: center; gap: 12px; }
.detail-avatar {
    width: 46px; height: 46px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; font-weight: 700; color: #fff;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(99,102,241,0.3);
}
.detail-name { font-size: 16px; font-weight: 700; color: #111827; line-height: 1.2; }
.detail-sub  { font-size: 12px; color: #9ca3af; margin-top: 2px; }

.detail-topbar-right { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.detail-status-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 12px; border-radius: 999px;
    font-size: 12px; font-weight: 600;
}
.detail-status-pill.active  { background: #d1fae5; color: #065f46; }
.detail-status-pill.idle    { background: #fef3c7; color: #92400e; }
.detail-status-pill.offline { background: #fee2e2; color: #991b1b; }
.detail-status-dot { width: 7px; height: 7px; border-radius: 50%; }
.detail-status-pill.active  .detail-status-dot { background: #10b981; }
.detail-status-pill.idle    .detail-status-dot { background: #f59e0b; }
.detail-status-pill.offline .detail-status-dot { background: #ef4444; }

.detail-action-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 8px;
    font-size: 12px; font-weight: 500;
    border: 1px solid #e5e7eb;
    background: #fff; color: #374151;
    cursor: pointer; transition: all 0.2s;
}
.detail-action-btn:hover { background: #f9fafb; border-color: #d1d5db; }
.detail-action-btn.primary {
    background: #6366f1; color: #fff; border-color: #6366f1;
}
.detail-action-btn.primary:hover { background: #4f46e5; border-color: #4f46e5; }

/* ─── Body / Grid ─────────────────────────────────────── */
.detail-body {
    display: grid;
    grid-template-columns: 1fr 360px;
    grid-template-rows: auto;
    gap: 20px;
    padding: 20px 28px 32px;
    align-items: start;
}

/* ─── Screen Viewer Panel ─────────────────────────────── */
.detail-panel-screen {
    grid-column: 1; grid-row: 1;
    display: flex; flex-direction: column; gap: 16px;
}

.detail-screen-card {
    background: #0f172a;
    border-radius: 14px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.detail-screen-img-wrap {
    width: 100%;
    padding-top: 56.25%;
    position: relative;
    background: #0f172a url('{{ $data["screen"] }}') center/cover no-repeat;
}

.detail-live-badge {
    position: absolute;
    top: 14px; left: 14px;
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 10px;
    background: rgba(239,68,68,0.88);
    color: #fff; font-size: 10px; font-weight: 700;
    border-radius: 999px; letter-spacing: 0.6px;
    backdrop-filter: blur(6px);
}
.detail-live-dot { width: 6px; height: 6px; border-radius: 50%; background: #fff; animation: pulse 1.5s infinite; }

.detail-screen-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 14px;
    background: rgba(0,0,0,0.6);
    border-top: 1px solid rgba(255,255,255,0.06);
    gap: 8px;
}
.detail-active-window {
    display: flex; align-items: center; gap: 7px;
    font-size: 12px; color: rgba(255,255,255,0.75);
    overflow: hidden;
    flex: 1;
}
.detail-active-window i { color: #6366f1; flex-shrink: 0; }
.detail-active-window span { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.detail-window-value { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

.screen-toolbar-btns {
    display: flex; gap: 6px; flex-shrink: 0;
}
.screen-toolbar-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 10px; border-radius: 7px;
    font-size: 11px; font-weight: 500;
    border: 1px solid rgba(255,255,255,0.12);
    background: rgba(255,255,255,0.08);
    color: rgba(255,255,255,0.8);
    cursor: pointer; transition: all 0.2s;
}
.screen-toolbar-btn:hover { background: rgba(255,255,255,0.15); }

/* ─── Metrics Row ─────────────────────────────────────── */
.detail-metrics-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}
.detail-metric-card {
    background: #fff;
    border-radius: 12px;
    padding: 16px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    display: flex; flex-direction: column; gap: 8px;
}
.detail-metric-label {
    font-size: 11px; font-weight: 600;
    color: #9ca3af; text-transform: uppercase; letter-spacing: 0.4px;
    display: flex; align-items: center; gap: 5px;
}
.detail-metric-value {
    font-size: 22px; font-weight: 700; color: #111827; line-height: 1;
}
.detail-metric-sub { font-size: 11px; color: #9ca3af; }
.detail-metric-bar {
    width: 100%; height: 4px; background: #f3f4f6; border-radius: 99px; overflow: hidden;
}
.detail-metric-fill {
    height: 100%; border-radius: 99px;
    transition: width 1s cubic-bezier(.4,0,.2,1);
}
.fill-cpu   { background: linear-gradient(90deg, #6366f1, #8b5cf6); }
.fill-ram   { background: linear-gradient(90deg, #f59e0b, #ef4444); }
.fill-disk  { background: linear-gradient(90deg, #10b981, #06b6d4); }

/* Network chart */
.detail-network-card {
    background: #fff; border-radius: 12px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    overflow: hidden;
}
.detail-section-header {
    display: flex; align-items: center; gap: 8px;
    padding: 14px 18px 10px;
    font-size: 13px; font-weight: 600; color: #374151;
    border-bottom: 1px solid #f3f4f6;
}
.detail-section-header i { color: #9ca3af; }
.detail-section-body { padding: 14px 18px; }

/* ─── Right Sidebar ───────────────────────────────────── */
.detail-panel-right {
    grid-column: 2; grid-row: 1;
    display: flex; flex-direction: column; gap: 16px;
}

.detail-info-card {
    background: #fff; border-radius: 12px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    overflow: hidden;
}

.dinfo-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 18px;
    border-bottom: 1px solid #f9fafb;
    font-size: 12.5px; gap: 8px;
}
.dinfo-row:last-child { border-bottom: none; }
.dinfo-label { color: #9ca3af; font-weight: 400; display: flex; align-items: center; gap: 7px; flex-shrink: 0; }
.dinfo-label i { font-size: 14px; color: #d1d5db; }
.dinfo-value { color: #1f2937; font-weight: 500; text-align: right; word-break: break-word; }

/* Apps list */
.detail-app-chip {
    display: flex; align-items: center; gap: 8px;
    padding: 7px 14px;
    border-bottom: 1px solid #f9fafb;
    font-size: 12px; color: #374151;
}
.detail-app-chip:last-child { border-bottom: none; }
.detail-app-icon {
    width: 24px; height: 24px; border-radius: 6px;
    background: #ede9fe; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.detail-app-icon i { font-size: 13px; color: #6366f1; }

/* Top apps duration bar */
.top-app-row {
    padding: 8px 14px;
    border-bottom: 1px solid #f9fafb;
    font-size: 12px;
}
.top-app-row:last-child { border-bottom: none; }
.top-app-name { color: #374151; font-weight: 500; margin-bottom: 5px; display: flex; justify-content: space-between; }
.top-app-dur  { font-size: 11px; color: #9ca3af; }
.top-app-bar  { height: 3px; background: #f3f4f6; border-radius: 99px; margin-top: 4px; }
.top-app-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #6366f1, #8b5cf6); }

/* Alert row */
.detail-alert-row {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 10px 16px; border-bottom: 1px solid #f9fafb; font-size: 12px;
}
.detail-alert-row:last-child { border-bottom: none; }
.detail-alert-icon {
    width: 28px; height: 28px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.alert-inserted { background: #fee2e2; }
.alert-inserted i { color: #ef4444; }
.alert-removed  { background: #d1fae5; }
.alert-removed  i { color: #10b981; }
.detail-alert-text { color: #374151; flex: 1; }
.detail-alert-time { font-size: 11px; color: #9ca3af; white-space: nowrap; }

/* Map */
.detail-map-card {
    background: #fff; border-radius: 12px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    overflow: hidden;
}
.detail-map-card iframe { display: block; }

/* Screenshots */
.screenshots-grid {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;
    padding: 12px 14px;
}
.screenshot-thumb {
    border-radius: 8px; overflow: hidden;
    border: 1px solid #e5e7eb;
    cursor: pointer;
    transition: transform 0.2s;
}
.screenshot-thumb:hover { transform: scale(1.03); }
.screenshot-thumb img { width: 100%; height: 60px; object-fit: cover; display: block; }
.screenshot-time { padding: 3px 6px; font-size: 10px; color: #9ca3af; background: #f9fafb; text-align: center; }

/* ─── Responsive ──────────────────────────────────────── */

/* Tablet: ≤ 1100px → stack columns */
@media (max-width: 1100px) {
    .detail-body {
        grid-template-columns: 1fr;
        padding: 16px 16px 32px;
        gap: 16px;
    }
    .detail-panel-screen { grid-column: 1; grid-row: auto; }
    .detail-panel-right  { grid-column: 1; grid-row: auto; }
    .detail-metrics-row  { grid-template-columns: repeat(3, 1fr); }
}

/* Mobile large: ≤ 768px */
@media (max-width: 768px) {
    /* Topbar: stack left/right */
    .detail-topbar {
        padding: 12px 14px;
        gap: 10px;
    }
    .detail-topbar-left  { gap: 10px; flex: 1; min-width: 0; }
    .detail-topbar-right { gap: 6px; flex-shrink: 0; }
    .detail-identity { min-width: 0; overflow: hidden; }
    .detail-name { font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px; }
    .detail-sub  { display: none; }
    .detail-avatar { width: 38px; height: 38px; font-size: 13px; }

    /* Hide text labels on action buttons, show icon only */
    .detail-action-btn span { display: none; }
    .detail-action-btn { padding: 7px 10px; }

    /* Body */
    .detail-body { padding: 10px 10px 28px; gap: 12px; }

    /* Screen footer wraps nicely */
    .detail-screen-footer { flex-wrap: wrap; gap: 6px; padding: 8px 12px; }
    .detail-active-window { font-size: 11px; max-width: calc(100% - 70px); }
    .screen-toolbar-btns  { gap: 4px; }
    .screen-toolbar-btn   { padding: 4px 8px; font-size: 10px; }

    /* Metrics: 3 columns still, but smaller */
    .detail-metrics-row { grid-template-columns: repeat(3, 1fr); gap: 8px; }
    .detail-metric-card  { padding: 12px 10px; gap: 6px; }
    .detail-metric-value { font-size: 18px; }
    .detail-metric-label { font-size: 10px; }
    .detail-metric-sub   { font-size: 10px; }

    /* Info card rows — allow wrapping */
    .dinfo-row { flex-wrap: nowrap; gap: 4px; padding: 9px 14px; }
    .dinfo-label { font-size: 11.5px; min-width: 100px; }
    .dinfo-value { font-size: 11.5px; text-align: right; flex: 1; }

    /* Section headers */
    .detail-section-header { padding: 12px 14px 8px; font-size: 12px; }
    .detail-section-body   { padding: 10px 12px; }

    /* Map slightly shorter */
    .detail-map-card > div[style*="height:250px"] { height: 200px !important; }

    /* Screenshots 3→2 columns */
    .screenshots-grid { grid-template-columns: repeat(2, 1fr); gap: 6px; padding: 10px 12px; }
    .screenshot-thumb img { height: 55px; }
}

/* Mobile small: ≤ 480px */
@media (max-width: 480px) {
    /* Topbar more compact */
    .detail-topbar { padding: 10px 12px; }
    .detail-back-btn { padding: 6px 10px; font-size: 12px; }
    .detail-back-btn span { display: none; } /* Hide "Kembali" text on very small */
    .detail-name { max-width: 110px; font-size: 13px; }
    .detail-status-pill { padding: 4px 9px; font-size: 11px; }

    /* Body */
    .detail-body { padding: 8px 8px 24px; gap: 10px; }

    /* Metrics: 2 columns for very small screens */
    .detail-metrics-row { grid-template-columns: repeat(2, 1fr); gap: 8px; }
    /* Disk card spans full on 2-col grid at small */
    .detail-metrics-row .detail-metric-card:nth-child(3) {
        grid-column: 1 / -1;
        flex-direction: row; align-items: center; gap: 12px;
        padding: 10px 14px;
    }
    .detail-metrics-row .detail-metric-card:nth-child(3) .detail-metric-bar { flex: 1; margin: 0; }
    .detail-metrics-row .detail-metric-card:nth-child(3) .detail-metric-value { font-size: 18px; }

    /* Network chart smaller */
    .detail-section-body canvas { max-height: 140px; }

    /* Map even shorter */
    .detail-map-card > div[style*="height"] { height: 170px !important; }

    /* Info card tight */
    .dinfo-row { padding: 8px 12px; }
    .dinfo-label { font-size: 11px; min-width: 90px; }
    .dinfo-value { font-size: 11px; }

    /* Top apps */
    .top-app-row { padding: 7px 12px; }
    .top-app-name { font-size: 11.5px; }

    /* Apps chips */
    .detail-app-chip { padding: 6px 12px; font-size: 11.5px; }

    /* Alert rows */
    .detail-alert-row { padding: 8px 12px; gap: 8px; }
    .detail-alert-icon { width: 24px; height: 24px; }

    /* Screenshots 1 column */
    .screenshots-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

@endpush

<section class="view view-detail">

    {{-- ── Top Bar ─────────────────────────────────────── --}}
    <div class="detail-topbar">
        <div class="detail-topbar-left">
            <a href="{{ url('/') }}" class="detail-back-btn" id="backToLive">
                <i class="ph ph-arrow-left"></i>
                Kembali
            </a>
            <div class="detail-identity">
                <div class="detail-avatar">{{ strtoupper(substr($data['user'], 0, 2)) }}</div>
                <div>
                    <div class="detail-employee-name detail-name">{{ $data['user'] }}</div>
                    <div class="detail-sub">{{ $data['device'] ?? 'Agent Device' }}</div>
                </div>
            </div>
        </div>
        <div class="detail-topbar-right">
            @php $st = $data['status'] ?? 'offline'; @endphp
            <span class="detail-status-pill {{ $st }}">
                <span class="detail-status-dot"></span>
                {{ ucfirst($st) }}
            </span>
            <button class="detail-action-btn" id="btn-screenshot">
                <i class="ph ph-camera"></i><span>Screenshot</span>
            </button>
            <button class="detail-action-btn primary" id="btn-fullscreen">
                <i class="ph ph-arrows-out"></i><span>Layar Penuh</span>
            </button>
        </div>
    </div>

    {{-- ── Body Grid ───────────────────────────────────── --}}
    <div class="detail-body">

        {{-- ─── LEFT: Screen + Metrics + Network + Map ─── --}}
        <div class="detail-panel-screen">

            {{-- Screen Viewer --}}
            <div class="detail-screen-card">
                <div class="detail-screen-img-wrap detail-screen-viewer"
                     style="background: #0f172a url('{{ $data["screen"] ?? "" }}') center/cover no-repeat;">
                    <div class="detail-live-badge">
                        <span class="detail-live-dot"></span>
                        LIVE
                    </div>
                </div>
                <div class="detail-screen-footer">
                    <div class="detail-active-window">
                        <i class="ph ph-app-window"></i>
                        <span class="detail-window-value window-value">{{ $data['window'] ?? 'Unknown' }}</span>
                    </div>
                    <div class="screen-toolbar-btns">
                        <button class="screen-toolbar-btn" id="btn-screenshot2">
                            <i class="ph ph-camera"></i>
                        </button>
                        <button class="screen-toolbar-btn" id="btn-fullscreen2">
                            <i class="ph ph-arrows-out"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Metric Cards Row --}}
            <div class="detail-metrics-row">
                <div class="detail-metric-card">
                    <div class="detail-metric-label"><i class="ph ph-cpu"></i> CPU</div>
                    <div class="detail-metric-value cpu-value">{{ $data['cpu'] ?? 0 }}<span style="font-size:13px;color:#9ca3af;">%</span></div>
                    <div class="detail-metric-bar"><div class="detail-metric-fill fill-cpu" data-value="{{ $data['cpu'] ?? 0 }}" style="width:{{ $data['cpu'] ?? 0 }}%"></div></div>
                    <div class="detail-metric-sub cpu-name-value" style="font-size:10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Str::limit($data['cpu_name'] ?? 'Unknown', 28) }}</div>
                </div>
                <div class="detail-metric-card">
                    <div class="detail-metric-label"><i class="ph ph-memory"></i> RAM</div>
                    <div class="detail-metric-value ram-value">{{ $data['ram'] ?? 0 }}<span style="font-size:13px;color:#9ca3af;">%</span></div>
                    <div class="detail-metric-bar"><div class="detail-metric-fill fill-ram" data-value="{{ $data['ram'] ?? 0 }}" style="width:{{ $data['ram'] ?? 0 }}%"></div></div>
                    <div class="detail-metric-sub">{{ $data['total_ram'] ?? 'Unknown' }}</div>
                </div>
                <div class="detail-metric-card">
                    <div class="detail-metric-label"><i class="ph ph-hard-drive"></i> Disk</div>
                    <div class="detail-metric-value storage-value">{{ $data['storage'] ?? 0 }}<span style="font-size:13px;color:#9ca3af;">%</span></div>
                    <div class="detail-metric-bar"><div class="detail-metric-fill fill-disk" data-value="{{ $data['storage'] ?? 0 }}" style="width:{{ $data['storage'] ?? 0 }}%"></div></div>
                    <div class="detail-metric-sub">Storage</div>
                </div>
            </div>

            {{-- Network Chart --}}
            <div class="detail-network-card">
                <div class="detail-section-header">
                    <i class="ph ph-wifi-high"></i>
                    Lalu Lintas Jaringan (KB/s)
                    <span style="margin-left:auto; display:flex; gap:14px; font-size:11px; font-weight:400; color:#9ca3af;">
                        <span>↓ <span id="net-dl">{{ $data['net_download'] ?? 0 }}</span> KB/s</span>
                        <span>↑ <span id="net-ul">{{ $data['net_upload'] ?? 0 }}</span> KB/s</span>
                    </span>
                </div>
                <div class="detail-section-body" style="padding: 14px 16px; height:180px;">
                    <canvas id="networkChart"></canvas>
                </div>
            </div>

            {{-- Location Map --}}
            <div class="detail-map-card">
                <div class="detail-section-header">
                    <i class="ph ph-map-pin"></i>
                    Peta Lokasi &mdash; <span class="location-city-name" style="color:#6366f1; margin-left:4px;">{{ $data['city'] ?? 'Unknown' }}</span>
                </div>
                <div style="height:250px; overflow:hidden;">
                    @if(isset($data['lat']) && isset($data['lng']))
                        <iframe id="mapFrame" width="100%" height="100%" frameborder="0" scrolling="no"
                            src="https://www.openstreetmap.org/export/embed.html?bbox={{ $data['lng']-0.01 }}%2C{{ $data['lat']-0.01 }}%2C{{ $data['lng']+0.01 }}%2C{{ $data['lat']+0.01 }}&layer=mapnik&marker={{ $data['lat'] }}%2C{{ $data['lng'] }}">
                        </iframe>
                    @else
                        <div id="mapFramePlaceholder" style="height:100%; display:flex; flex-direction:column; align-items:center; justify-content:center; color:#9ca3af; gap:8px; background:#f9fafb;">
                            <i class="ph ph-map-trifold" style="font-size:32px; color:#d1d5db;"></i>
                            <span style="font-size:13px;">Data Lokasi Tidak Tersedia</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Historical Screenshots --}}
            @if(!empty($screenshots) && count($screenshots) > 0)
            <div class="detail-info-card">
                <div class="detail-section-header">
                    <i class="ph ph-images"></i>
                    Riwayat Tangkapan Layar
                </div>
                <div class="screenshots-grid">
                    @foreach($screenshots as $shot)
                        @php $imgUrl = \Illuminate\Support\Facades\Storage::disk(env('FILESYSTEM_DISK','public'))->url($shot->file_path); @endphp
                        <a href="{{ $imgUrl }}" target="_blank" class="screenshot-thumb">
                            <img src="{{ $imgUrl }}" alt="Screenshot">
                            <div class="screenshot-time">{{ $shot->captured_at->format('H:i') }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>{{-- End left panel --}}

        {{-- ─── RIGHT: Info + Apps + Alerts + Timeline ─── --}}
        <div class="detail-panel-right">

            {{-- Device Info --}}
            <div class="detail-info-card">
                <div class="detail-section-header">
                    <i class="ph ph-desktop"></i>
                    Info Perangkat
                </div>
                <div>
                    <div class="dinfo-row">
                        <span class="dinfo-label"><i class="ph ph-monitor"></i> Sistem Operasi</span>
                        <span class="dinfo-value">{{ $data['device'] ?? 'Windows' }}</span>
                    </div>
                    <div class="dinfo-row">
                        <span class="dinfo-label"><i class="ph ph-globe"></i> Alamat IP</span>
                        <span class="dinfo-value ip-value">{{ $data['ip'] ?? '127.0.0.1' }}</span>
                    </div>
                    <div class="dinfo-row">
                        <span class="dinfo-label"><i class="ph ph-wifi"></i> Jaringan</span>
                        <span class="dinfo-value ssid-value">{{ $data['ssid'] ?? 'Unknown' }}</span>
                    </div>
                    <div class="dinfo-row">
                        <span class="dinfo-label"><i class="ph ph-battery-charging"></i> Baterai</span>
                        <span class="dinfo-value battery-value">
                            @if(isset($data['battery_percent']))
                                {{ $data['battery_percent'] }}%
                                <span style="font-size:11px; color:#9ca3af;">({{ $data['battery_plugged'] ? 'Charging' : 'On Battery' }})</span>
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="dinfo-row">
                        <span class="dinfo-label"><i class="ph ph-clock-clockwise"></i> Uptime</span>
                        <span class="dinfo-value uptime-value">{{ isset($data['uptime']) ? gmdate('H:i:s', $data['uptime']) : '00:00:00' }}</span>
                    </div>
                    <div class="dinfo-row">
                        <span class="dinfo-label"><i class="ph ph-timer"></i> Idle</span>
                        <span class="dinfo-value idle-value">{{ isset($data['idle_time']) ? gmdate('H:i:s', $data['idle_time']) : '00:00:00' }}</span>
                    </div>
                </div>
            </div>

            {{-- Top Apps Duration --}}
            <div class="detail-info-card">
                <div class="detail-section-header">
                    <i class="ph ph-chart-bar"></i>
                    Aplikasi Terlama
                </div>
                <div class="top-apps-list">
                    @php
                        $topApps = $data['top_apps'] ?? [];
                        $maxDur  = max(array_column($topApps, 'duration') ?: [1]);
                    @endphp
                    @forelse($topApps as $app)
                        <div class="top-app-row">
                            <div class="top-app-name">
                                <span>{{ Str::limit($app['name'], 28) }}</span>
                                <span class="top-app-dur">{{ gmdate('H:i:s', $app['duration']) }}</span>
                            </div>
                            <div class="top-app-bar">
                                <div class="top-app-fill" style="width:{{ $maxDur > 0 ? round(($app['duration']/$maxDur)*100) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div style="padding:16px 14px; font-size:12px; color:#9ca3af;">Belum ada data.</div>
                    @endforelse
                </div>
            </div>

            {{-- Open Apps --}}
            <div class="detail-info-card">
                <div class="detail-section-header">
                    <i class="ph ph-squares-four"></i>
                    Aplikasi Terbuka
                    <span style="margin-left:auto; background:#ede9fe; color:#6366f1; font-size:11px; padding:2px 8px; border-radius:99px; font-weight:600;">{{ count($data['apps'] ?? []) }}</span>
                </div>
                <div class="apps-list">
                    @forelse($data['apps'] ?? [] as $app)
                        <div class="detail-app-chip">
                            <div class="detail-app-icon"><i class="ph ph-app-window"></i></div>
                            <span>{{ $app }}</span>
                        </div>
                    @empty
                        <div style="padding:12px 14px; font-size:12px; color:#9ca3af;">Tidak ada aplikasi terbuka.</div>
                    @endforelse
                </div>
            </div>

            {{-- Security Alerts --}}
            <div class="detail-info-card">
                <div class="detail-section-header" style="color:#ef4444;">
                    <i class="ph ph-shield-warning" style="color:#ef4444;"></i>
                    Peringatan Keamanan &amp; USB
                </div>
                <div>
                    @forelse($alerts ?? [] as $alert)
                        <div class="detail-alert-row">
                            <div class="detail-alert-icon {{ str_contains($alert->type, 'inserted') ? 'alert-inserted' : 'alert-removed' }}">
                                <i class="ph ph-usb"></i>
                            </div>
                            <div class="detail-alert-text">{{ $alert->description }}</div>
                            <div class="detail-alert-time">{{ $alert->logged_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <div style="padding:14px 16px; font-size:12px; color:#9ca3af; display:flex; align-items:center; gap:8px;">
                            <i class="ph ph-shield-check" style="font-size:18px; color:#10b981;"></i>
                            Tidak ada peringatan.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Activity Timeline --}}
            <div class="detail-info-card">
                <div class="detail-section-header">
                    <i class="ph ph-list-dashes"></i>
                    Lini Masa Aktivitas
                </div>
                <div class="detail-card-grid activity-timeline" style="max-height:240px; overflow-y:auto; padding: 8px 16px;">
                    <div class="dinfo-row" style="color:#9ca3af; font-size:12px; justify-content:flex-start; gap:8px;">
                        <i class="ph ph-clock"></i> Menunggu aktivitas...
                    </div>
                </div>
            </div>

        </div>{{-- End right panel --}}

    </div>{{-- End detail-body --}}

</section>
</x-layouts.app>
