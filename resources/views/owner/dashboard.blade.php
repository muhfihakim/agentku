<x-layouts.app>
    <section class="view view-dashboard">
        <div class="page-header">
            <h1 class="page-title">SaaS Owner Dashboard</h1>
            <p class="page-subtitle">Kelola semua Tenant dan Billing di sini</p>
        </div>

        @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="ph ph-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif
        @if($errors->any())
        <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #fca5a5; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="stats-grid">
            <div class="stat-card stat-card--blue">
                <div class="stat-card-header">
                    <span class="stat-card-label">Total Client</span>
                    <div class="stat-card-icon blue">
                        <i class="ph ph-buildings"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ count($tenants) }}</div>
                <div class="stat-card-change positive">
                    <i class="ph ph-arrow-up"></i>
                    <span>+1 bulan ini</span>
                </div>
            </div>
            
            <div class="stat-card stat-card--green">
                <div class="stat-card-header">
                    <span class="stat-card-label">Estimasi Revenue</span>
                    <div class="stat-card-icon green">
                        <i class="ph ph-currency-circle-dollar"></i>
                    </div>
                </div>
                <div class="stat-card-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="stat-card-change positive">
                    <i class="ph ph-arrow-up"></i>
                    <span>+10% vs last month</span>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: 2rem;">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h2 class="card-title">Daftar Client (Perusahaan)</h2>
                <button onclick="openModal()" class="btn btn-primary btn-sm">
                    <i class="ph ph-plus"></i> Tambah Client
                </button>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Tenant</th>
                            <th>Nama Perusahaan</th>
                            <th>Status Billing</th>
                            <th>Dibuat Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tenants as $tenant)
                        <tr>
                            <td>{{ $tenant->id }}</td>
                            <td>{{ $tenant->company_name ?? 'N/A' }}</td>
                            <td><span class="badge badge-active">Lunas</span></td>
                            <td>{{ $tenant->created_at->format('d M Y') }}</td>
                            <td>
                                <form action="{{ route('owner.tenants.destroy', $tenant->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus client ini? Semua data akan hilang.');" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-sm" style="color: #ef4444;"><i class="ph ph-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Client Modal -->
        <div id="addClientModal" class="modal-overlay">
            <div class="modal-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="margin:0; font-size: 1.25rem; font-weight: 600; color: #111827;">Tambah Client Baru</h3>
                    <button type="button" onclick="closeModal()" style="background:transparent; border:none; color:#6b7280; cursor:pointer; font-size:1.5rem;"><i class="ph ph-x"></i></button>
                </div>
                
                <form action="{{ route('owner.tenants.store') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 1rem;">
                        <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">ID Tenant (Tanpa Spasi)</label>
                        <div style="position: relative;">
                            <i class="ph ph-identification-card" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="text" name="id" required style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;" placeholder="misal: perusahaan1">
                        </div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Nama Perusahaan</label>
                        <div style="position: relative;">
                            <i class="ph ph-buildings" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="text" name="company_name" required style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;" placeholder="PT. Perusahaan Satu">
                        </div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Email Admin Client</label>
                        <div style="position: relative;">
                            <i class="ph ph-envelope-simple" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="email" name="admin_email" required style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;" placeholder="admin@perusahaan.com">
                        </div>
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Password Admin</label>
                        <div style="position: relative;">
                            <i class="ph ph-lock-key" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="password" name="admin_password" required minlength="6" style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;" placeholder="••••••••">
                        </div>
                    </div>
                    
                    <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                        <button type="button" onclick="closeModal()" class="btn btn-ghost" style="color: #4b5563; background: #f3f4f6; border: 1px solid #e5e7eb; padding: 0.5rem 1.5rem;">
                            <i class="ph ph-x"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1.5rem;">
                            <i class="ph ph-check-circle"></i> Simpan Client
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <style>
            .modal-overlay {
                position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.5); backdrop-filter: blur(3px);
                z-index: 999; padding: 1rem; box-sizing: border-box; overflow-y: auto;
                opacity: 0; visibility: hidden; transition: opacity 0.3s ease, visibility 0.3s ease;
            }
            .modal-overlay.active {
                opacity: 1; visibility: visible;
            }
            .modal-content {
                background: white; border: 1px solid #e5e7eb; border-radius: 1rem;
                width: 100%; max-width: 500px; margin: 2rem auto; padding: 1.5rem;
                box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
                box-sizing: border-box;
                transform: scale(0.95) translateY(-10px); transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .modal-overlay.active .modal-content {
                transform: scale(1) translateY(0);
            }
        </style>

        <script>
            function openModal() {
                document.getElementById('addClientModal').classList.add('active');
            }
            function closeModal() {
                document.getElementById('addClientModal').classList.remove('active');
            }

            // Close modal when clicking outside content
            document.getElementById('addClientModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });
        </script>
    </section>
</x-layouts.app>
