<x-layouts.app>
  <section class="view view-detail">
    <a href="{{ url('/') }}" class="btn btn-ghost back-btn" id="backToLive">
      <i class="ph ph-arrow-left"></i>
      <span>Back to Live Screens</span>
    </a>

    <div class="detail-layout">
      <!-- Left: Screen Viewer -->
      <div class="detail-screen">
        <div class="detail-screen-viewer" style="background: var(--gray-900) url('{{ $data['screen'] }}') center/cover no-repeat; position: relative; overflow: hidden;">
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
      </div>

      <!-- Right: Detail Info -->
      <div class="detail-info">
        <!-- Employee Header -->
        <div class="detail-employee-header">
          <div class="detail-employee-avatar" style="background: #6366f1;">{{ strtoupper(substr($data['user'], 0, 2)) }}</div>
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
            Device Info
          </h3>
          <div class="detail-card-grid">
            <div class="detail-info-row">
              <span class="detail-info-label">Operating System</span>
              <span class="detail-info-value">{{ $data['device'] ?? 'Unknown' }}</span>
            </div>
            <div class="detail-info-row">
              <span class="detail-info-label">IP Address</span>
              <span class="detail-info-value ip-value">{{ $data['ip'] ?? '127.0.0.1' }}</span>
            </div>
            <div class="detail-info-row">
              <span class="detail-info-label">Network</span>
              <span class="detail-info-value ssid-value">{{ $data['ssid'] ?? 'Unknown' }}</span>
            </div>
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
            @foreach($data['apps'] ?? [] as $app)
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
