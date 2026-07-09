<x-layouts.app>
    <section class="view view-dashboard">
        <div class="page-header">
            <h1 class="page-title">Pengaturan Global</h1>
            <p class="page-subtitle">Konfigurasi sistem utama aplikasi SaaS AgentKu</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            
            <!-- Payment Gateway Settings -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title"><i class="ph ph-credit-card"></i> Payment Gateway</h2>
                </div>
                <div style="padding: 1.5rem;">
                    <form>
                        <div style="margin-bottom: 1rem;">
                            <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Provider</label>
                            <select style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem; border-radius:0.5rem; color:#111827;">
                                <option>Midtrans</option>
                                <option>Xendit</option>
                                <option>Stripe</option>
                            </select>
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">API Key (Secret)</label>
                            <input type="password" value="midtrans-secret-12345" style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem; border-radius:0.5rem; color:#111827;">
                        </div>
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">API Key (Client)</label>
                            <input type="text" value="midtrans-client-12345" style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem; border-radius:0.5rem; color:#111827;">
                        </div>
                        <button type="button" class="btn btn-primary">Simpan Gateway</button>
                    </form>
                </div>
            </div>

            <!-- Application Settings -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title"><i class="ph ph-sliders"></i> Preferensi Aplikasi</h2>
                </div>
                <div style="padding: 1.5rem;">
                    <form>
                        <div style="margin-bottom: 1rem;">
                            <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Nama Aplikasi</label>
                            <input type="text" value="AgentKu SaaS" style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem; border-radius:0.5rem; color:#111827;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label style="display:flex; align-items:center; gap:0.5rem; color:#374151; font-size:0.875rem; cursor:pointer; font-weight: 500;">
                                <input type="checkbox" checked style="width: 1rem; height: 1rem; accent-color: var(--primary);">
                                Izinkan Registrasi Mandiri (Self-Service)
                            </label>
                        </div>
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Retensi Log (Hari)</label>
                            <input type="number" value="30" style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem; border-radius:0.5rem; color:#111827;">
                            <small style="color:#6b7280; display:block; margin-top:0.25rem;">Log aktivitas agen akan dihapus otomatis setelah batas ini.</small>
                        </div>
                        <button type="button" class="btn btn-primary">Simpan Preferensi</button>
                    </form>
                </div>
            </div>
            
        </div>
    </section>
</x-layouts.app>
