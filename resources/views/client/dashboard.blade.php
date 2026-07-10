<x-layouts.app>

      <section class="view view-dashboard">
        <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
          <div>
            <h1 class="page-title">Dasbor</h1>
            <p class="page-subtitle">Ringkasan semua aktivitas pemantauan</p>
          </div>
          
          <div style="background: white; border: 1px solid #e5e7eb; padding: 1rem 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; gap: 2rem; align-items: center;">
            <div style="display: flex; gap: 1rem; align-items: center;">
                <div>
                  <span style="display: block; font-size: 0.75rem; color: #6b7280; font-weight: 600; text-transform: uppercase; margin-bottom: 0.25rem;">Paket Saat Ini</span>
                  <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="ph ph-package" style="color: #3b82f6; font-size: 1.25rem;"></i>
                    <span style="font-weight: 600; color: #111827; font-size: 1rem;">{{ $plan ? $plan->name : 'Belum Ada Paket' }}</span>
                  </div>
                </div>
                
                @if($plan && stripos($plan->name, 'trial') === false)
                    <div style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: white; padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; gap: 0.25rem; box-shadow: 0 2px 4px rgba(245, 158, 11, 0.3);">
                        <i class="ph-fill ph-crown"></i> PRO
                    </div>
                @else
                    <div style="background: #e5e7eb; color: #4b5563; padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; gap: 0.25rem;">
                        FREE
                    </div>
                @endif
            </div>
            
            <div style="width: 1px; height: 2rem; background: #e5e7eb;"></div>
            
            <div>
              <span style="display: block; font-size: 0.75rem; color: #6b7280; font-weight: 600; text-transform: uppercase; margin-bottom: 0.25rem;">Masa Aktif</span>
              <div style="display: flex; align-items: center; gap: 0.5rem;">
                <i class="ph ph-calendar" style="color: #10b981; font-size: 1.25rem;"></i>
                <span style="font-weight: 600; color: #111827; font-size: 1rem;">
                    {{ tenant('billing_end_date') ? \Carbon\Carbon::parse(tenant('billing_end_date'))->format('d M Y') : '-' }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="stats-grid">
          <div class="stat-card stat-card--blue">
            <div class="stat-card-header">
              <span class="stat-card-label">Total Karyawan</span>
              <div class="stat-card-icon blue">
                <i class="ph ph-users"></i>
              </div>
            </div>
            <div class="stat-card-value">{{ $totalEmployees }}</div>
            <div class="stat-card-change">
              <span>Keseluruhan data</span>
            </div>
          </div>

          <div class="stat-card stat-card--green">
            <div class="stat-card-header">
              <span class="stat-card-label">Online Saat Ini</span>
              <div class="stat-card-icon green">
                <i class="ph ph-wifi-high"></i>
              </div>
            </div>
            <div class="stat-card-value">{{ $onlineEmployees }}</div>
            <div class="stat-card-change positive">
              <i class="ph ph-activity"></i>
              <span>{{ $totalEmployees > 0 ? round(($onlineEmployees / $totalEmployees) * 100) : 0 }}% active</span>
            </div>
          </div>

          <div class="stat-card stat-card--yellow">
            <div class="stat-card-header">
              <span class="stat-card-label">Menganggur</span>
              <div class="stat-card-icon yellow">
                <i class="ph ph-clock"></i>
              </div>
            </div>
            <div class="stat-card-value">{{ $idleEmployees }}</div>
            <div class="stat-card-change neutral">
              <span>Sementara rehat</span>
            </div>
          </div>

          <div class="stat-card stat-card--red">
            <div class="stat-card-header">
              <span class="stat-card-label">Offline</span>
              <div class="stat-card-icon red">
                <i class="ph ph-circle"></i>
              </div>
            </div>
            <div class="stat-card-value">{{ $offlineEmployees }}</div>
            <div class="stat-card-change negative">
              <span>Tidak terhubung</span>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Aktivitas Terbaru</h2>
            <button class="btn btn-ghost btn-sm">
              <i class="ph ph-dots-three"></i>
            </button>
          </div>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Karyawan</th>
                  <th>Perangkat</th>
                  <th>Status</th>
                  <th>Aktivitas Terakhir</th>
                  <th>Aplikasi Saat Ini</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentEmployees as $employee)
                <tr>
                  <td>
                    <div class="table-user">
                      @php
                        $colors = ['#6366f1', '#ec4899', '#f59e0b', '#10b981', '#0ea5e9'];
                        $bgColor = $colors[$employee->id % count($colors)];
                        $initials = strtoupper(substr($employee->name, 0, 2));
                      @endphp
                      <div class="table-user-avatar" style="background: {{ $bgColor }};">{{ $initials }}</div>
                      <div style="display: flex; flex-direction: column;">
                          <span style="font-weight: 500; color: #111827;">{{ $employee->name }}</span>
                          <small style="color: #6b7280; font-size: 0.75rem;">{{ $employee->department ? $employee->department->name : '-' }}</small>
                      </div>
                    </div>
                  </td>
                  <td>
                    @if($employee->os_info)
                        <i class="ph ph-windows-logo"></i> {{ $employee->os_info }}
                    @else
                        -
                    @endif
                  </td>
                  <td>
                    @if($employee->status === 'online' || $employee->status === 'active')
                        <span class="badge badge-active">Active</span>
                    @elseif($employee->status === 'idle')
                        <span class="badge badge-idle">Idle</span>
                    @else
                        <span class="badge badge-offline">Offline</span>
                    @endif
                  </td>
                  <td>{{ $employee->last_active_at ? $employee->last_active_at->diffForHumans() : '-' }}</td>
                  <td>
                    @if($employee->device_info)
                        <i class="ph ph-app-window"></i> {{ $employee->device_info }}
                    @else
                        -
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 2rem; color: #6b7280;">
                        <i class="ph ph-users" style="font-size: 2rem; margin-bottom: 0.5rem; display: block; color: #9ca3af;"></i>
                        Belum ada karyawan.
                    </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </section>

</x-layouts.app>
