<x-layouts.app>

      <!-- ==================== VIEW 1: DASHBOARD ==================== -->
      <section class="view view-dashboard" style="display: none;">
        <div class="page-header">
          <h1 class="page-title">Dashboard</h1>
          <p class="page-subtitle">Overview of all monitoring activity</p>
        </div>

        <div class="stats-grid">
          <div class="stat-card stat-card--blue">
            <div class="stat-card-header">
              <span class="stat-card-label">Total Employees</span>
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
              <span class="stat-card-label">Online Now</span>
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
              <span class="stat-card-label">Idle</span>
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
            <h2 class="card-title">Recent Activity</h2>
            <button class="btn btn-ghost btn-sm">
              <i class="ph ph-dots-three"></i>
            </button>
          </div>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Employee</th>
                  <th>Device</th>
                  <th>Status</th>
                  <th>Last Active</th>
                  <th>Current App</th>
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
          <h1 class="page-title">Live Screens</h1>
          <p class="page-subtitle">Real-time screen monitoring</p>
        </div>

        <div class="toolbar">
          <div class="toolbar-left">
            <div class="select-wrapper">
              <select class="select" id="statusFilter">
                <option value="all">All Status</option>
                <option value="active">Online</option>
                <option value="idle">Idle</option>
                <option value="offline">Offline</option>
              </select>
              <i class="ph ph-caret-down"></i>
            </div>
            <div class="toolbar-search">
              <i class="ph ph-magnifying-glass"></i>
              <input type="text" placeholder="Search employees..." id="monitorSearch">
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
            <button class="btn btn-outline" id="refreshBtn">
              <i class="ph ph-arrow-clockwise"></i>
              <span>Refresh</span>
            </button>
          </div>
        </div>

        <div class="monitor-grid" id="monitorGrid">

              <button class="btn btn-sm btn-primary view-detail-btn">View Detail</button>
            </div>
          </div>

        </div>
      </section>

      <!-- ==================== VIEW 3: DETAIL VIEW ==================== -->
      <section class="view view-detail" style="display: none;">
        <button class="btn btn-ghost back-btn" id="backToLive">
          <i class="ph ph-arrow-left"></i>
          <span>Back to Live Screens</span>
        </button>

        <div class="detail-layout">
          <!-- Left: Screen Viewer -->
          <div class="detail-screen">
            <div class="detail-screen-viewer" style="background: linear-gradient(180deg, #1e1e2e 0%, #282a36 30%, #1e1e2e 100%); position: relative; overflow: hidden;">
              <div style="position:absolute;top:8%;left:6%;right:6%;height:2px;background:rgba(139,92,246,0.4);border-radius:2px;"></div>
              <div style="position:absolute;top:12%;left:6%;right:20%;height:2px;background:rgba(86,182,194,0.35);border-radius:2px;"></div>
              <div style="position:absolute;top:16%;left:10%;right:28%;height:2px;background:rgba(248,113,113,0.3);border-radius:2px;"></div>
              <div style="position:absolute;top:20%;left:10%;right:12%;height:2px;background:rgba(250,204,21,0.3);border-radius:2px;"></div>
              <div style="position:absolute;top:24%;left:6%;right:32%;height:2px;background:rgba(139,92,246,0.4);border-radius:2px;"></div>
              <div style="position:absolute;top:28%;left:10%;right:18%;height:2px;background:rgba(74,222,128,0.3);border-radius:2px;"></div>
              <div style="position:absolute;top:32%;left:10%;right:24%;height:2px;background:rgba(86,182,194,0.35);border-radius:2px;"></div>
              <div style="position:absolute;top:36%;left:6%;right:38%;height:2px;background:rgba(248,113,113,0.3);border-radius:2px;"></div>
              <div style="position:absolute;top:40%;left:14%;right:20%;height:2px;background:rgba(250,204,21,0.3);border-radius:2px;"></div>
              <div style="position:absolute;top:44%;left:6%;right:28%;height:2px;background:rgba(139,92,246,0.35);border-radius:2px;"></div>
              <div style="position:absolute;top:48%;left:10%;right:35%;height:2px;background:rgba(74,222,128,0.3);border-radius:2px;"></div>
              <div style="position:absolute;top:52%;left:10%;right:15%;height:2px;background:rgba(86,182,194,0.35);border-radius:2px;"></div>
              <div style="position:absolute;top:56%;left:6%;right:22%;height:2px;background:rgba(248,113,113,0.3);border-radius:2px;"></div>
              <div style="position:absolute;top:60%;left:14%;right:30%;height:2px;background:rgba(250,204,21,0.3);border-radius:2px;"></div>
              <div style="position:absolute;top:64%;left:6%;right:42%;height:2px;background:rgba(139,92,246,0.4);border-radius:2px;"></div>
              <div style="position:absolute;top:68%;left:10%;right:18%;height:2px;background:rgba(74,222,128,0.3);border-radius:2px;"></div>
              <div style="position:absolute;top:3%;left:4%;width:30%;height:3%;background:rgba(40,42,54,0.9);border-radius:3px;display:flex;align-items:center;padding-left:6px;">
                <div style="width:5px;height:5px;border-radius:50%;background:#ff5f57;margin-right:3px;"></div>
                <div style="width:5px;height:5px;border-radius:50%;background:#febc2e;margin-right:3px;"></div>
                <div style="width:5px;height:5px;border-radius:50%;background:#28c840;"></div>
              </div>
              <div class="detail-screen-live-badge">
                <span class="live-dot"></span>
                LIVE
              </div>
            </div>
            <div class="detail-screen-toolbar">
              <button class="btn btn-outline btn-sm">
                <i class="ph ph-camera"></i>
                <span>Screenshot</span>
              </button>
              <button class="btn btn-outline btn-sm">
                <i class="ph ph-record"></i>
                <span>Record</span>
              </button>
              <button class="btn btn-outline btn-sm">
                <i class="ph ph-arrows-out"></i>
                <span>Full Screen</span>
              </button>
            </div>
          </div>

          <!-- Right: Detail Info -->
          <div class="detail-info">
            <!-- Employee Header -->
            <div class="detail-employee-header">
              <div class="detail-employee-avatar" style="background: #6366f1;">AF</div>
              <div class="detail-employee-meta">
                <h2 class="detail-employee-name">Ahmad Fauzi</h2>
                <p class="detail-employee-dept">IT Department</p>
              </div>
              <span class="badge badge-active">Active</span>
            </div>

            <!-- Device Info Card -->
            <div class="detail-card">
              <h3 class="detail-card-title">
                <i class="ph ph-desktop"></i>
                Device Info
              </h3>
              <div class="detail-card-grid">
                <div class="detail-info-row">
                  <span class="detail-info-label">IP Address</span>
                  <span class="detail-info-value">192.168.1.45</span>
                </div>
                <div class="detail-info-row">
                  <span class="detail-info-label">Operating System</span>
                  <span class="detail-info-value">Windows 11 Pro</span>
                </div>
                <div class="detail-info-row">
                  <span class="detail-info-label">RAM Usage</span>
                  <span class="detail-info-value">
                    12.4 / 16 GB
                    <div class="progress-bar">
                      <div class="progress-bar-fill" style="width: 77%; background: #6366f1;"></div>
                    </div>
                  </span>
                </div>
                <div class="detail-info-row">
                  <span class="detail-info-label">CPU Usage</span>
                  <span class="detail-info-value">
                    34%
                    <div class="progress-bar">
                      <div class="progress-bar-fill" style="width: 34%; background: #10b981;"></div>
                    </div>
                  </span>
                </div>
                <div class="detail-info-row">
                  <span class="detail-info-label">Screen Resolution</span>
                  <span class="detail-info-value">1920 x 1080</span>
                </div>
                <div class="detail-info-row">
                  <span class="detail-info-label">Agent Version</span>
                  <span class="detail-info-value">v2.1.0</span>
                </div>
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
                  <span class="detail-info-value">Visual Studio Code</span>
                </div>
                <div class="detail-info-row">
                  <span class="detail-info-label">Current File</span>
                  <span class="detail-info-value">dashboard.blade.php</span>
                </div>
                <div class="detail-info-row">
                  <span class="detail-info-label">Duration</span>
                  <span class="detail-info-value">1h 23m</span>
                </div>
              </div>
            </div>

            <!-- Activity Timeline Card -->
            <div class="detail-card">
              <h3 class="detail-card-title">
                <i class="ph ph-clock"></i>
                Activity Timeline
              </h3>
              <div class="timeline">
                <div class="timeline-item">
                  <div class="timeline-dot active"></div>
                  <div class="timeline-content">
                    <span class="timeline-time">14:30</span>
                    <span class="timeline-text">Opened VS Code</span>
                  </div>
                </div>
                <div class="timeline-item">
                  <div class="timeline-dot"></div>
                  <div class="timeline-content">
                    <span class="timeline-time">14:15</span>
                    <span class="timeline-text">Switched from Chrome</span>
                  </div>
                </div>
                <div class="timeline-item">
                  <div class="timeline-dot"></div>
                  <div class="timeline-content">
                    <span class="timeline-time">13:45</span>
                    <span class="timeline-text">Google Chrome - stackoverflow.com</span>
                  </div>
                </div>
                <div class="timeline-item">
                  <div class="timeline-dot"></div>
                  <div class="timeline-content">
                    <span class="timeline-time">13:20</span>
                    <span class="timeline-text">Slack - #dev-team channel</span>
                  </div>
                </div>
                <div class="timeline-item">
                  <div class="timeline-dot idle"></div>
                  <div class="timeline-content">
                    <span class="timeline-time">12:00</span>
                    <span class="timeline-text">Lunch Break (Idle)</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ==================== VIEW 4: EMPLOYEES ==================== -->
      <section class="view view-employees" style="display: none;">
        <div class="page-header">
          <div>
            <h1 class="page-title">Employees</h1>
            <p class="page-subtitle">Manage monitored employees</p>
          </div>
        </div>

        <div class="toolbar">
          <div class="toolbar-left">
            <div class="toolbar-search">
              <i class="ph ph-magnifying-glass"></i>
              <input type="text" placeholder="Search employees...">
            </div>
          </div>
          <div class="toolbar-right">
            <button class="btn btn-primary">
              <i class="ph ph-plus"></i>
              <span>Add Employee</span>
            </button>
          </div>
        </div>

        <div class="card">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Department</th>
                  <th>Device</th>
                  <th>OS</th>
                  <th>Status</th>
                  <th>Last Active</th>
                  <th>Actions</th>
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
