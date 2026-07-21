<x-layouts.app>
    <section class="view view-dashboard">
        <div class="page-header">
            <h1 class="page-title">Departemen</h1>
            <p class="page-subtitle">Kelola departemen perusahaan</p>
        </div>


        <style>
            @keyframes loading {
                0% { transform: translateX(-100%); }
                100% { transform: translateX(100%); }
            }
        </style>



        <div class="card" style="margin-top: 2rem; margin-bottom: 1rem; padding: 1rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div style="display: flex; gap: 1rem; flex: 1; min-width: 300px;">
                    <div style="position: relative; flex: 1; max-width: 400px;">
                        <i class="ph ph-magnifying-glass"
                            style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                        <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Cari departemen..."
                            style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.5rem 0.75rem 0.5rem 2.5rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;">
                    </div>
                </div>
                <div>
                    <button type="button" onclick="openModal('addDepartmentModal')" class="btn btn-primary btn-sm">
                        <i class="ph ph-plus"></i> Tambah Departemen
                    </button>
                </div>
            </div>
        </div>

        <div class="card" style="position: relative; overflow: hidden;">
            <div id="loadingBar" style="display: none; position: absolute; top: 0; left: 0; height: 3px; background: #3b82f6; width: 100%; animation: loading 1s linear infinite;"></div>
            <div class="card-header" style="border-bottom: 1px solid #e5e7eb; padding: 1.5rem; display: flex; justify-content: space-between;">
                <h2 class="card-title">Daftar Departemen</h2>
                <span style="color: #6b7280; font-size: 0.875rem;">Total: <span id="totalData">{{ $departments->total() }}</span> Departemen</span>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Departemen</th>
                            <th>Deskripsi</th>
                            <th style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @include('client.departments._table')
                    </tbody>
                </table>
            </div>
            
            <div id="paginationContainer" style="padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb;">
                @if($departments->hasPages())
                    {{ $departments->links('pagination::bootstrap-4') }}
                @endif
            </div>
        </div>

        <!-- Add Department Modal -->
        <div id="addDepartmentModal" class="modal-overlay">
            <div class="modal-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="margin:0; font-size: 1.25rem; font-weight: 600; color: #111827;">Tambah Departemen Baru</h3>
                    <button type="button" onclick="closeModal('addDepartmentModal')" style="background:transparent; border:none; color:#6b7280; cursor:pointer; font-size:1.5rem;"><i class="ph ph-x"></i></button>
                </div>
                
                <form action="{{ route('client.departments.store') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 1rem;">
                        <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Nama Departemen</label>
                        <div style="position: relative;">
                            <i class="ph ph-buildings" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="text" name="name" required style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;" placeholder="Contoh: IT Support">
                        </div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Deskripsi (Opsional)</label>
                        <textarea name="description" rows="3" style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem; border-radius:0.5rem; color:#111827; box-sizing: border-box; resize: vertical;" placeholder="Deskripsi mengenai departemen ini..."></textarea>
                    </div>
                    
                    <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                        <button type="button" onclick="closeModal('addDepartmentModal')" class="btn btn-ghost" style="color: #4b5563; background: #f3f4f6; border: 1px solid #e5e7eb; padding: 0.5rem 1.5rem;">
                            <i class="ph ph-x"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1.5rem;">
                            <i class="ph ph-check-circle"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Department Modal -->
        <div id="editDepartmentModal" class="modal-overlay">
            <div class="modal-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="margin:0; font-size: 1.25rem; font-weight: 600; color: #111827;">Edit Departemen</h3>
                    <button type="button" onclick="closeModal('editDepartmentModal')" style="background:transparent; border:none; color:#6b7280; cursor:pointer; font-size:1.5rem;"><i class="ph ph-x"></i></button>
                </div>
                
                <form id="editDepartmentForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div style="margin-bottom: 1rem;">
                        <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Nama Departemen</label>
                        <div style="position: relative;">
                            <i class="ph ph-buildings" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="text" id="editDepartmentName" name="name" required style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;">
                        </div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Deskripsi (Opsional)</label>
                        <textarea id="editDepartmentDesc" name="description" rows="3" style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem; border-radius:0.5rem; color:#111827; box-sizing: border-box; resize: vertical;"></textarea>
                    </div>
                    
                    <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                        <button type="button" onclick="closeModal('editDepartmentModal')" class="btn btn-ghost" style="color: #4b5563; background: #f3f4f6; border: 1px solid #e5e7eb; padding: 0.5rem 1.5rem;">
                            <i class="ph ph-x"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success" style="background: #10b981; color: white; border: none; padding: 0.5rem 1.5rem; border-radius: 0.5rem; cursor: pointer;">
                            <i class="ph ph-check-circle"></i> Update Departemen
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
                <h3 style="margin:0 0 0.5rem 0; font-size: 1.25rem; font-weight: 600; color: #111827;">Hapus Departemen?</h3>
                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1.5rem;">Data departemen yang dihapus tidak bisa dikembalikan. Yakin?</p>
                <div style="display: flex; justify-content: center; gap: 1rem;">
                    <button type="button" onclick="closeModal('deleteModal')" class="btn btn-ghost" style="color: #4b5563; background: #f3f4f6; border: 1px solid #e5e7eb; padding: 0.5rem 1.5rem; cursor: pointer; border-radius: 0.5rem;">
                        <i class="ph ph-x"></i> Batal
                    </button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-primary" style="background: #ef4444; color: white; padding: 0.5rem 1.5rem; border: none; cursor: pointer; border-radius: 0.5rem;">
                        <i class="ph ph-trash"></i> Ya, Hapus
                    </button>
                </div>
            </div>
        </div>

        <style>
            .modal-overlay {
                position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.5); backdrop-filter: blur(3px);
                z-index: 999; padding: 1rem; box-sizing: border-box; overflow-y: auto;
                opacity: 0; visibility: hidden; transition: opacity 0.3s ease, visibility 0.3s ease;
            }
            .modal-overlay.active { opacity: 1; visibility: visible; }
            .modal-content {
                background: white; border: 1px solid #e5e7eb; border-radius: 1rem;
                width: 100%; max-width: 500px; margin: 2rem auto; padding: 1.5rem;
                box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
                box-sizing: border-box;
                transform: scale(0.95) translateY(-10px); transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .modal-overlay.active .modal-content { transform: scale(1) translateY(0); }
        </style>

        <script>
            function openModal(id) { document.getElementById(id).classList.add('active'); }
            function closeModal(id) { document.getElementById(id).classList.remove('active'); }
            function openEditDepartmentModal(id, name, desc) {
                document.getElementById('editDepartmentForm').action = '/departments/' + id;
                document.getElementById('editDepartmentName').value = name;
                document.getElementById('editDepartmentDesc').value = desc || '';
                openModal('editDepartmentModal');
            }

            let deleteId = null;
            function confirmDelete(id) {
                deleteId = id;
                openModal('deleteModal');
            }
            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (deleteId) {
                    document.getElementById('delete-form-' + deleteId).submit();
                }
            });

            // Close modal on click outside
            document.querySelectorAll('.modal-overlay').forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) closeModal(this.id);
                });
            });

            // AJAX Livesearch & Pagination
            let searchTimeout = null;
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('tableBody');
            const paginationContainer = document.getElementById('paginationContainer');
            const totalDataSpan = document.getElementById('totalData');
            const loadingBar = document.getElementById('loadingBar');

            function fetchDepartments(url) {
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
                const url = new URL(window.location.href);
                url.searchParams.set('search', query);
                url.searchParams.set('page', page);
                window.history.pushState({}, '', url);
                fetchDepartments(url);
            }

            searchInput.addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => triggerFilter(1), 500);
            });

            paginationContainer.addEventListener('click', function(e) {
                e.preventDefault();
                const link = e.target.closest('a');
                if (link) {
                    const url = link.getAttribute('href');
                    window.history.pushState({}, '', url);
                    fetchDepartments(url);
                }
            });
        </script>
    </section>
</x-layouts.app>
