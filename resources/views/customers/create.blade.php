<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
            <h2 style="font-family:'Playfair Display',serif; font-size:20px; font-weight:600; color:#2E2E2E; margin:0;">Tambah Pelanggan</h2>
            <a href="{{ route('customers.index') }}" style="display:flex; align-items:center; gap:6px; padding:7px 14px; background:transparent; border:1px solid #E5E7EB; color:#6B7280; font-family:'Inter',sans-serif; font-size:12px; font-weight:600; text-decoration:none; border-radius:8px; transition:all 0.15s;" onmouseover="this.style.borderColor='#6B8E5A';this.style.color='#6B8E5A'" onmouseout="this.style.borderColor='#E5E7EB';this.style.color='#6B7280'">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .form-card { background:#FFFFFF; border:1px solid #E5E7EB; border-radius:12px; overflow:hidden; }
        .form-card-header { padding:16px 24px; border-bottom:1px solid #E5E7EB; display:flex; align-items:center; gap:10px; }
        .form-card-body { padding:24px; }
        .field-group { margin-bottom:18px; }
        .field-label { display:block; font-family:'Inter',sans-serif; font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:#6B7280; margin-bottom:6px; }
        .field-label span.req { color:#EF4444; }
        .field-label span.opt { color:#9CA3AF; font-weight:400; text-transform:none; letter-spacing:0; }
        .field-input { width:100%; background:#FFFFFF; border:1px solid #E5E7EB; color:#2E2E2E; font-family:'Inter',sans-serif; font-size:13px; padding:10px 14px; border-radius:8px; outline:none; box-sizing:border-box; transition:border-color 0.15s, box-shadow 0.15s; }
        .field-input:focus { border-color:#6B8E5A; box-shadow:0 0 0 3px rgba(107,142,90,0.1); }
        .field-input.error { border-color:#EF4444; }
        .field-error { color:#EF4444; font-family:'Inter',sans-serif; font-size:11px; margin-top:4px; }
        .field-input::placeholder { color:#9CA3AF; }
        .btn-submit { display:inline-flex; align-items:center; gap:6px; padding:10px 20px; background:#FF7A30; color:#fff; font-family:'Inter',sans-serif; font-size:12px; font-weight:700; letter-spacing:0.05em; border:none; border-radius:8px; cursor:pointer; transition:background 0.15s; }
        .btn-submit:hover { background:#E8631C; }
        .btn-submit:active { transform:scale(0.97); }
        .btn-cancel { display:inline-flex; align-items:center; gap:6px; padding:10px 18px; background:transparent; color:#6B7280; font-family:'Inter',sans-serif; font-size:12px; font-weight:600; letter-spacing:0.04em; border:1px solid #E5E7EB; border-radius:8px; text-decoration:none; transition:all 0.15s; }
        .btn-cancel:hover { border-color:#6B8E5A; color:#6B8E5A; }
    </style>

    <div style="max-width:600px;">
        <div class="form-card">
            <div class="form-card-header">
                <div style="width:32px; height:32px; background:rgba(255,122,48,0.12); border:1px solid rgba(255,122,48,0.2); border-radius:8px; display:flex; align-items:center; justify-content:center;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FF7A30" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                </div>
                <div>
                    <p style="font-family:'Playfair Display',serif; font-size:15px; font-weight:600; color:#2E2E2E; margin:0;">Form Tambah Pelanggan</p>
                    <p style="font-family:'Inter',sans-serif; font-size:11px; color:#9CA3AF; margin:0;">Daftarkan pelanggan baru ke sistem</p>
                </div>
            </div>
            <div class="form-card-body">

                @if($errors->any())
                <div style="background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.2); border-radius:8px; padding:12px 16px; margin-bottom:20px;">
                    <ul style="margin:0; padding-left:16px; font-family:'Inter',sans-serif; font-size:12px; color:#DC2626;">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('customers.store') }}">
                    @csrf

                    <div class="field-group">
                        <label class="field-label">Nama Pelanggan <span class="req">*</span></label>
                        <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}"
                               class="field-input @error('nama_pelanggan') error @enderror"
                               placeholder="Contoh: Rafli Pasha">
                        @error('nama_pelanggan')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label">Email <span class="opt">(opsional)</span></label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="field-input @error('email') error @enderror"
                               placeholder="Contoh: rafli@email.com">
                        @error('email')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label">No. Telepon <span class="req">*</span></label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                               class="field-input @error('no_telepon') error @enderror"
                               placeholder="Contoh: 08123456789">
                        @error('no_telepon')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="field-group" style="margin-bottom:24px;">
                        <label class="field-label">Alamat <span class="opt">(opsional)</span></label>
                        <textarea name="alamat" rows="3"
                                  class="field-input @error('alamat') error @enderror"
                                  style="resize:none; line-height:1.5;"
                                  placeholder="Contoh: Jl. Merdeka No. 10, Jakarta">{{ old('alamat') }}</textarea>
                        @error('alamat')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div style="display:flex; gap:8px;">
                        <button type="submit" class="btn-submit">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Simpan Pelanggan
                        </button>
                        <a href="{{ route('customers.index') }}" class="btn-cancel">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>