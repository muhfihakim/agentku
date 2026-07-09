<x-layouts.app>
    <section class="view view-dashboard">
        <div class="page-header">
            <h1 class="page-title">Billing & Paket</h1>
            <p class="page-subtitle">Kelola langganan dan paket untuk SaaS Anda</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card stat-card--green">
                <div class="stat-card-header">
                    <span class="stat-card-label">Total Pendapatan Bulan Ini</span>
                    <div class="stat-card-icon green">
                        <i class="ph ph-money"></i>
                    </div>
                </div>
                <div class="stat-card-value">Rp 12.500.000</div>
                <div class="stat-card-change positive">
                    <i class="ph ph-arrow-up"></i>
                    <span>+15% dari bulan lalu</span>
                </div>
            </div>
            
            <div class="stat-card stat-card--blue">
                <div class="stat-card-header">
                    <span class="stat-card-label">Client Aktif</span>
                    <div class="stat-card-icon blue">
                        <i class="ph ph-users"></i>
                    </div>
                </div>
                <div class="stat-card-value">12</div>
                <div class="stat-card-change neutral">
                    <i class="ph ph-minus"></i>
                    <span>Stabil</span>
                </div>
            </div>

            <div class="stat-card stat-card--yellow">
                <div class="stat-card-header">
                    <span class="stat-card-label">Tagihan Tertunda</span>
                    <div class="stat-card-icon yellow">
                        <i class="ph ph-clock"></i>
                    </div>
                </div>
                <div class="stat-card-value">2</div>
                <div class="stat-card-change negative">
                    <i class="ph ph-warning-circle"></i>
                    <span>Butuh Follow Up</span>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: 2rem;">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h2 class="card-title">Daftar Paket Harga (Plans)</h2>
                <button class="btn btn-primary btn-sm">
                    <i class="ph ph-plus"></i> Tambah Paket
                </button>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Paket</th>
                            <th>Harga / Bulan</th>
                            <th>Limit Agen</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Basic Plan</td>
                            <td>Rp 500.000</td>
                            <td>50 Agen</td>
                            <td><span class="badge badge-active">Aktif</span></td>
                            <td>
                                <button class="btn btn-ghost btn-sm"><i class="ph ph-pencil-simple"></i> Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Pro Plan</td>
                            <td>Rp 1.000.000</td>
                            <td>150 Agen</td>
                            <td><span class="badge badge-active">Aktif</span></td>
                            <td>
                                <button class="btn btn-ghost btn-sm"><i class="ph ph-pencil-simple"></i> Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Enterprise</td>
                            <td>Custom</td>
                            <td>Unlimited</td>
                            <td><span class="badge badge-idle">Draft</span></td>
                            <td>
                                <button class="btn btn-ghost btn-sm"><i class="ph ph-pencil-simple"></i> Edit</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-layouts.app>
