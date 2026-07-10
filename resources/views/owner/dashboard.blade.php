<x-layouts.app>

    @push('styles')
        <style>
            .btn-success {
                background: #10b981;
                color: #fff;
                border-color: #10b981;
            }
            .btn-success:hover {
                background: #059669;
                border-color: #059669;
                box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
            }

            .modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(3px);
                z-index: 999;
                padding: 1rem;
                box-sizing: border-box;
                overflow-y: auto;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease, visibility 0.3s ease;
            }

            .modal-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            .modal-content {
                background: white;
                border: 1px solid #e5e7eb;
                border-radius: 1rem;
                width: 100%;
                max-width: 500px;
                margin: 2rem auto;
                padding: 1.5rem;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                box-sizing: border-box;
                transform: scale(0.95) translateY(-10px);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .modal-overlay.active .modal-content {
                transform: scale(1) translateY(0);
            }

            @keyframes loading {
                0% {
                    width: 0%;
                    margin-left: 0%;
                }

                50% {
                    width: 50%;
                    margin-left: 25%;
                }

                100% {
                    width: 0%;
                    margin-left: 100%;
                }
            }
        </style>
    @endpush

    <section class="view view-dashboard">
        <div class="page-header">
            <h1 class="page-title">SaaS Owner Dashboard</h1>
            <p class="page-subtitle">Kelola semua Tenant dan Billing di sini</p>
        </div>



        <div class="stats-grid"
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <div class="stat-card stat-card--blue">
                <div class="stat-card-header">
                    <span class="stat-card-label">Total Client</span>
                    <div class="stat-card-icon blue">
                        <i class="ph ph-buildings"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $totalClient }}</div>
                <div class="stat-card-change positive">
                    <i class="ph ph-arrow-up"></i>
                    <span>All Clients</span>
                </div>
            </div>

            <div class="stat-card stat-card--green">
                <div class="stat-card-header">
                    <span class="stat-card-label">Total Lunas</span>
                    <div class="stat-card-icon green">
                        <i class="ph ph-check-circle"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $totalLunas }}</div>
                <div class="stat-card-change positive">
                    <i class="ph ph-arrow-up"></i>
                    <span>Active Billing</span>
                </div>
            </div>

            <div class="stat-card stat-card--yellow">
                <div class="stat-card-header">
                    <span class="stat-card-label">Total Ditangguhkan</span>
                    <div class="stat-card-icon" style="background: #fef3c7; color: #d97706;">
                        <i class="ph ph-warning-circle"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $totalDitangguhkan }}</div>
                <div class="stat-card-change negative">
                    <i class="ph ph-arrow-down"></i>
                    <span>Needs Attention</span>
                </div>
            </div>
        </div>

        <!-- Filter & Search Card -->
        <div class="card" style="margin-top: 2rem; margin-bottom: 1rem; padding: 1rem;">
            <div
                style="display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 250px; display: flex; gap: 1rem;">
                    <div style="position: relative; flex: 1;">
                        <i class="ph ph-magnifying-glass"
                            style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                        <input type="text" id="searchInput" placeholder="Cari client..."
                            style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.5rem 0.75rem 0.5rem 2.5rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;">
                    </div>
                    <div style="width: 200px;">
                        <select id="filterBilling"
                            style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.5rem 0.75rem; border-radius:0.5rem; color:#111827; box-sizing: border-box; cursor:pointer;">
                            <option value="all">Status Billing (Semua)</option>
                            <option value="lunas">Lunas</option>
                            <option value="ditangguhkan">Ditangguhkan</option>
                        </select>
                    </div>
                    <div style="width: 200px;">
                        <select id="filterAccountStatus"
                            style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.5rem 0.75rem; border-radius:0.5rem; color:#111827; box-sizing: border-box; cursor:pointer;">
                            <option value="all">Status Akun (Semua)</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div>
                    <button onclick="openModal()" class="btn btn-primary btn-sm">
                        <i class="ph ph-plus"></i> Tambah Client
                    </button>
                </div>
            </div>
        </div>

        <div class="card" style="position: relative; overflow: hidden;">
            <div id="loadingBar"
                style="display: none; position: absolute; top: 0; left: 0; height: 3px; background: #3b82f6; width: 100%; animation: loading 1s linear infinite;">
            </div>
            <div class="card-header">
                <h2 class="card-title">Daftar Client (<span id="totalData">{{ $tenants->total() }}</span>)</h2>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Tenant</th>
                            <th>Nama Perusahaan</th>
                            <th>Email Admin</th>
                            <th>Paket</th>
                            <th>Status Akun</th>
                            <th>Status Billing</th>
                            <th>Masa Aktif</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tenantTableBody">
                        @if ($tenants->isEmpty())
                            <tr>
                                <td colspan="8" class="empty-state-td" style="color: #6b7280;">
                                    <i class="ph ph-folder-open"
                                        style="font-size: 2.5rem; color: #9ca3af;"></i>
                                    Data tidak ditemukan
                                </td>
                            </tr>
                        @else
                            @php 
                                $start = ($tenants->currentPage() - 1) * $tenants->perPage() + 1; 
                                $plansList = collect($availablePlans)->keyBy('id');
                            @endphp
                            @foreach ($tenants as $index => $tenant)
                                <tr>
                                    <td>{{ $start + $index }}</td>
                                    <td>{{ $tenant->id }}</td>
                                    <td>{{ $tenant->company_name ?? 'N/A' }}</td>
                                    <td>{{ $tenant->user->email ?? 'N/A' }}</td>
                                    <td>
                                        @php $planName = isset($tenant->plan_id) && isset($plansList[$tenant->plan_id]) ? $plansList[$tenant->plan_id]->name : 'Belum Ada'; @endphp
                                        <span class="badge" style="background:#f3f4f6; color:#4b5563;">{{ $planName }}</span>
                                    </td>
                                    <td>
                                        @if (($tenant->account_status ?? 'aktif') == 'aktif')
                                            <span class="badge badge-active">Aktif</span>
                                        @else
                                            <span class="badge"
                                                style="background:#fee2e2; color:#ef4444;">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (($tenant->billing_status ?? 'lunas') == 'lunas')
                                            <span class="badge badge-active">Lunas</span>
                                        @else
                                            <span class="badge"
                                                style="background:#fef3c7; color:#d97706;">Ditangguhkan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span style="color: #4b5563; font-weight: 500;">
                                            {{ isset($tenant->billing_end_date) ? \Carbon\Carbon::parse($tenant->billing_end_date)->format('d M Y') : '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <button
                                            onclick="openDetailModal('{{ $tenant->id }}', '{{ htmlspecialchars($tenant->company_name ?? 'N/A', ENT_QUOTES) }}', '{{ \Carbon\Carbon::parse($tenant->created_at)->format('d M Y') }}')"
                                            class="btn btn-ghost btn-sm" style="color: #3b82f6;" title="Detail"><i
                                                class="ph ph-eye"></i> Detail</button>
                                        <button
                                            onclick="openEditModal('{{ $tenant->id }}', '{{ htmlspecialchars($tenant->company_name ?? '', ENT_QUOTES) }}', '{{ $tenant->account_status ?? 'aktif' }}', '{{ $tenant->plan_id ?? '' }}')"
                                            class="btn btn-ghost btn-sm" style="color: #10b981;" title="Edit"><i
                                                class="ph ph-pencil-simple"></i> Edit</button>
                                        <button onclick="confirmDelete('{{ $tenant->id }}')"
                                            class="btn btn-ghost btn-sm" style="color: #ef4444;" title="Hapus"><i
                                                class="ph ph-trash"></i> Hapus</button>
                                        <form id="delete-form-{{ $tenant->id }}"
                                            action="{{ route('owner.tenants.destroy', $tenant->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div id="paginationContainer"
                style="padding: 1rem; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end;">
                {{ $tenants->links('components.pagination') }}
            </div>
        </div>

        <!-- Add/Edit Client Modal -->
        <div id="clientModal" class="modal-overlay">
            <div class="modal-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 id="modalTitle" style="margin:0; font-size: 1.25rem; font-weight: 600; color: #111827;">Tambah
                        Client Baru</h3>
                    <button type="button" onclick="closeClientModal()"
                        style="background:transparent; border:none; color:#6b7280; cursor:pointer; font-size:1.5rem;"><i
                            class="ph ph-x"></i></button>
                </div>

                <form id="clientForm" action="{{ route('owner.tenants.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div style="margin-bottom: 1rem;" id="idContainer">
                        <label id="idLabel"
                            style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">ID
                            Tenant (Tanpa Spasi)</label>
                        <div style="position: relative;">
                            <i class="ph ph-identification-card"
                                style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="text" id="clientId" name="id" required
                                style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;"
                                placeholder="misal: perusahaan1">
                        </div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label
                            style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Nama
                            Perusahaan</label>
                        <div style="position: relative;">
                            <i class="ph ph-buildings"
                                style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="text" id="clientCompanyName" name="company_name" required
                                style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;"
                                placeholder="PT. Perusahaan Satu">
                        </div>
                    </div>
                    <div style="margin-bottom: 1rem;" id="emailContainer">
                        <label
                            style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Email
                            Admin Client</label>
                        <div style="position: relative;">
                            <i class="ph ph-envelope-simple"
                                style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="email" id="clientEmail" name="admin_email" required
                                style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;"
                                placeholder="admin@perusahaan.com">
                        </div>
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label id="passwordLabel"
                            style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Password
                            Admin</label>
                        <div style="position: relative;">
                            <i class="ph ph-lock-key"
                                style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="password" id="clientPassword" name="admin_password" required minlength="6"
                                style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;"
                                placeholder="••••••••">
                        </div>
                    </div>
                    <div style="margin-bottom: 1.5rem;" id="accountStatusContainer">
                        <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Status Akun</label>
                        <div style="position: relative;">
                            <i class="ph ph-toggle-left" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <select id="clientAccountStatus" name="account_status" required style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box; cursor: pointer; appearance: none;">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div style="margin-bottom: 1.5rem;" id="planContainer">
                        <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Pilih Paket (Opsional)</label>
                        <div style="position: relative;">
                            <i class="ph ph-list-numbers" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <select id="clientPlanId" name="plan_id" style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box; cursor: pointer; appearance: none;">
                                <option value="">Pilih Paket...</option>
                                @foreach($availablePlans as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->name }} (Rp {{ number_format($plan->price, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                        <button type="button" onclick="closeClientModal()" class="btn btn-ghost"
                            style="color: #4b5563; background: #f3f4f6; border: 1px solid #e5e7eb; padding: 0.5rem 1.5rem;">
                            <i class="ph ph-x"></i> Batal
                        </button>
                        <button type="submit" id="submitBtn" class="btn btn-primary"
                            style="padding: 0.5rem 1.5rem;">
                            <i class="ph ph-check-circle"></i> Simpan Client
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Detail Client Modal -->
        <div id="detailClientModal" class="modal-overlay">
            <div class="modal-content" style="max-width: 450px;">
                <div
                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="margin:0; font-size: 1.25rem; font-weight: 600; color: #111827;">Detail Client</h3>
                    <button type="button" onclick="closeDetailModal()"
                        style="background:transparent; border:none; color:#6b7280; cursor:pointer; font-size:1.5rem;"><i
                            class="ph ph-x"></i></button>
                </div>

                <div
                    style="margin-bottom: 1rem; padding: 1rem; background: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
                    <div style="margin-bottom: 0.75rem;">
                        <span
                            style="display:block; font-size: 0.75rem; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 0.25rem;">ID
                            Tenant</span>
                        <div id="detail_id" style="font-size: 1rem; color: #111827; font-weight: 500;">-</div>
                    </div>
                    <div style="margin-bottom: 0.75rem;">
                        <span
                            style="display:block; font-size: 0.75rem; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 0.25rem;">Nama
                            Perusahaan</span>
                        <div id="detail_company_name" style="font-size: 1rem; color: #111827; font-weight: 500;">-
                        </div>
                    </div>
                    <div style="margin-bottom: 0.75rem;">
                        <span
                            style="display:block; font-size: 0.75rem; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 0.25rem;">Status
                            Billing</span>
                        <div><span class="badge badge-active">Lunas</span></div>
                    </div>
                    <div>
                        <span
                            style="display:block; font-size: 0.75rem; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 0.25rem;">Dibuat
                            Pada</span>
                        <div id="detail_created_at" style="font-size: 1rem; color: #111827; font-weight: 500;">-</div>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                    <button type="button" onclick="closeDetailModal()" class="btn btn-primary"
                        style="padding: 0.5rem 1.5rem;">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <!-- Confirm Delete Modal -->
        <div id="deleteModal" class="modal-overlay">
            <div class="modal-content" style="max-width: 400px; text-align: center;">
                <div style="color: #ef4444; font-size: 3rem; margin-bottom: 1rem;">
                    <i class="ph ph-warning-circle"></i>
                </div>
                <h3 style="margin:0 0 0.5rem 0; font-size: 1.25rem; font-weight: 600; color: #111827;">Hapus Client?
                </h3>
                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1.5rem;">Data client yang dihapus tidak
                    bisa dikembalikan. Yakin?</p>
                <div style="display: flex; justify-content: center; gap: 1rem;">
                    <button type="button" onclick="closeDeleteModal()" class="btn btn-ghost"
                        style="color: #4b5563; background: #f3f4f6; border: 1px solid #e5e7eb; padding: 0.5rem 1.5rem;">
                        <i class="ph ph-x"></i> Batal
                    </button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-primary"
                        style="background: #ef4444; color: white; padding: 0.5rem 1.5rem; border: none;">
                        <i class="ph ph-trash"></i> Ya, Hapus
                    </button>
                </div>
            </div>
        </div>


        @push('scripts')
            <script>
                function openModal() {
                    document.getElementById('modalTitle').innerText = 'Tambah Client Baru';
                    document.getElementById('clientForm').action = '{{ route('owner.tenants.store') }}';
                    document.getElementById('formMethod').value = 'POST';

                    document.getElementById('idContainer').style.display = 'block';
                    document.getElementById('clientId').readOnly = false;
                    document.getElementById('clientId').value = '';
                    document.getElementById('clientId').style.background = '#f9fafb';
                    document.getElementById('clientId').style.cursor = 'text';

                    document.getElementById('emailContainer').style.display = 'block';
                    document.getElementById('clientEmail').required = true;

                    document.getElementById('clientCompanyName').value = '';

                    document.getElementById('passwordLabel').innerText = 'Password Admin';
                    document.getElementById('clientPassword').required = true;
                    document.getElementById('clientPassword').value = '';

                    document.getElementById('accountStatusContainer').style.display = 'block';
                    document.getElementById('clientAccountStatus').value = 'aktif';

                    document.getElementById('clientPlanId').value = '';

                    document.getElementById('submitBtn').innerHTML = '<i class="ph ph-check-circle"></i> Simpan Client';
                    document.getElementById('submitBtn').className = 'btn btn-primary';
                    document.getElementById('submitBtn').style = 'padding: 0.5rem 1.5rem;';

                    document.getElementById('clientModal').classList.add('active');
                }

                function closeClientModal() {
                    document.getElementById('clientModal').classList.remove('active');
                }

                document.getElementById('clientModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeClientModal();
                    }
                });

                // Edit Modal Logic
                function openEditModal(id, companyName, accountStatus, planId) {
                    document.getElementById('modalTitle').innerText = 'Edit Client';
                    document.getElementById('clientForm').action = '/owner/tenants/' + id;
                    document.getElementById('formMethod').value = 'PUT';

                    document.getElementById('idContainer').style.display = 'block';
                    document.getElementById('clientId').value = id;
                    document.getElementById('clientId').readOnly = true;
                    document.getElementById('clientId').style.background = '#e5e7eb';
                    document.getElementById('clientId').style.cursor = 'not-allowed';

                    document.getElementById('emailContainer').style.display = 'none';
                    document.getElementById('clientEmail').required = false;

                    document.getElementById('clientCompanyName').value = companyName;

                    document.getElementById('accountStatusContainer').style.display = 'block';
                    document.getElementById('clientAccountStatus').value = accountStatus || 'aktif';

                    document.getElementById('clientPlanId').value = planId || '';

                    document.getElementById('passwordLabel').innerText = 'Password Admin Baru (Opsional)';
                    document.getElementById('clientPassword').required = false;
                    document.getElementById('clientPassword').value = '';

                    document.getElementById('submitBtn').innerHTML = '<i class="ph ph-check-circle"></i> Update Client';
                    document.getElementById('submitBtn').className = 'btn btn-success';
                    document.getElementById('submitBtn').style = 'padding: 0.5rem 1.5rem;';

                    document.getElementById('clientModal').classList.add('active');
                }

                // Detail Modal Logic
                function openDetailModal(id, companyName, createdAt) {
                    document.getElementById('detail_id').innerText = id;
                    document.getElementById('detail_company_name').innerText = companyName;
                    document.getElementById('detail_created_at').innerText = createdAt;
                    document.getElementById('detailClientModal').classList.add('active');
                }

                function closeDetailModal() {
                    document.getElementById('detailClientModal').classList.remove('active');
                }
                document.getElementById('detailClientModal').addEventListener('click', function(e) {
                    if (e.target === this) closeDetailModal();
                });

                // Delete Modal Logic
                let deleteId = null;

                function confirmDelete(id) {
                    deleteId = id;
                    document.getElementById('deleteModal').classList.add('active');
                }

                function closeDeleteModal() {
                    document.getElementById('deleteModal').classList.remove('active');
                    deleteId = null;
                }
                document.getElementById('deleteModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeDeleteModal();
                    }
                });
                document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                    if (deleteId) {
                        document.getElementById('delete-form-' + deleteId).submit();
                    }
                });

                // LiveSearch & Pagination AJAX
                let searchTimeout = null;
                const searchInput = document.getElementById('searchInput');
                const filterBilling = document.getElementById('filterBilling');
                const filterAccountStatus = document.getElementById('filterAccountStatus');
                const tableBody = document.getElementById('tenantTableBody');
                const paginationContainer = document.getElementById('paginationContainer');
                const totalDataSpan = document.getElementById('totalData');
                const loadingBar = document.getElementById('loadingBar');

                function fetchTenants(url) {
                    loadingBar.style.display = 'block';
                    fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            tableBody.innerHTML = data.html;
                            paginationContainer.innerHTML = data.pagination;
                            totalDataSpan.innerText = data.total;
                        })
                        .catch(err => console.error(err))
                        .finally(() => {
                            loadingBar.style.display = 'none';
                        });
                }

                function triggerFilter(page = 1) {
                    const query = searchInput.value;
                    const billing = filterBilling.value;
                    const accStatus = filterAccountStatus.value;
                    const url = new URL(window.location.href);
                    url.searchParams.set('search', query);
                    url.searchParams.set('billing_status', billing);
                    url.searchParams.set('account_status', accStatus);
                    url.searchParams.set('page', page);
                    window.history.pushState({}, '', url);
                    fetchTenants(url);
                }

                searchInput.addEventListener('input', function(e) {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        triggerFilter(1);
                    }, 500); // 500ms debounce supaya aman ke server
                });

                filterBilling.addEventListener('change', function(e) {
                    triggerFilter(1);
                });
                
                filterAccountStatus.addEventListener('change', function(e) {
                    triggerFilter(1);
                });

                // Handle Pagination Clicks
                paginationContainer.addEventListener('click', function(e) {
                    e.preventDefault();
                    const link = e.target.closest('a');
                    if (link) {
                        const url = link.getAttribute('href');
                        window.history.pushState({}, '', url);
                        fetchTenants(url);
                    }
                });
            </script>
        @endpush
    </section>
</x-layouts.app>
