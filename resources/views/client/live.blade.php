<x-layouts.app>
    <div class="page-header">
        <h1 class="page-title">Layar Langsung</h1>
        <p class="page-subtitle">Pemantauan layar waktu nyata (real-time)</p>
    </div>

    <div class="card" style="margin-bottom: 1.5rem; border: none; box-shadow: none; background: transparent;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div style="display: flex; gap: 1rem; flex: 1; min-width: 300px;">
                <div style="position: relative; flex: 1; max-width: 400px;">
                    <i class="ph ph-magnifying-glass" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                    <input type="text" id="monitorSearch" placeholder="Cari karyawan..." style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.5rem 0.75rem 0.5rem 2.5rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;">
                </div>
                <div style="width: 200px;">
                    <select id="statusFilter" style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.5rem 0.75rem; border-radius:0.5rem; color:#111827; box-sizing: border-box; cursor:pointer;">
                        <option value="all">Semua Status</option>
                        <option value="active">Online</option>
                        <option value="idle">Menganggur</option>
                        <option value="offline">Luring</option>
                    </select>
                </div>
            </div>
            <div style="display: flex; gap: 0.5rem; align-items: center;">
                <div class="view-toggle" style="display: flex; background: white; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden; margin-right: 0.5rem;">
                    <button class="view-toggle-btn active" data-layout="grid" aria-label="Grid view" style="padding: 0.5rem 0.75rem; background: transparent; border: none; cursor: pointer; color: #4b5563;">
                        <i class="ph ph-squares-four"></i>
                    </button>
                    <button class="view-toggle-btn" data-layout="list" aria-label="List view" style="padding: 0.5rem 0.75rem; background: transparent; border: none; cursor: pointer; color: #4b5563; border-left: 1px solid #e5e7eb;">
                        <i class="ph ph-list"></i>
                    </button>
                </div>
                <a href="{{ global_asset('downloads/AgentKu_Setup.exe') }}" download class="btn btn-primary btn-sm" style="text-decoration: none;">
                    <i class="ph ph-download-simple"></i> Unduh Agen
                </a>
                <button class="btn btn-outline btn-sm" id="refreshBtn">
                    <i class="ph ph-arrow-clockwise"></i> Segarkan
                </button>
            </div>
        </div>
    </div>

    <div class="monitor-grid" id="monitorGrid">
        <!-- populated by js -->
    </div>
</x-layouts.app>
