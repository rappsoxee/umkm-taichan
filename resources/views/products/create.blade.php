<x-app-layout>
    <x-slot name="header">
        <h2 class="topbar-title">Tambah Produk</h2>
        <div class="topbar-actions">
            <a href="{{ route('products.index') }}" class="btn-ghost">← Kembali</a>
        </div>
    </x-slot>

    <div style="max-width:640px;">
        <div class="card-dark">
            <div class="card-dark-body">

                @if($errors->any())
                    <div class="alert-error">
                        <ul style="list-style:disc; padding-left:18px; margin:0;">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div style="margin-bottom:16px;">
                        <label class="label-dark">Kode Produk <span style="color:#EF4444;">*</span></label>
                        <input type="text" name="kode_produk" value="{{ old('kode_produk') }}" placeholder="Contoh: TCH-001" class="input-dark">
                    </div>

                    <div style="margin-bottom:16px;">
                        <label class="label-dark">Nama Produk <span style="color:#EF4444;">*</span></label>
                        <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" placeholder="Contoh: Sate Taichan Original" class="input-dark">
                    </div>

                    <div style="margin-bottom:16px;">
                        <label class="label-dark">Kategori <span style="color:#EF4444;">*</span></label>
                        <select name="kategori" class="input-dark">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Makanan" {{ old('kategori') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="Minuman" {{ old('kategori') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="Snack"   {{ old('kategori') == 'Snack'   ? 'selected' : '' }}>Snack</option>
                            <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:16px;">
                        <div>
                            <label class="label-dark">Harga (Rp) <span style="color:#EF4444;">*</span></label>
                            <input type="number" name="harga" value="{{ old('harga') }}" placeholder="15000" min="0" class="input-dark">
                        </div>
                        <div>
                            <label class="label-dark">Stok <span style="color:#EF4444;">*</span></label>
                            <input type="number" name="stok" value="{{ old('stok', 0) }}" placeholder="50" min="0" class="input-dark">
                        </div>
                    </div>
            
                    <div style="margin-bottom:16px;">
                        <label class="label-dark">Deskripsi <span style="font-size:10px; color:#9CA3AF; font-weight:400; text-transform:none; letter-spacing:0;">(opsional)</span></label>
                        <textarea name="deskripsi" rows="3" class="input-dark" placeholder="Contoh: Sate ayam dengan bumbu kacang pedas khas Taichan...">{{ old('deskripsi') }}</textarea>
                    </div>
                    <div style="margin-bottom:24px;">
                        <label class="label-dark">Foto Produk <span style="font-size:10px; color:#9CA3AF; font-weight:400; text-transform:none; letter-spacing:0;">(opsional, maks 2MB)</span></label>
                        <div style="display:flex; align-items:center; gap:16px;">
                            <div id="preview-container" style="width:80px; height:80px; border-radius:10px; border:1.5px dashed #E5E7EB; background:#FAF7F2; display:flex; align-items:center; justify-content:center; overflow:hidden; flex-shrink:0;">
                                <svg id="preview-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                <img id="preview-img" src="" alt="" style="width:100%; height:100%; object-fit:cover; display:none;">
                            </div>
                            <div>
                                <input type="file" name="gambar" id="input-gambar" accept="image/*" onchange="previewGambar(this)" style="display:none;">
                                <button type="button" onclick="document.getElementById('input-gambar').click()" class="btn-ghost">Pilih Foto</button>
                                <p style="font-size:11px; color:#9CA3AF; margin-top:8px; margin-bottom:0;">JPG, PNG, atau WEBP.</p>
                            </div>
                        </div>
                    </div>

                    <div style="display:flex; gap:10px; padding-top:8px; border-top:1px solid #E5E7EB;">
                        <button type="submit" class="btn-gold">Simpan Produk</button>
                        <a href="{{ route('products.index') }}" class="btn-ghost">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function previewGambar(input) {
            const icon = document.getElementById('preview-icon');
            const img  = document.getElementById('preview-img');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => { img.src = e.target.result; img.style.display = 'block'; icon.style.display = 'none'; };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>