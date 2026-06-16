<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
            <h2 style="font-family:'Playfair Display',serif; font-size:20px; font-weight:600; color:#ede0da; margin:0;">Edit Pelanggan</h2>
            <a href="{{ route('customers.index') }}" style="display:flex; align-items:center; gap:6px; padding:7px 14px; background:transparent; border:1px solid #534436; color:#a08d7c; font-family:'Inter',sans-serif; font-size:12px; font-weight:600; text-decoration:none; border-radius:2px; transition:all 0.15s;" onmouseover="this.style.borderColor='#ffb868';this.style.color='#ffb868'" onmouseout="this.style.borderColor='#534436';this.style.color='#a08d7c'">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .form-card { background:#1e1108; border:1px solid #2d1b12; border-radius:8px; overflow:hidden; }
        .form-card-header { padding:16px 24px; border-bottom:1px solid #2d1b12; display:flex; align-items:center; gap:10px; }
        .form-card-body { padding:24px; }
        .field-group { margin-bottom:18px; }
        .field-label { display:block; font-family:'Inter',sans-serif; font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:#a08d7c; margin-bottom:6px; }
        .field-label span.req { color:#ffb4ab; }
        .field-label span.opt { color:rgba(255,255,255,0.2); font-weight:400; text-transform:none; letter-spacing:0; }
        .field-input { width:100%; background:#140d0a; border:1px solid #2d1b12; color:#ede0da; font-family:'Inter',sans-serif; font-size:13px; padding:10px 14px; border-radius:4px; outline:none; box-sizing:border-box; transition:border-color 0.15s, box-shadow 0.15s; }
        .field-input:focus { border-color:#ffb868; box-shadow:0 0 0 2px rgba(255,184,104,0.12); }
        .field-input.error { border-color:#ffb4ab; }
        .field-error { color:#ffb4ab; font-family:'Inter',sans-serif; font-size:11px; margin-top:4px; }
        .field-input::placeholder { color:rgba(255,255,255,0.2); }
        .btn-submit { display:inline-flex; align-items:center; gap:6px; padding:10px 20px; background:#ffb868; color:#482900; font-family:'Inter',sans-serif; font-size:12px; font-weight:700; letter-spacing:0.05em; border:none; border-radius:2px; cursor:pointer; transition:opacity 0.15s; }
        .btn-submit:hover { opacity:0.9; }
        .btn-submit:active { transform:scale(0.97); }
        .btn-cancel { display:inline-flex; align-items:center; gap:6px; padding:10px 18px; background:transparent; color:#a08d7c; font-family:'Inter',sans-serif; font-size:12px; font-weight:600; letter-spacing:0.04em; border:1px solid #534436; border-radius:2px; text-decoration:none; transition:all 0.15s; }
        .btn-cancel:hover { border-color:#ffb868; color:#ffb868; }
    </style>

    <div style="max-width:600px;">
        {{-- Identity strip --}}
        <div style="display:flex; align-items:center; gap:12px; padding:14px 20px; background:#1e1108; border:1px solid #2d1b12; border-radius:8px; margin-bottom:14px;">
            <div style="width:38px; height:38px; border-radius:50%; background:rgba(255,184,104,0.12); border:1px solid rgba(255,184,104,0.2); display:flex; align-items:center; justify-content:center; font-family:'Inter',sans-serif; font-size:14px; font-weight:700; color:#ffb868; flex-shrink:0;">
                {{ strtoupper(substr($customer->nama_pelanggan, 0, 1)) }}
            </div>
            <div>
                <p style="font-family:'Inter',sans-serif; font-size:13px; font-weight:600; color:#ede0da; margin:0;">{{ $customer->nama_pelanggan }}</p>
                <p style="font-family:'Inter',sans-serif; font-size:11px; color:#a08d7c; margin:0;">Member sejak {{ $customer->created_at->format('d M Y') }} · Poin: <span style="color:#ffb868; font-weight:600;">{{ $customer->poin }}</span></p>
            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <div style="width:32px; height:32px; background:rgba(255,184,104,0.12); border:1px solid rgba(255,184,104,0.2); border-radius:4px; display:flex; align-items:center; justify-content:center;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ffb868" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </div>
                <div>
                    <p style="font-family:'Playfair Display',serif; font-size:15px; font-weight:600; color:#ede0da; margin:0;">Form Edit Pelanggan</p>
                    <p style="font-family:'Inter',sans-serif; font-size:11px; color:#a08d7c; margin:0;">Perbarui data pelanggan di bawah ini</p>
                </div>
            </div>
            <div class="form-card-body">

                @if($errors->any())
                <div style="background:rgba(255,180,171,0.08); border:1px solid rgba(255,180,171,0.2); border-radius:4px; padding:12px 16px; margin-bottom:20px;">
                    <ul style="margin:0; padding-left:16px; font-family:'Inter',sans-serif; font-size:12px; color:#ffb4ab;">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('customers.update', $customer->id) }}">
                    @csrf @method('PUT')

                    <div class="field-group">
                        <label class="field-label">Nama Pelanggan <span class="req">*</span></label>
                        <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan', $customer->nama_pelanggan) }}"
                               class="field-input @error('nama_pelanggan') error @enderror"
                               placeholder="Contoh: Rafli Pasha">
                        @error('nama_pelanggan')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label">Email <span class="opt">(opsional)</span></label>
                        <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                               class="field-input @error('email') error @enderror"
                               placeholder="Contoh: rafli@email.com">
                        @error('email')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label">No. Telepon <span class="req">*</span></label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon', $customer->no_telepon) }}"
                               class="field-input @error('no_telepon') error @enderror"
                               placeholder="Contoh: 08123456789">
                        @error('no_telepon')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="field-group" style="margin-bottom:24px;">
                        <label class="field-label">Alamat <span class="opt">(opsional)</span></label>
                        <textarea name="alamat" rows="3"
                                  class="field-input @error('alamat') error @enderror"
                                  style="resize:none; line-height:1.5;"
                                  placeholder="Contoh: Jl. Merdeka No. 10, Jakarta">{{ old('alamat', $customer->alamat) }}</textarea>
                        @error('alamat')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div style="display:flex; gap:8px;">
                        <button type="submit" class="btn-submit">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Update Pelanggan
                        </button>
                        <a href="{{ route('customers.index') }}" class="btn-cancel">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>