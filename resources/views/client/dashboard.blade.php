<x-layouts.app>

      <!-- ==================== VIEW 1: DASHBOARD ==================== -->
      <section class="view view-dashboard" style="display: none;">
        <div class="page-header">
          <h1 class="page-title">Dasbor</h1>
          <p class="page-subtitle">Ringkasan semua aktivitas pemantauan</p>
        </div>

        <div class="stats-grid">
          <div class="stat-card stat-card--blue">
            <div class="stat-card-header">
              <span class="stat-card-label">Total Karyawan</span>
              <div class="stat-card-icon blue">
                <i class="ph ph-users"></i>
              </div>
            </div>
            <div class="stat-card-value">30</div>
            <div class="stat-card-change positive">
              <i class="ph ph-arrow-up"></i>
              <span>+2 this week</span>
            </div>
          </div>

          <div class="stat-card stat-card--green">
            <div class="stat-card-header">
              <span class="stat-card-label">Online Saat Ini</span>
              <div class="stat-card-icon green">
                <i class="ph ph-wifi-high"></i>
              </div>
            </div>
            <div class="stat-card-value">24</div>
            <div class="stat-card-change positive">
              <i class="ph ph-activity"></i>
              <span>80% active</span>
            </div>
          </div>

          <div class="stat-card stat-card--yellow">
            <div class="stat-card-header">
              <span class="stat-card-label">Menganggur</span>
              <div class="stat-card-icon yellow">
                <i class="ph ph-clock"></i>
              </div>
            </div>
            <div class="stat-card-value">4</div>
            <div class="stat-card-change neutral">
              <i class="ph ph-clock"></i>
              <span>avg 12min</span>
            </div>
          </div>

          <div class="stat-card stat-card--red">
            <div class="stat-card-header">
              <span class="stat-card-label">Offline</span>
              <div class="stat-card-icon red">
                <i class="ph ph-circle"></i>
              </div>
            </div>
            <div class="stat-card-value">2</div>
            <div class="stat-card-change negative">
              <i class="ph ph-arrow-down"></i>
              <span>since 2h ago</span>
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
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #6366f1;">AF</div>
                      <span>Ahmad Fauzi</span>
                    </div>
                  </td>
                  <td><i class="ph ph-windows-logo"></i> Windows 11</td>
                  <td><span class="badge badge-active">Active</span></td>
                  <td>2 min ago</td>
                  <td><i class="ph ph-app-window"></i> VS Code</td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #ec4899;">SN</div>
                      <span>Siti Nurhaliza</span>
                    </div>
                  </td>
                  <td><i class="ph ph-windows-logo"></i> Windows 11</td>
                  <td><span class="badge badge-active">Active</span></td>
                  <td>Just now</td>
                  <td><i class="ph ph-app-window"></i> Google Chrome</td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #f59e0b;">BS</div>
                      <span>Budi Santoso</span>
                    </div>
                  </td>
                  <td><i class="ph ph-android-logo"></i> Android 14</td>
                  <td><span class="badge badge-idle">Idle</span></td>
                  <td>12 min ago</td>
                  <td><i class="ph ph-app-window"></i> WhatsApp</td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #10b981;">DL</div>
                      <span>Dewi Lestari</span>
                    </div>
                  </td>
                  <td><i class="ph ph-windows-logo"></i> Windows 10</td>
                  <td><span class="badge badge-active">Active</span></td>
                  <td>1 min ago</td>
                  <td><i class="ph ph-app-window"></i> Microsoft Excel</td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #6b7280;">EP</div>
                      <span>Eko Prasetyo</span>
                    </div>
                  </td>
                  <td><i class="ph ph-windows-logo"></i> Windows 11</td>
                  <td><span class="badge badge-offline">Offline</span></td>
                  <td>2 hours ago</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #8b5cf6;">FH</div>
                      <span>Fitri Handayani</span>
                    </div>
                  </td>
                  <td><i class="ph ph-android-logo"></i> Android 13</td>
                  <td><span class="badge badge-active">Active</span></td>
                  <td>Just now</td>
                  <td><i class="ph ph-app-window"></i> Slack</td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #0ea5e9;">GW</div>
                      <span>Gunawan Wibowo</span>
                    </div>
                  </td>
                  <td><i class="ph ph-windows-logo"></i> Windows 11</td>
                  <td><span class="badge badge-active">Active</span></td>
                  <td>3 min ago</td>
                  <td><i class="ph ph-app-window"></i> Figma</td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #6b7280;">HP</div>
                      <span>Hana Pertiwi</span>
                    </div>
                  </td>
                  <td><i class="ph ph-windows-logo"></i> Windows 10</td>
                  <td><span class="badge badge-offline">Offline</span></td>
                  <td>1 hour ago</td>
                  <td>-</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- ==================== VIEW 2: LIVE SCREENS ==================== -->
      <section class="view view-live">
        <div class="page-header">
          <h1 class="page-title">Layar Langsung</h1>
          <p class="page-subtitle">Pemantauan layar waktu nyata (real-time)</p>
        </div>

        <div class="toolbar">
          <div class="toolbar-left">
            <div class="select-wrapper">
              <select class="select" id="statusFilter">
                <option value="all">Semua Status</option>
                <option value="active">Online</option>
                <option value="idle">Menganggur</option>
                <option value="offline">Luring</option>
              </select>
              <i class="ph ph-caret-down"></i>
            </div>
            <div class="toolbar-search">
              <i class="ph ph-magnifying-glass"></i>
              <input type="text" placeholder="Cari karyawan..." id="monitorSearch">
            </div>
          </div>
          <div class="toolbar-right">
            <div class="view-toggle">
              <button class="view-toggle-btn active" data-layout="grid" aria-label="Grid view">
                <i class="ph ph-squares-four"></i>
              </button>
              <button class="view-toggle-btn" data-layout="list" aria-label="List view">
                <i class="ph ph-list"></i>
              </button>
            </div>
            <a href="{{ asset('downloads/AgentKu_Setup.exe') }}" download class="btn btn-primary" style="text-decoration: none;">
              <i class="ph ph-download-simple"></i>
              <span>Unduh Agen</span>
            </a>
            <button class="btn btn-outline" id="refreshBtn">
              <i class="ph ph-arrow-clockwise"></i>
              <span>Segarkan</span>
            </button>
          </div>
        </div>

        <div class="monitor-grid" id="monitorGrid">
        </div>
      </section>


      <!-- ==================== VIEW 4: EMPLOYEES ==================== -->
      <section class="view view-employees" style="display: none;">
        <div class="page-header">
          <div>
            <h1 class="page-title">Karyawan</h1>
            <p class="page-subtitle">Kelola karyawan yang dipantau</p>
          </div>
        </div>

        <div class="toolbar">
          <div class="toolbar-left">
            <div class="toolbar-search">
              <i class="ph ph-magnifying-glass"></i>
              <input type="text" placeholder="Cari karyawan...">
            </div>
          </div>
          <div class="toolbar-right">
            <button class="btn btn-primary">
              <i class="ph ph-plus"></i>
              <span>Tambah Karyawan</span>
            </button>
          </div>
        </div>

        <div class="card">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Departemen</th>
                  <th>Perangkat</th>
                  <th>Sistem Operasi</th>
                  <th>Status</th>
                  <th>Aktivitas Terakhir</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #6366f1;">AF</div>
                      <span>Ahmad Fauzi</span>
                    </div>
                  </td>
                  <td>IT Department</td>
                  <td>Desktop</td>
                  <td><i class="ph ph-windows-logo"></i> Windows 11</td>
                  <td><span class="badge badge-active">Active</span></td>
                  <td>2 min ago</td>
                  <td>
                    <div class="table-actions">
                      <button class="btn btn-ghost btn-sm" title="Edit"><i class="ph ph-pencil-simple"></i></button>
                      <button class="btn btn-ghost btn-sm btn-danger" title="Delete"><i class="ph ph-trash"></i></button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #ec4899;">SN</div>
                      <span>Siti Nurhaliza</span>
                    </div>
                  </td>
                  <td>Marketing</td>
                  <td>Desktop</td>
                  <td><i class="ph ph-windows-logo"></i> Windows 11</td>
                  <td><span class="badge badge-active">Active</span></td>
                  <td>Just now</td>
                  <td>
                    <div class="table-actions">
                      <button class="btn btn-ghost btn-sm" title="Edit"><i class="ph ph-pencil-simple"></i></button>
                      <button class="btn btn-ghost btn-sm btn-danger" title="Delete"><i class="ph ph-trash"></i></button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #f59e0b;">BS</div>
                      <span>Budi Santoso</span>
                    </div>
                  </td>
                  <td>Sales</td>
                  <td>Mobile</td>
                  <td><i class="ph ph-android-logo"></i> Android 14</td>
                  <td><span class="badge badge-idle">Idle</span></td>
                  <td>12 min ago</td>
                  <td>
                    <div class="table-actions">
                      <button class="btn btn-ghost btn-sm" title="Edit"><i class="ph ph-pencil-simple"></i></button>
                      <button class="btn btn-ghost btn-sm btn-danger" title="Delete"><i class="ph ph-trash"></i></button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #10b981;">DL</div>
                      <span>Dewi Lestari</span>
                    </div>
                  </td>
                  <td>Finance</td>
                  <td>Desktop</td>
                  <td><i class="ph ph-windows-logo"></i> Windows 10</td>
                  <td><span class="badge badge-active">Active</span></td>
                  <td>1 min ago</td>
                  <td>
                    <div class="table-actions">
                      <button class="btn btn-ghost btn-sm" title="Edit"><i class="ph ph-pencil-simple"></i></button>
                      <button class="btn btn-ghost btn-sm btn-danger" title="Delete"><i class="ph ph-trash"></i></button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #6b7280;">EP</div>
                      <span>Eko Prasetyo</span>
                    </div>
                  </td>
                  <td>IT Department</td>
                  <td>Desktop</td>
                  <td><i class="ph ph-windows-logo"></i> Windows 11</td>
                  <td><span class="badge badge-offline">Offline</span></td>
                  <td>2 hours ago</td>
                  <td>
                    <div class="table-actions">
                      <button class="btn btn-ghost btn-sm" title="Edit"><i class="ph ph-pencil-simple"></i></button>
                      <button class="btn btn-ghost btn-sm btn-danger" title="Delete"><i class="ph ph-trash"></i></button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #8b5cf6;">FH</div>
                      <span>Fitri Handayani</span>
                    </div>
                  </td>
                  <td>HR</td>
                  <td>Mobile</td>
                  <td><i class="ph ph-android-logo"></i> Android 13</td>
                  <td><span class="badge badge-active">Active</span></td>
                  <td>Just now</td>
                  <td>
                    <div class="table-actions">
                      <button class="btn btn-ghost btn-sm" title="Edit"><i class="ph ph-pencil-simple"></i></button>
                      <button class="btn btn-ghost btn-sm btn-danger" title="Delete"><i class="ph ph-trash"></i></button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #0ea5e9;">GW</div>
                      <span>Gunawan Wibowo</span>
                    </div>
                  </td>
                  <td>Design</td>
                  <td>Desktop</td>
                  <td><i class="ph ph-windows-logo"></i> Windows 11</td>
                  <td><span class="badge badge-active">Active</span></td>
                  <td>3 min ago</td>
                  <td>
                    <div class="table-actions">
                      <button class="btn btn-ghost btn-sm" title="Edit"><i class="ph ph-pencil-simple"></i></button>
                      <button class="btn btn-ghost btn-sm btn-danger" title="Delete"><i class="ph ph-trash"></i></button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #6b7280;">HP</div>
                      <span>Hana Pertiwi</span>
                    </div>
                  </td>
                  <td>Finance</td>
                  <td>Desktop</td>
                  <td><i class="ph ph-windows-logo"></i> Windows 10</td>
                  <td><span class="badge badge-offline">Offline</span></td>
                  <td>1 hour ago</td>
                  <td>
                    <div class="table-actions">
                      <button class="btn btn-ghost btn-sm" title="Edit"><i class="ph ph-pencil-simple"></i></button>
                      <button class="btn btn-ghost btn-sm btn-danger" title="Delete"><i class="ph ph-trash"></i></button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #14b8a6;">IK</div>
                      <span>Indra Kusuma</span>
                    </div>
                  </td>
                  <td>IT Department</td>
                  <td>Desktop</td>
                  <td><i class="ph ph-windows-logo"></i> Windows 11</td>
                  <td><span class="badge badge-active">Active</span></td>
                  <td>Just now</td>
                  <td>
                    <div class="table-actions">
                      <button class="btn btn-ghost btn-sm" title="Edit"><i class="ph ph-pencil-simple"></i></button>
                      <button class="btn btn-ghost btn-sm btn-danger" title="Delete"><i class="ph ph-trash"></i></button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #f472b6;">JP</div>
                      <span>Jasmine Putri</span>
                    </div>
                  </td>
                  <td>Marketing</td>
                  <td>Mobile</td>
                  <td><i class="ph ph-android-logo"></i> Android 14</td>
                  <td><span class="badge badge-active">Active</span></td>
                  <td>1 min ago</td>
                  <td>
                    <div class="table-actions">
                      <button class="btn btn-ghost btn-sm" title="Edit"><i class="ph ph-pencil-simple"></i></button>
                      <button class="btn btn-ghost btn-sm btn-danger" title="Delete"><i class="ph ph-trash"></i></button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #f59e0b;">KA</div>
                      <span>Kurniawan Adi</span>
                    </div>
                  </td>
                  <td>Operations</td>
                  <td>Desktop</td>
                  <td><i class="ph ph-windows-logo"></i> Windows 11</td>
                  <td><span class="badge badge-idle">Idle</span></td>
                  <td>8 min ago</td>
                  <td>
                    <div class="table-actions">
                      <button class="btn btn-ghost btn-sm" title="Edit"><i class="ph ph-pencil-simple"></i></button>
                      <button class="btn btn-ghost btn-sm btn-danger" title="Delete"><i class="ph ph-trash"></i></button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="table-user">
                      <div class="table-user-avatar" style="background: #a855f7;">LM</div>
                      <span>Lisa Maharani</span>
                    </div>
                  </td>
                  <td>HR</td>
                  <td>Desktop</td>
                  <td><i class="ph ph-windows-logo"></i> Windows 10</td>
                  <td><span class="badge badge-active">Active</span></td>
                  <td>Just now</td>
                  <td>
                    <div class="table-actions">
                      <button class="btn btn-ghost btn-sm" title="Edit"><i class="ph ph-pencil-simple"></i></button>
                      <button class="btn btn-ghost btn-sm btn-danger" title="Delete"><i class="ph ph-trash"></i></button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>

</x-layouts.app>
