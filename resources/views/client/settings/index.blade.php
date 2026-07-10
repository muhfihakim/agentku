<x-layouts.app>
    <section class="view view-settings">
        <div class="page-header">
            <h1 class="page-title">Pengaturan Akun</h1>
            <p class="page-subtitle">Kelola profil dan keamanan akun Anda</p>
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
                        <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Nama Lengkap</label>
                        <div style="position: relative;">
                            <i class="ph ph-user" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="text" name="name" value="{{ $user->name }}" required style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;">
                        </div>
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Email</label>
                        <div style="position: relative;">
                            <i class="ph ph-envelope-simple" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="email" name="email" value="{{ $user->email }}" required style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;">
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
                        <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Kata Sandi Saat Ini</label>
                        <div style="position: relative;">
                            <i class="ph ph-lock-key" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="password" name="current_password" required style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;">
                        </div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Kata Sandi Baru</label>
                        <div style="position: relative;">
                            <i class="ph ph-lock-key" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="password" name="password" required style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;">
                        </div>
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display:block; margin-bottom:0.5rem; color:#374151; font-size:0.875rem; font-weight: 500;">Konfirmasi Kata Sandi</label>
                        <div style="position: relative;">
                            <i class="ph ph-lock-key" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1.25rem;"></i>
                            <input type="password" name="password_confirmation" required style="width:100%; background:#f9fafb; border:1px solid #d1d5db; padding:0.75rem 0.75rem 0.75rem 3rem; border-radius:0.5rem; color:#111827; box-sizing: border-box;">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; background: #10b981; border-color: #10b981;">
                        Perbarui Kata Sandi
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
