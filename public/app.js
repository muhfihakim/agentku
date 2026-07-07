/**
 * AgenKu — Employee Screen Monitoring Dashboard
 * Pure Vanilla JavaScript — No Frameworks
 */

document.addEventListener('DOMContentLoaded', () => {

  // ──────────────────────────────────────────────
  // 1. SIDEBAR NAVIGATION
  // ──────────────────────────────────────────────
  const navItems = document.querySelectorAll('.sidebar-nav-item[data-view]');
  const views = {
    dashboard: document.querySelector('.view-dashboard'),
    live: document.querySelector('.view-live'),
    employees: document.querySelector('.view-employees'),
  };

  /**
   * Switch the visible view panel and update nav active state.
   */
  const switchView = (viewName, navEl = null) => {
    // Hide all views
    Object.values(views).forEach((v) => {
      if (v) {
        v.style.display = 'none';
        v.classList.remove('fadeIn');
      }
    });

    // Show target view with fade animation
    const target = views[viewName];
    if (target) {
      target.style.display = '';
      void target.offsetWidth; // trigger reflow
      target.classList.add('fadeIn');
    }

    // Update nav active states
    if (navEl) {
      navItems.forEach((n) => n.classList.remove('active'));
      navEl.classList.add('active');
    }
  };

  navItems.forEach((item) => {
    item.addEventListener('click', (e) => {
      e.preventDefault();
      const viewName = item.getAttribute('data-view');
      if (viewName && views[viewName]) {
        switchView(viewName, item);
      } else {
        window.location.href = '/';
      }
      closeSidebar();
    });
  });

  // ──────────────────────────────────────────────
  // 2. MOBILE SIDEBAR TOGGLE
  // ──────────────────────────────────────────────
  const sidebar = document.querySelector('.sidebar');
  const sidebarToggle = document.querySelector('.sidebar-toggle');
  const sidebarOverlay = document.querySelector('.sidebar-overlay');

  const openSidebar = () => {
    if (sidebar) sidebar.classList.add('active');
    if (sidebarOverlay) sidebarOverlay.classList.add('active');
  };

  const closeSidebar = () => {
    if (sidebar) sidebar.classList.remove('active');
    if (sidebarOverlay) sidebarOverlay.classList.remove('active');
  };

  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', () => {
      const isOpen = sidebar && sidebar.classList.contains('active');
      isOpen ? closeSidebar() : openSidebar();
    });
  }

  if (sidebarOverlay) {
    sidebarOverlay.addEventListener('click', closeSidebar);
  }
  // ──────────────────────────────────────────────
  // 3. LIVE SCREEN CARDS GRID
  // ──────────────────────────────────────────────
  const monitorGrid = document.getElementById('monitorGrid');
  // ──────────────────────────────────────────────
  // 5. FILTER DROPDOWN (Live Screens)
  // ──────────────────────────────────────────────
  const statusFilter = document.getElementById('statusFilter');
  const liveSearchInput = document.getElementById('monitorSearch');

  const filterCards = () => {
    if (!monitorGrid) return;
    const filterValue = statusFilter ? statusFilter.value : 'all';
    const searchValue = liveSearchInput ? liveSearchInput.value.toLowerCase().trim() : '';
    const cards = monitorGrid.querySelectorAll('.screen-card');

    cards.forEach((card) => {
      const cardStatus = card.getAttribute('data-status') || '';
      const cardName = (card.getAttribute('data-name') || '').toLowerCase();

      const matchesStatus = filterValue === 'all' || cardStatus === filterValue;
      const matchesSearch = !searchValue || cardName.includes(searchValue);

      if (matchesStatus && matchesSearch) {
        card.style.opacity = '1';
        card.style.transform = 'scale(1)';
        card.style.display = '';
        card.style.pointerEvents = '';
      } else {
        card.style.opacity = '0';
        card.style.transform = 'scale(0.95)';
        setTimeout(() => {
          if (card.style.opacity === '0') {
            card.style.display = 'none';
          }
        }, 250);
        card.style.pointerEvents = 'none';
      }
    });
  };

  if (statusFilter) {
    statusFilter.addEventListener('change', filterCards);
  }

  // ──────────────────────────────────────────────
  // 6. SEARCH FUNCTIONALITY
  // ──────────────────────────────────────────────
  if (liveSearchInput) {
    liveSearchInput.addEventListener('input', filterCards);
  }

  // Employees table search
  const employeesView = document.querySelector('.view-employees');
  if (employeesView) {
    const empSearchInput = employeesView.querySelector('.toolbar-search input');
    if (empSearchInput) {
      empSearchInput.addEventListener('input', () => {
        const query = empSearchInput.value.toLowerCase().trim();
        const rows = employeesView.querySelectorAll('.table tbody tr');

        rows.forEach((row) => {
          const name = row.textContent.toLowerCase();
          if (!query || name.includes(query)) {
            row.style.opacity = '1';
            row.style.display = '';
          } else {
            row.style.opacity = '0';
            setTimeout(() => {
              if (row.style.opacity === '0') {
                row.style.display = 'none';
              }
            }, 200);
          }
        });
      });
    }
  }

  // ──────────────────────────────────────────────
  // 7. VIEW TOGGLE — Grid / List
  // ──────────────────────────────────────────────
  const viewToggleBtns = document.querySelectorAll('.view-toggle-btn');

  if (viewToggleBtns.length && monitorGrid) {
    viewToggleBtns.forEach((btn) => {
      btn.addEventListener('click', () => {
        viewToggleBtns.forEach((b) => b.classList.remove('active'));
        btn.classList.add('active');

        const layout = btn.getAttribute('data-layout');
        if (layout === 'list') {
          monitorGrid.classList.add('list-view');
        } else {
          monitorGrid.classList.remove('list-view');
        }
      });
    });
  }

  // ──────────────────────────────────────────────
  // 8. SIMULATED REAL-TIME UPDATES
  // ──────────────────────────────────────────────
  // Initialize Echo
  if (typeof Pusher !== 'undefined' && !window.echoInstance) {
      window.Pusher = Pusher;
      const isHttps = window.location.protocol === 'https:';
      const isLocalhost = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
      window.echoInstance = new Echo({
          broadcaster: 'reverb',
          key: 'agenkukey',
          wsHost: window.location.hostname,
          wsPort: isLocalhost ? 8080 : 80,
          wssPort: isLocalhost ? 8080 : 443,
          forceTLS: isHttps,
          enabledTransports: ['ws', 'wss'],
      });
  }

  const simulateStatusUpdates = () => {
    if (!window.echoInstance) return;
    window.echoInstance.channel("agents")
      .listen("AgentDataReceived", async (e) => {
        const data = e.data;
        if (!data || !data.user) return;

        // 1. Dashboard (Live Screens) updates
        if (monitorGrid) {
          let card = monitorGrid.querySelector(`.screen-card[data-user="${data.user}"]`);
          if (!card) {
            card = document.createElement("div");
            card.className = "screen-card";
            card.setAttribute("data-user", data.user);
            card.innerHTML = `
              <div class="screen-thumb">
                <span class="status-badge"></span>
              </div>
              <div class="screen-card-info">
                <div class="screen-card-details">
                  <h3 class="screen-card-name"></h3>
                  <p class="screen-card-dept"></p>
                  <p class="screen-card-os"></p>
                </div>
                <a href="/monitor/${encodeURIComponent(data.user)}" class="btn btn-sm btn-primary view-detail-btn">View Detail</a>
              </div>
            `;
            monitorGrid.appendChild(card);
          }
          
          card.setAttribute("data-status", data.status);
          const badge = card.querySelector(".status-badge");
          if (badge) {
            badge.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
            badge.className = `status-badge ${data.status}`;
          }
          
          try {
            const res = await fetch("/api/monitor?user=" + encodeURIComponent(data.user));
            const fullData = await res.json();
            if (fullData.screen) {
              const thumb = card.querySelector(".screen-thumb");
              if (thumb) {
                thumb.style.background = `url(${fullData.screen}) center/cover no-repeat`;
                thumb.innerHTML = "";
                if (badge) thumb.appendChild(badge);
              }
            }
          } catch (err) {}
          
          const deptEl = card.querySelector(".screen-card-dept");
          if (deptEl) deptEl.textContent = "Window: " + data.window;
          const userNameEl = card.querySelector(".screen-card-name");
          if (userNameEl) userNameEl.textContent = data.user;
          const osEl = card.querySelector(".screen-card-os");
          if (osEl) {
            let iconClass = 'ph-windows-logo';
            if (data.device.toLowerCase().includes('mac')) iconClass = 'ph-apple-logo';
            else if (data.device.toLowerCase().includes('linux')) iconClass = 'ph-linux-logo';
            osEl.innerHTML = `<i class="ph ${iconClass}"></i> ` + data.device;
          }
          
          const notifList = document.querySelector(".notif-list");
          if (notifList) {
            const li = document.createElement("li");
            li.className = "notif-item";
            const truncWindow = data.window.length > 25 ? data.window.substring(0,25) + "..." : data.window;
            li.innerHTML = `
              <span class="notif-dot" style="background:#10B981;"></span>
              <div class="notif-content">
                <p class="notif-text">Log: ${truncWindow}</p>
                <span class="notif-time">Just now</span>
              </div>`;
            notifList.prepend(li);
            if (notifList.children.length > 10) notifList.lastElementChild.remove();
          }
          
          card.classList.add("flash-highlight");
          setTimeout(() => card.classList.remove("flash-highlight"), 800);
          
          filterCards();
          updateDashboardStats();
        }
        
        // 2. Detail Page updates
        const detailViewer = document.querySelector('.detail-screen-viewer');
        if (detailViewer) {
          const detailName = document.querySelector('.detail-employee-name');
          if (detailName && detailName.textContent === data.user) {
            try {
              const res = await fetch("/api/monitor?user=" + encodeURIComponent(data.user));
              const fullData = await res.json();
              if (fullData.screen) {
                detailViewer.style.background = `var(--gray-900) url("${fullData.screen}") center/cover no-repeat`;
              }
            } catch (err) {}

            const dBadge = document.querySelector('.detail-employee-header .badge');
            if (dBadge) {
              dBadge.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
              dBadge.className = `badge badge-${data.status}`;
            }
            const windowVal = document.querySelector('.window-value');
            if (windowVal && data.window) windowVal.textContent = data.window;
            
            const ipVal = document.querySelector('.ip-value');
            if (ipVal && data.ip) ipVal.textContent = data.ip;
            
            const ssidVal = document.querySelector('.ssid-value');
            if (ssidVal && data.ssid) ssidVal.textContent = data.ssid;
            
            const cpuVal = document.querySelector('.cpu-value');
            if (cpuVal && data.cpu !== undefined) cpuVal.textContent = data.cpu + '%';
            
            const ramVal = document.querySelector('.ram-value');
            if (ramVal && data.ram !== undefined) ramVal.textContent = data.ram + '%';
            
            const storageVal = document.querySelector('.storage-value');
            if (storageVal && data.storage !== undefined) storageVal.textContent = data.storage + '%';

            const locationVal = document.querySelector('.location-value');
            if (locationVal && data.city) {
                locationVal.innerHTML = data.lat && data.lng 
                  ? `<a href="https://www.google.com/maps/search/?api=1&query=${data.lat},${data.lng}" target="_blank" style="color:var(--primary); text-decoration:none;">${data.city} <i class="ph ph-arrow-up-right"></i></a>`
                  : data.city;
            }

            const batteryVal = document.querySelector('.battery-value');
            if (batteryVal && data.battery_percent !== undefined && data.battery_percent !== null) {
                batteryVal.textContent = `${data.battery_percent}% (${data.battery_plugged ? 'Charging' : 'On Battery'})`;
            } else if (batteryVal) {
                batteryVal.textContent = "N/A (Desktop)";
            }

            const idleVal = document.querySelector('.idle-value');
            if (idleVal && data.idle_time !== undefined) {
                const h = Math.floor(data.idle_time / 3600).toString().padStart(2, '0');
                const m = Math.floor((data.idle_time % 3600) / 60).toString().padStart(2, '0');
                const s = (data.idle_time % 60).toString().padStart(2, '0');
                idleVal.textContent = `${h}:${m}:${s}`;
            }

            const topAppsList = document.querySelector('.top-apps-list');
            if (topAppsList && data.top_apps && Array.isArray(data.top_apps)) {
                topAppsList.innerHTML = '';
                data.top_apps.forEach(app => {
                    const row = document.createElement('div');
                    row.className = 'detail-info-row';
                    const h = Math.floor(app.duration / 3600).toString().padStart(2, '0');
                    const m = Math.floor((app.duration % 3600) / 60).toString().padStart(2, '0');
                    const s = (app.duration % 60).toString().padStart(2, '0');
                    row.innerHTML = `<span class="detail-info-label"><i class="ph ph-app-window"></i> ${app.name}</span><span class="detail-info-value">${h}:${m}:${s}</span>`;
                    topAppsList.appendChild(row);
                });
            }
            
            const appsList = document.querySelector('.apps-list');
            if (appsList && data.apps && Array.isArray(data.apps)) {
                appsList.innerHTML = '';
                data.apps.forEach(app => {
                    const row = document.createElement('div');
                    row.className = 'detail-info-row';
                    row.innerHTML = '<span class="detail-info-label" style="display:flex; align-items:center; gap:8px;"><i class="ph ph-app-window" style="color:var(--primary);"></i>' + app + '</span>';
                    appsList.appendChild(row);
                });
            }
            
            if (window.networkChart) {
                const now = new Date();
                const timeLabel = now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();
                
                window.networkChart.data.labels.push(timeLabel);
                window.networkChart.data.datasets[0].data.push(data.net_download || 0);
                window.networkChart.data.datasets[1].data.push(data.net_upload || 0);
                
                if (window.networkChart.data.labels.length > 20) {
                    window.networkChart.data.labels.shift();
                    window.networkChart.data.datasets[0].data.shift();
                    window.networkChart.data.datasets[1].data.shift();
                }
                window.networkChart.update();
            }
          }
        }
      });
  };

  /** Count statuses across cards and update the dashboard stat widgets. */
  const updateDashboardStats = () => {
    if (!monitorGrid) return;
    const cards = monitorGrid.querySelectorAll('.screen-card');
    let online = 0;
    let idle = 0;
    let offline = 0;

    cards.forEach((c) => {
      const s = c.getAttribute('data-status');
      if (s === 'active') online++;
      else if (s === 'idle') idle++;
      else if (s === 'offline') offline++;
    });

    // Update stat card values by finding the stat-card elements
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card) => {
      const label = card.querySelector('.stat-card-label');
      const value = card.querySelector('.stat-card-value');
      if (!label || !value) return;

      const labelText = label.textContent.toLowerCase();
      if (labelText.includes('online')) {
        value.textContent = online;
      } else if (labelText.includes('idle')) {
        value.textContent = idle;
      } else if (labelText.includes('offline')) {
        value.textContent = offline;
      } else if (labelText.includes('total')) {
        value.textContent = cards.length;
      }
    });

    // Update topbar agents badge
    const agentsBadge = document.querySelector('.topbar-status-badge.agents span');
    if (agentsBadge) {
      agentsBadge.textContent = `Agents: ${online + idle}/${cards.length} Online`;
    }
  };

  simulateStatusUpdates();

  // ──────────────────────────────────────────────
  // 9. NOTIFICATION BELL
  // ──────────────────────────────────────────────
  const notifBell = document.querySelector('.topbar-notification');
  let notifDropdown = null;

  if (notifBell) {
    notifDropdown = document.createElement('div');
    notifDropdown.className = 'notification-dropdown';
    notifDropdown.innerHTML = `
      <div class="notif-header">Notifications</div>
      <ul class="notif-list">
        <li class="notif-item">
          <span class="notif-dot" style="background:#EF4444;"></span>
          <div class="notif-content">
            <p class="notif-text">Eko Prasetyo went offline</p>
            <span class="notif-time">2 hours ago</span>
          </div>
        </li>
        <li class="notif-item">
          <span class="notif-dot" style="background:#3B82F6;"></span>
          <div class="notif-content">
            <p class="notif-text">New device registered: Jasmine's Android</p>
            <span class="notif-time">3 hours ago</span>
          </div>
        </li>
        <li class="notif-item">
          <span class="notif-dot" style="background:#10B981;"></span>
          <div class="notif-content">
            <p class="notif-text">System update available v2.2.0</p>
            <span class="notif-time">5 hours ago</span>
          </div>
        </li>
      </ul>
    `;
    notifBell.style.position = 'relative';
    notifBell.appendChild(notifDropdown);

    notifBell.addEventListener('click', (e) => {
      e.stopPropagation();
      notifDropdown.classList.toggle('show');
    });

    document.addEventListener('click', (e) => {
      if (!notifBell.contains(e.target)) {
        notifDropdown.classList.remove('show');
      }
    });
  }

  // ──────────────────────────────────────────────
  // 10. CURRENT TIME DISPLAY
  // ──────────────────────────────────────────────
  const clockEl = document.querySelector('.clock, #clock, .current-time');

  const updateClock = () => {
    if (!clockEl) return;
    const now = new Date();
    const hh = String(now.getHours()).padStart(2, '0');
    const mm = String(now.getMinutes()).padStart(2, '0');
    const ss = String(now.getSeconds()).padStart(2, '0');
    clockEl.textContent = `${hh}:${mm}:${ss}`;
  };

  if (clockEl) {
    updateClock();
    setInterval(updateClock, 1000);
  }

  // ──────────────────────────────────────────────
  // 11. PROGRESS BAR ANIMATION
  // ──────────────────────────────────────────────
  const animateProgressBars = () => {
    const detailView = views.detail;
    if (!detailView) return;

    const bars = detailView.querySelectorAll('.progress-bar-fill');
    bars.forEach((bar) => {
      const target = bar.getAttribute('data-value') || bar.style.width || '0%';
      bar.style.transition = 'none';
      bar.style.width = '0%';
      void bar.offsetWidth; // force reflow
      bar.style.transition = 'width 1s cubic-bezier(0.4, 0, 0.2, 1)';
      bar.style.width = target;
    });
  };

  // ──────────────────────────────────────────────
  // 12. RESPONSIVE HELPERS
  // ──────────────────────────────────────────────
  const DESKTOP_BREAKPOINT = 1024;

  const handleResize = () => {
    if (window.innerWidth >= DESKTOP_BREAKPOINT) {
      closeSidebar();
    }
  };

  window.addEventListener('resize', handleResize);
  window.addEventListener('orientationchange', handleResize);

  // ──────────────────────────────────────────────
  // 13. REFRESH BUTTON
  // ──────────────────────────────────────────────
  const refreshBtn = document.getElementById('refreshBtn');
  if (refreshBtn) {
    refreshBtn.addEventListener('click', () => {
      const icon = refreshBtn.querySelector('i');
      if (icon) {
        icon.style.transition = 'transform 0.6s ease';
        icon.style.transform = 'rotate(360deg)';
        setTimeout(() => {
          icon.style.transition = 'none';
          icon.style.transform = 'rotate(0deg)';
        }, 600);
      }
      filterCards();
      updateDashboardStats();
    });
  }
  // ──────────────────────────────────────────────
  // 14. DETAIL SCREEN ACTIONS
  // ──────────────────────────────────────────────
  const btnScreenshot = document.getElementById('btn-screenshot');
  const btnFullscreen = document.getElementById('btn-fullscreen');
  const detailViewer = document.querySelector('.detail-screen-viewer');

  if (btnScreenshot) {
    btnScreenshot.addEventListener('click', async () => {
      try {
        const nameEl = document.querySelector('.detail-employee-name');
        if (!nameEl) return;
        const user = nameEl.textContent.trim();
        const res = await fetch("/api/monitor?user=" + encodeURIComponent(user));
        const fullData = await res.json();
        if (fullData.screen && fullData.screen.startsWith('data:image')) {
            const a = document.createElement('a');
            a.href = fullData.screen;
            a.download = `screenshot_${user}_${new Date().getTime()}.jpg`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        } else {
            alert('Screenshot data not available yet. Please wait a moment.');
        }
      } catch(e) {
          console.error(e);
      }
    });
  }

  if (btnFullscreen && detailViewer) {
    btnFullscreen.addEventListener('click', () => {
      if (!document.fullscreenElement) {
        detailViewer.requestFullscreen().catch(err => {
          alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
        });
      } else {
        document.exitFullscreen();
      }
    });
  }


  // ──────────────────────────────────────────────
  // NETWORK CHART INITIALIZATION
  // ──────────────────────────────────────────────
  window.networkChart = null;
  const ctx = document.getElementById('networkChart');
  if (ctx) {
    window.networkChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: [],
        datasets: [
          {
            label: 'Download (KB/s)',
            borderColor: '#3B82F6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            data: [],
            fill: true,
            tension: 0.4
          },
          {
            label: 'Upload (KB/s)',
            borderColor: '#10B981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            data: [],
            fill: true,
            tension: 0.4
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: { duration: 0 },
        scales: {
          x: { display: false },
          y: { beginAtZero: true, suggestedMax: 100 }
        },
        plugins: {
          legend: {
            labels: { color: 'var(--gray-400)' }
          }
        }
      }
    });
  }


  // ──────────────────────────────────────────────
  // INITIAL STATE
  // ──────────────────────────────────────────────
  const activeNav = document.querySelector('.sidebar-nav-item.active[data-view]');
  const initialView = activeNav ? activeNav.getAttribute('data-view') : 'live';
  switchView(initialView || 'live', activeNav);
  updateDashboardStats();
});
