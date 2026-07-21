<x-layouts.app>
    <section class="view view-settings">
        <div class="page-header">
            <h1 class="page-title">Pengaturan Akun</h1>
            <p class="page-subtitle">Kelola profil dan keamanan akun Anda</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 2rem; align-items: start;">
            <!-- Profil -->
            <div class="card" style="margin: 0; display: flex; flex-direction: column;">
                <div class="card-header" style="border-bottom: 1px solid #e5e7eb; padding: 1.5rem;">
                    <h2 class="card-title">Informasi Profil</h2>
                </div>
                <form action="{{ route('client.settings.profile') }}" method="POST" style="padding: 1.5rem;">
                    @csrf
                    @method('PUT')
                    <div style="margin-bottom: 1rem;">
                        <label
                            style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Nama
                            Lengkap</label>
                        <div style="position: relative;">
                            <i class="ph ph-user"
                                style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="text" name="name" value="{{ $user->name }}" required
                                style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;">
                        </div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label
                            style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Nama
                            Perusahaan</label>
                        <div style="position: relative;">
                            <i class="ph ph-buildings"
                                style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="text" name="company" value="{{ tenant('company') }}" required
                                style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;">
                        </div>
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label
                            style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Email</label>
                        <div style="position: relative;">
                            <i class="ph ph-envelope-simple"
                                style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="email" name="email" value="{{ $user->email }}" required
                                style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        Simpan Profil
                    </button>
                </form>
            </div>

            <!-- Password -->
            <div class="card" style="margin: 0; display: flex; flex-direction: column;">
                <div class="card-header" style="border-bottom: 1px solid #e5e7eb; padding: 1.5rem;">
                    <h2 class="card-title">Ubah Kata Sandi</h2>
                </div>
                <form action="{{ route('client.settings.password') }}" method="POST" style="padding: 1.5rem;">
                    @csrf
                    @method('PUT')
                    <div style="margin-bottom: 1rem;">
                        <label
                            style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Kata
                            Sandi Saat Ini</label>
                        <div style="position: relative;">
                            <i class="ph ph-lock-key"
                                style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="password" name="current_password" required
                                style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;">
                        </div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label
                            style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Kata
                            Sandi Baru</label>
                        <div style="position: relative;">
                            <i class="ph ph-lock-key"
                                style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="password" name="password" required
                                style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;">
                        </div>
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label
                            style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Konfirmasi
                            Kata Sandi</label>
                        <div style="position: relative;">
                            <i class="ph ph-lock-key"
                                style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="password" name="password_confirmation" required
                                style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary"
                        style="width: 100%; justify-content: center; background: #10b981; border-color: #10b981;">
                        Perbarui Kata Sandi
                    </button>
                </form>
            </div>
        </div>

        @php
            $tenantPlan = \App\Models\Plan::find(tenant('plan_id'));
        @endphp

        <!-- Informasi Paket / Billing -->
        <div class="card" style="margin-top: 2rem; border-top: 4px solid #3b82f6;">
            <div class="card-header"
                style="border-bottom: 1px solid #e5e7eb; padding: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                <h2 class="card-title">Informasi Paket Langganan</h2>
                @if ($tenantPlan)
                    <span class="badge"
                        style="background:#dbeafe; color:#2563eb; font-size: 0.875rem; padding: 0.25rem 0.75rem; border-radius: 9999px; font-weight: 600;">Paket
                        Saat Ini: {{ $tenantPlan->name }}</span>
                @else
                    <span class="badge"
                        style="background:#f3f4f6; color:#4b5563; font-size: 0.875rem; padding: 0.25rem 0.75rem; border-radius: 9999px; font-weight: 600;">Belum
                        Ada Paket</span>
                @endif
            </div>
            <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                    <div>
                        <span
                            style="display:block; font-size: 0.75rem; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 0.25rem;">Status
                            Akun</span>
                        <div style="font-size: 1rem; color: #111827; font-weight: 500;">
                            @if ((tenant('account_status') ?? 'aktif') == 'aktif')
                                <span style="color: #10b981;"><i class="ph ph-check-circle"
                                        style="vertical-align: middle;"></i> Aktif</span>
                            @else
                                <span style="color: #ef4444;"><i class="ph ph-warning-circle"
                                        style="vertical-align: middle;"></i> Nonaktif</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <span
                            style="display:block; font-size: 0.75rem; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 0.25rem;">Status
                            Tagihan</span>
                        <div style="font-size: 1rem; color: #111827; font-weight: 500;">
                            @if ((tenant('billing_status') ?? 'lunas') == 'lunas')
                                <span style="color: #10b981;"><i class="ph ph-check-circle"
                                        style="vertical-align: middle;"></i> Lunas</span>
                            @else
                                <span style="color: #d97706;"><i class="ph ph-warning-circle"
                                        style="vertical-align: middle;"></i> Ditangguhkan</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <span
                            style="display:block; font-size: 0.75rem; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 0.25rem;">Masa
                            Aktif Sampai</span>
                        <div style="font-size: 1rem; color: #111827; font-weight: 500;">
                            @if (tenant('plan_ends_at'))
                                {{ \Carbon\Carbon::parse(tenant('plan_ends_at'))->format('d M Y') }}
                            @else
                                Lifetime / Selamanya
                            @endif
                        </div>
                    </div>
                </div>

                @if ($tenantPlan)
                    <div
                        style="background: #f9fafb; padding: 1.5rem; border-radius: 0.75rem; border: 1px solid #e5e7eb;">
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">
                            Fasilitas Paket {{ $tenantPlan->name }}</h3>
                        <ul
                            style="list-style: none; padding: 0; margin: 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                            <li
                                style="display: flex; align-items: center; gap: 0.5rem; color: #4b5563; font-size: 0.875rem;">
                                <i class="ph ph-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                                Maksimal {{ $tenantPlan->agent_limit == -1 ? 'Unlimited' : $tenantPlan->agent_limit }}
                                Agent
                            </li>
                            <li
                                style="display: flex; align-items: center; gap: 0.5rem; color: #4b5563; font-size: 0.875rem;">
                                <i class="ph ph-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                                Akses Monitoring
                            </li>
                            <li
                                style="display: flex; align-items: center; gap: 0.5rem; color: #4b5563; font-size: 0.875rem;">
                                <i class="ph ph-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                                Laporan Aktivitas Lengkap
                            </li>
                            <li
                                style="display: flex; align-items: center; gap: 0.5rem; color: #4b5563; font-size: 0.875rem;">
                                <i class="ph ph-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                                Support Prioritas
                            </li>
                        </ul>
                    </div>
                @endif

                <div style="display: flex; justify-content: flex-end; gap: 1rem; align-items: center; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                    <span style="font-size: 0.875rem; color: #6b7280;">Ingin menambah jumlah agent atau durasi paket?</span>
                    <a href="https://wa.me/6281234567890?text=Halo%20Admin%2C%20saya%20ingin%20upgrade%20paket%20langganan%20AgentKu." target="_blank" class="btn btn-outline" style="color: #10b981; border-color: #10b981;">
                        <i class="ph ph-whatsapp-logo"></i> Hubungi Admin via WhatsApp
                    </a>
                </div>
            </div>
        </div>

        <!-- Daftar Pilihan Paket -->
        <div class="card" style="margin-top: 2rem;">
            <div class="card-header" style="border-bottom: 1px solid #e5e7eb; padding: 1.5rem;">
                <h2 class="card-title">Pilihan Paket Langganan</h2>
                <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem;">Pilih paket yang sesuai dengan kebutuhan perusahaan Anda.</p>
            </div>
            <div style="padding: 1.5rem;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                    @foreach($plans as $plan)
                        <div style="border: 1px solid {{ (tenant('plan_id') == $plan->id) ? '#3b82f6' : '#e5e7eb' }}; border-radius: 1rem; padding: 1.5rem; display: flex; flex-direction: column; position: relative; {{ (tenant('plan_id') == $plan->id) ? 'box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1);' : '' }}">
                            @if(tenant('plan_id') == $plan->id)
                                <span style="position: absolute; top: -10px; right: 1.5rem; background: #3b82f6; color: white; font-size: 0.75rem; font-weight: 600; padding: 0.25rem 0.75rem; border-radius: 9999px;">Aktif</span>
                            @endif
                            <h3 style="font-size: 1.25rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem;">{{ $plan->name }}</h3>
                            <div style="margin-bottom: 1.5rem;">
                                <span style="font-size: 1.5rem; font-weight: 700; color: #111827;">Rp {{ number_format($plan->price, 0, ',', '.') }}</span>
                                <span style="font-size: 0.875rem; color: #6b7280;">/ {{ $plan->duration_days }} hari</span>
                            </div>
                            
                            <ul style="list-style: none; padding: 0; margin: 0 0 2rem 0; flex-grow: 1; display: flex; flex-direction: column; gap: 0.75rem;">
                                <li style="display: flex; align-items: flex-start; gap: 0.5rem; color: #4b5563; font-size: 0.875rem;">
                                    <i class="ph ph-check-circle" style="color: #10b981; font-size: 1.25rem; margin-top: -0.125rem;"></i>
                                    <span>Maksimal {{ $plan->agent_limit == -1 ? 'Unlimited' : $plan->agent_limit }} Agent</span>
                                </li>
                                <li style="display: flex; align-items: flex-start; gap: 0.5rem; color: #4b5563; font-size: 0.875rem;">
                                    <i class="ph ph-check-circle" style="color: #10b981; font-size: 1.25rem; margin-top: -0.125rem;"></i>
                                    <span>Akses Monitoring</span>
                                </li>
                                <li style="display: flex; align-items: flex-start; gap: 0.5rem; color: #4b5563; font-size: 0.875rem;">
                                    <i class="ph ph-check-circle" style="color: #10b981; font-size: 1.25rem; margin-top: -0.125rem;"></i>
                                    <span>Laporan Aktivitas</span>
                                </li>
                            </ul>
                            
                            @if(tenant('plan_id') == $plan->id)
                                <button class="btn" style="width: 100%; background: #f3f4f6; color: #9ca3af; border: none; cursor: not-allowed; justify-content: center;">Sedang Digunakan</button>
                            @else
                                <a href="https://wa.me/6281234567890?text=Halo%20Admin%2C%20saya%20ingin%20berlangganan%20paket%20{{ urlencode($plan->name) }}%20untuk%20perusahaan%20{{ urlencode(tenant('company') ?? '') }}." target="_blank" class="btn btn-primary" style="width: 100%; justify-content: center;">Pilih Paket Ini</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
