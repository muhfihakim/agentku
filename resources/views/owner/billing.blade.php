<x-layouts.app>
    <section class="view view-dashboard">
        <div class="page-header">
            <h1 class="page-title">Billing & Paket</h1>
            <p class="page-subtitle">Kelola langganan dan paket untuk SaaS Anda</p>
        </div>

        <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <div class="stat-card stat-card--blue">
                <div class="stat-card-header">
                    <span class="stat-card-label">Total Paket</span>
                    <div class="stat-card-icon blue">
                        <i class="ph ph-list-numbers"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $totalPlans }}</div>
                <div class="stat-card-change neutral">
                    <i class="ph ph-minus"></i>
                    <span>Semua Paket</span>
                </div>
            </div>

            <div class="stat-card stat-card--green">
                <div class="stat-card-header">
                    <span class="stat-card-label">Paket Aktif</span>
                    <div class="stat-card-icon green">
                        <i class="ph ph-check-circle"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $totalActive }}</div>
                <div class="stat-card-change positive">
                    <i class="ph ph-arrow-up"></i>
                    <span>Tersedia untuk Client</span>
                </div>
            </div>

            <div class="stat-card stat-card--yellow">
                <div class="stat-card-header">
                    <span class="stat-card-label">Paket Draft</span>
                    <div class="stat-card-icon" style="background: #fef3c7; color: #d97706;">
                        <i class="ph ph-warning-circle"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $totalDraft }}</div>
                <div class="stat-card-change negative">
                    <i class="ph ph-arrow-down"></i>
                    <span>Belum Tersedia</span>
                </div>
            </div>
        </div>

        <!-- Filter & Search Card -->
        <div class="card" style="margin-top: 2rem; margin-bottom: 1rem; padding: 1rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 250px; display: flex; gap: 1rem;">
                    <div style="position: relative; flex: 1;">
                        <i class="ph ph-magnifying-glass"
                            style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                        <input type="text" id="searchInput" placeholder="Cari paket..."
                            style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.5rem 0.75rem 0.5rem 2.5rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;">
                    </div>
                    <div style="width: 200px;">
                        <select id="filterStatus"
                            style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.5rem 0.75rem; border-radius:0.5rem; color:#111827; box-sizing: border-box; cursor:pointer;">
                            <option value="all">Status (Semua)</option>
                            <option value="aktif">Aktif</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>
                <div>
                    <button onclick="openModal()" class="btn btn-primary btn-sm">
                        <i class="ph ph-plus"></i> Tambah Paket
                    </button>
                </div>
            </div>
        </div>

        <div class="card" style="position: relative; overflow: hidden;">
            <div id="loadingBar"
                style="display: none; position: absolute; top: 0; left: 0; height: 3px; background: #3b82f6; width: 100%; animation: loading 1s linear infinite;">
            </div>
            <div class="card-header">
                <h2 class="card-title">Daftar Paket Harga (<span id="totalData">{{ $plans->total() }}</span>)</h2>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Paket</th>
                            <th>Harga</th>
                            <th>Periode</th>
                            <th>Limit Agen</th>
                            <th>Client Terdaftar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="planTableBody">
                        @if ($plans->isEmpty())
                            <tr>
                                <td colspan="8" class="empty-state-td" style="color: #6b7280; text-align: center; padding: 2rem;">
                                    Data tidak ditemukan
                                </td>
                            </tr>
                        @else
                            @php $start = ($plans->currentPage() - 1) * $plans->perPage() + 1; @endphp
                            @foreach ($plans as $index => $plan)
                                <tr>
                                    <td>{{ $start + $index }}</td>
                                    <td>{{ $plan->name }}</td>
                                    <td>Rp {{ number_format($plan->price, 0, ',', '.') }}</td>
                                    <td>{{ $plan->duration_days }} Hari</td>
                                    <td>{{ $plan->agent_limit }} Agen</td>
                                    <td><span style="font-weight: 500; color: #3b82f6;">{{ $tenantCounts[$plan->id] ?? 0 }} Client</span></td>
                                    <td>
                                        @if ($plan->status == 'aktif')
                                            <span class="badge badge-active">Aktif</span>
                                        @else
                                            <span class="badge"
                                                style="background:#fef3c7; color:#d97706;">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button
                                            onclick="openEditModal('{{ $plan->id }}', '{{ htmlspecialchars($plan->name, ENT_QUOTES) }}', '{{ $plan->price }}', '{{ $plan->agent_limit }}', '{{ $plan->duration_days }}', '{{ $plan->status }}')"
                                            class="btn btn-ghost btn-sm" style="color: #10b981;" title="Edit"><i
                                                class="ph ph-pencil-simple"></i> Edit</button>
                                        <button onclick="confirmDelete('{{ $plan->id }}')"
                                            class="btn btn-ghost btn-sm" style="color: #ef4444;" title="Hapus"><i
                                                class="ph ph-trash"></i> Hapus</button>
                                        <form id="delete-form-{{ $plan->id }}"
                                            action="{{ route('owner.plans.destroy', $plan->id) }}" method="POST"
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
                {{ $plans->links('components.pagination') }}
            </div>
        </div>

        <!-- Add/Edit Plan Modal -->
        <div id="planModal" class="modal-overlay">
            <div class="modal-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 id="modalTitle" style="margin:0; font-size: 1.25rem; font-weight: 600; color: #111827;">Tambah Paket Baru</h3>
                    <button type="button" onclick="closePlanModal()"
                        style="background:transparent; border:none; color:#6b7280; cursor:pointer; font-size:1.5rem;"><i
                            class="ph ph-x"></i></button>
                </div>

                <form id="planForm" action="{{ route('owner.plans.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    
                    <div style="margin-bottom: 1rem;">
                        <label
                            style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Nama Paket</label>
                        <div style="position: relative;">
                            <i class="ph ph-tag"
                                style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="text" id="planName" name="name" required
                                style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;"
                                placeholder="Misal: Basic Plan">
                        </div>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label
                            style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Harga</label>
                        <div style="position: relative;">
                            <i class="ph ph-money"
                                style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="number" id="planPrice" name="price" required min="0" step="1000"
                                style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;"
                                placeholder="0">
                        </div>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label
                            style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Limit Agen</label>
                        <div style="position: relative;">
                            <i class="ph ph-users"
                                style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="number" id="planLimit" name="agent_limit" required min="1"
                                style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;"
                                placeholder="50">
                        </div>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Periode Paket</label>
                        <div style="position: relative;">
                            <i class="ph ph-calendar" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <select id="planDuration" name="duration_days" required style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box; cursor: pointer; appearance: none;">
                                <option value="3">3 Hari (Trial)</option>
                                <option value="30" selected>30 Hari (1 Bulan)</option>
                                <option value="90">90 Hari (3 Bulan)</option>
                                <option value="180">180 Hari (6 Bulan)</option>
                                <option value="365">365 Hari (1 Tahun)</option>
                            </select>
                        </div>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Status</label>
                        <div style="position: relative;">
                            <i class="ph ph-toggle-left" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <select id="planStatus" name="status" required style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box; cursor: pointer; appearance: none;">
                                <option value="aktif">Aktif</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                        <button type="button" onclick="closePlanModal()" class="btn btn-ghost"
                            style="color: #4b5563; background: #f3f4f6; border: 1px solid #e5e7eb; padding: 0.5rem 1.5rem;">Batal</button>
                        <button type="submit" id="submitBtn" class="btn btn-primary"
                            style="padding: 0.5rem 1.5rem;">
                            <i class="ph ph-check-circle"></i> Simpan Paket
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Confirm Delete Modal -->
        <div id="deleteModal" class="modal-overlay">
            <div class="modal-content" style="max-width: 400px; text-align: center;">
                <div style="color: #ef4444; font-size: 3rem; margin-bottom: 1rem;">
                    <i class="ph ph-warning-circle"></i>
                </div>
                <h3 style="margin:0 0 0.5rem 0; font-size: 1.25rem; font-weight: 600; color: #111827;">Hapus Paket?
                </h3>
                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1.5rem;">Data paket yang dihapus tidak
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
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1000;
                opacity: 0;
                visibility: hidden;
                transition: all 0.2s ease-in-out;
            }

            .modal-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            .modal-content {
                background: white;
                padding: 2rem;
                border-radius: 1rem;
                width: 100%;
                max-width: 500px;
                transform: scale(0.95) translateY(10px);
                transition: all 0.2s ease-in-out;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            .modal-overlay.active .modal-content {
                transform: scale(1) translateY(0);
            }

            @keyframes loading {
                0% {
                    margin-left: -100%;
                }
                100% {
                    margin-left: 100%;
                }
            }
        </style>
        @endpush

        @push('scripts')
            <script>
                function openModal() {
                    document.getElementById('modalTitle').innerText = 'Tambah Paket Baru';
                    document.getElementById('planForm').action = '{{ route('owner.plans.store') }}';
                    document.getElementById('formMethod').value = 'POST';

                    document.getElementById('planName').value = '';
                    document.getElementById('planPrice').value = '';
                    document.getElementById('planLimit').value = '';
                    document.getElementById('planDuration').value = '30';
                    document.getElementById('planStatus').value = 'aktif';

                    document.getElementById('submitBtn').innerHTML = '<i class="ph ph-check-circle"></i> Simpan Paket';
                    document.getElementById('submitBtn').className = 'btn btn-primary';
                    document.getElementById('submitBtn').style = 'padding: 0.5rem 1.5rem;';

                    document.getElementById('planModal').classList.add('active');
                }

                function closePlanModal() {
                    document.getElementById('planModal').classList.remove('active');
                }

                document.getElementById('planModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        closePlanModal();
                    }
                });

                // Edit Modal Logic
                function openEditModal(id, name, price, limit, duration, status) {
                    document.getElementById('modalTitle').innerText = 'Edit Paket';
                    document.getElementById('planForm').action = '/owner/plans/' + id;
                    document.getElementById('formMethod').value = 'PUT';

                    document.getElementById('planName').value = name;
                    document.getElementById('planPrice').value = price;
                    document.getElementById('planLimit').value = limit;
                    document.getElementById('planDuration').value = duration;
                    document.getElementById('planStatus').value = status;

                    document.getElementById('submitBtn').innerHTML = '<i class="ph ph-check-circle"></i> Update Paket';
                    document.getElementById('submitBtn').className = 'btn btn-success';
                    document.getElementById('submitBtn').style = 'padding: 0.5rem 1.5rem;';

                    document.getElementById('planModal').classList.add('active');
                }

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
                const filterStatus = document.getElementById('filterStatus');
                const tableBody = document.getElementById('planTableBody');
                const paginationContainer = document.getElementById('paginationContainer');
                const totalDataSpan = document.getElementById('totalData');
                const loadingBar = document.getElementById('loadingBar');

                function fetchPlans(url) {
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
                    const status = filterStatus.value;
                    const url = new URL(window.location.href);
                    url.searchParams.set('search', query);
                    url.searchParams.set('status', status);
                    url.searchParams.set('page', page);
                    window.history.pushState({}, '', url);
                    fetchPlans(url);
                }

                searchInput.addEventListener('input', function(e) {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        triggerFilter(1);
                    }, 500); // 500ms debounce
                });

                filterStatus.addEventListener('change', function(e) {
                    triggerFilter(1);
                });

                // Handle Pagination Clicks
                paginationContainer.addEventListener('click', function(e) {
                    e.preventDefault();
                    const link = e.target.closest('a');
                    if (link) {
                        const url = link.getAttribute('href');
                        window.history.pushState({}, '', url);
                        fetchPlans(url);
                    }
                });
            </script>
        @endpush
    </section>
</x-layouts.app>
