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
    detail: document.querySelector('.view-detail'),
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
  // 3. LIVE SCREEN CARDS — VIEW DETAIL
  // ──────────────────────────────────────────────
  const monitorGrid = document.getElementById('monitorGrid');

  const showCardDetail = (card) => {
    const name = card.getAttribute('data-name') || card.querySelector('.screen-card-name')?.textContent || 'Unknown';
    const dept = card.querySelector('.screen-card-dept')?.textContent || '';
    const status = card.getAttribute('data-status') || 'active';
    const osEl = card.querySelector('.screen-card-os');
    const os = osEl ? osEl.textContent.trim() : '';

    const detailView = views.detail;
    if (!detailView) return;

    // Update employee header
    const detailName = detailView.querySelector('.detail-employee-name');
    const detailDept = detailView.querySelector('.detail-employee-dept');
    const detailBadge = detailView.querySelector('.detail-employee-header .badge');

    if (detailName) detailName.textContent = name;
    if (detailDept) detailDept.textContent = dept;
    if (detailBadge) {
      detailBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
      detailBadge.className = `badge badge-${status}`;
    }

    // Update avatar initials
    const avatar = detailView.querySelector('.detail-employee-avatar');
    if (avatar) {
      const initials = name.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
      avatar.textContent = initials;
    }

    // Mirror screen gradient
    const cardThumb = card.querySelector('.screen-thumb');
    const detailViewer = detailView.querySelector('.detail-screen-viewer');
    if (cardThumb && detailViewer) {
      const bg = cardThumb.style.background;
      if (bg) detailViewer.style.background = bg;
    }

    switchView('detail');
    animateProgressBars();
  };

  // Event delegation on the monitor grid
  if (monitorGrid) {
    monitorGrid.addEventListener('click', (e) => {
      const btn = e.target.closest('.view-detail-btn');
      if (btn) {
        const card = btn.closest('.screen-card');
        if (card) showCardDetail(card);
      }
    });
  }

  // ──────────────────────────────────────────────
  // 4. DETAIL VIEW BACK BUTTON
  // ──────────────────────────────────────────────
  const detailBackBtn = document.getElementById('backToLive');
  if (detailBackBtn) {
    detailBackBtn.addEventListener('click', () => {
      const liveNav = document.querySelector('.sidebar-nav-item[data-view="live"]');
      switchView('live', liveNav);
    });
  }

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
      window.echoInstance = new Echo({
          broadcaster: 'reverb',
          key: 'agenkukey',
          wsHost: '127.0.0.1',
          wsPort: 8080,
          wssPort: 8080,
          forceTLS: false,
          enabledTransports: ['ws', 'wss'],
      });
  }

  const simulateStatusUpdates = () => {
    if (!window.echoInstance) return;
    window.echoInstance.channel("agents")
      .listen("AgentDataReceived", async (e) => {
        const data = e.data;
        if (data && data.user && monitorGrid) {
          
          // Find or create card
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
                <button class="btn btn-sm btn-primary view-detail-btn">View Detail</button>
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
            const res = await fetch("/api/monitor");
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
          if (osEl) osEl.innerHTML = '<i class="ph ph-apple-logo"></i> ' + data.device;
          
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
  // INITIAL STATE
  // ──────────────────────────────────────────────
  const activeNav = document.querySelector('.sidebar-nav-item.active[data-view]');
  const initialView = activeNav ? activeNav.getAttribute('data-view') : 'live';
  switchView(initialView || 'live', activeNav);
  updateDashboardStats();
});
