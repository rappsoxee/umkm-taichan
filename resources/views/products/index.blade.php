<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
            <div>
                <h2 class="topbar-title">Daftar Produk</h2>
                <p style="font-size:12px; color:#6B7280; margin:2px 0 0;">Kelola menu sate taichan dan pendamping secara real-time.</p>
            </div>
            <div class="topbar-actions">
                <div style="display:flex; align-items:center; gap:8px; background:#FFFFFF; border:1px solid #E5E7EB; border-radius:8px; padding:7px 12px; transition:border-color 0.2s, box-shadow 0.2s;" id="search-wrap">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" placeholder="Cari produk..." id="search-input" oninput="filterTable()"
                           style="background:transparent; border:none; outline:none; font-size:13px; color:#2E2E2E; font-family:inherit; width:160px;"
                           onfocus="document.getElementById('search-wrap').style.borderColor='#6B8E5A'; document.getElementById('search-wrap').style.boxShadow='0 0 0 3px rgba(107,142,90,0.1)'"
                           onblur="document.getElementById('search-wrap').style.borderColor='#E5E7EB'; document.getElementById('search-wrap').style.boxShadow='none'">
                </div>
                <select id="filter-kategori" onchange="filterTable()" class="input-dark" style="width:auto; padding:7px 12px; font-size:12px;">
                    <option value="">Semua Kategori</option>
                    <option value="Makanan">Makanan</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Snack">Snack</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <a href="{{ route('products.create') }}" class="btn-gold">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Produk
                </a>
            </div>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                background: '#FFFFFF',
                color: '#2E2E2E',
                confirmButtonColor: '#FF7A30',
                timer: 2500,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        });
    </script>
    @endif

    <style>
        @keyframes fadeIn  { from { opacity:0; } to { opacity:1; } }
        @keyframes slideUp { from { transform:translateY(30px); opacity:0; } to { transform:translateY(0); opacity:1; } }
        @keyframes fadeInUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes pulse { 0%,100% { opacity:1; } 50% { opacity:0.4; } }

        .edit-modal-bg  { animation: fadeIn 0.2s ease both; }
        .edit-modal-box { animation: slideUp 0.25s cubic-bezier(0.32,0.72,0,1) both; }

        .product-row { animation: fadeInUp 0.35s ease both; transition: background 0.15s; }
        .product-row:hover { background: #FAF7F2 !important; }
        .product-row:hover .row-img { border-color: rgba(107,142,90,0.4) !important; }
        .product-row:hover .action-btn { opacity: 1 !important; }

        .action-btn {
            width: 32px; height: 32px;
            border-radius: 8px;
            border: none;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.15s;
            opacity: 0.6;
        }
        .action-btn:hover { transform: scale(1.1); opacity: 1 !important; }
        .action-btn:active { transform: scale(0.92); }
        .action-btn.edit  { background: rgba(107,142,90,0.1); color: #6B8E5A; }
        .action-btn.edit:hover  { background: rgba(107,142,90,0.18); }
        .action-btn.delete { background: rgba(239,68,68,0.1); color: #EF4444; }
        .action-btn.delete:hover { background: rgba(239,68,68,0.18); }

        .status-tersedia {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.2);
            color: #16A34A;
            font-size: 10px; font-weight: 600;
            padding: 3px 10px; border-radius: 20px;
        }
        .status-habis {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.2);
            color: #EF4444;
            font-size: 10px; font-weight: 600;
            padding: 3px 10px; border-radius: 20px;
        }
        .status-low {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(245,158,11,0.1);
            border: 1px solid rgba(245,158,11,0.2);
            color: #B45309;
            font-size: 10px; font-weight: 600;
            padding: 3px 10px; border-radius: 20px;
        }
        .dot-pulse {
            width: 6px; height: 6px; border-radius: 50%;
            animation: pulse 1.5s ease-in-out infinite;
            flex-shrink: 0;
        }

        /* Glow background */
        .glow-1 { position:fixed; bottom:-10%; right:-5%; width:400px; height:400px; background:rgba(107,142,90,0.04); border-radius:50%; filter:blur(100px); pointer-events:none; z-index:-1; }
        .glow-2 { position:fixed; top:20%; left:-5%; width:300px; height:300px; background:rgba(255,122,48,0.04); border-radius:50%; filter:blur(80px); pointer-events:none; z-index:-1; }
    </style>

    <div class="glow-1"></div>
    <div class="glow-2"></div>

    <div style="display:flex; flex-direction:column; gap:16px;">
        <div class="card-dark" style="overflow:hidden;">
            <div style="overflow-x:auto;">
                <table class="table-dark" id="product-table">
                    <thead>
                        <tr>
                            <th style="width:72px;">Foto</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $i => $product)
                        <tr class="product-row" data-nama="{{ strtolower($product->nama_produk) }}" data-kategori="{{ $product->kategori }}" style="animation-delay:{{ $i * 0.04 }}s;">
                            {{-- Foto --}}
                            <td>
                                @if($product->gambar)
                                    <img src="{{ asset('storage/' . $product->gambar) }}"
                                         alt="{{ $product->nama_produk }}"
                                         class="row-img"
                                         style="width:56px; height:56px; object-fit:cover; border-radius:10px; border:1px solid #E5E7EB; transition:border-color 0.2s;">
                                @else
                                    <div class="row-img" style="width:56px; height:56px; border-radius:10px; background:#FAF7F2; border:1px solid #E5E7EB; display:flex; align-items:center; justify-content:center; transition:border-color 0.2s;">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    </div>
                                @endif
                            </td>

                            {{-- Nama --}}
                            <td>
                                <p style="font-size:13px; font-weight:600; color:#2E2E2E; margin:0 0 3px;">{{ $product->nama_produk }}</p>
                                <p style="font-size:11px; color:#9CA3AF; margin:0; font-family:monospace;">{{ $product->kode_produk }}</p>
                            </td>

                            {{-- Kategori --}}
                            <td>
                                <span style="background:#FAF7F2; color:#6B7280; font-size:10px; font-weight:600; padding:3px 10px; border-radius:20px; border:1px solid #E5E7EB;">{{ $product->kategori }}</span>
                            </td>

                            {{-- Harga --}}
                            <td style="color:#FF7A30; font-weight:600; font-size:13px;">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>

                            {{-- Stok --}}
                            <td style="font-weight:600; font-size:13px; color:{{ $product->stok == 0 ? '#EF4444' : ($product->stok <= 5 ? '#B45309' : '#2E2E2E') }};">
                                {{ $product->stok }}
                            </td>

                            {{-- Status --}}
                            <td>
                                @if($product->stok == 0)
                                    <span class="status-habis">
                                        <span class="dot-pulse" style="background:#EF4444;"></span>
                                        Habis
                                    </span>
                                @elseif($product->stok <= 5)
                                    <span class="status-low">
                                        <span class="dot-pulse" style="background:#F59E0B;"></span>
                                        Stok Tipis
                                    </span>
                                @else
                                    <span class="status-tersedia">
                                        <span class="dot-pulse" style="background:#22C55E;"></span>
                                        Tersedia
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td>
                                <div style="display:flex; gap:6px; justify-content:flex-end; align-items:center;">
                                    <button onclick="openEditModal({{ $product->id }})" class="action-btn edit" title="Edit produk">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    <form id="delete-product-{{ $product->id }}" action="{{ route('products.destroy', $product) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button onclick="confirmDeleteProduct({{ $product->id }}, '{{ $product->nama_produk }}')" class="action-btn delete" title="Hapus produk">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:56px; color:#9CA3AF;">
                                <div style="margin-bottom:12px;">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB" stroke-width="1.2" style="display:block; margin:0 auto;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                </div>
                                Belum ada produk.
                                <a href="{{ route('products.create') }}" style="color:#FF7A30; margin-left:4px; text-decoration:underline;">Tambah sekarang</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer --}}
            <div style="padding:12px 18px; border-top:1px solid #F1EFE8; display:flex; justify-content:space-between; align-items:center;">
                <span id="product-count" style="font-size:11px; color:#9CA3AF;">Menampilkan {{ $products->count() }} produk</span>
                <div style="display:flex; gap:8px; align-items:center;">
                    <span style="font-size:11px; color:#9CA3AF;">
                        {{ $products->where('stok', 0)->count() }} habis ·
                        {{ $products->where('stok', '>', 0)->where('stok', '<=', 5)->count() }} stok tipis
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Product Modal --}}
    <div id="edit-modal" style="display:none; position:fixed; inset:0; z-index:50; align-items:center; justify-content:center; padding:24px;">
        <div class="edit-modal-bg" onclick="closeEditModal()" style="position:fixed; inset:0; background:rgba(46,46,46,0.5); backdrop-filter:blur(6px); -webkit-backdrop-filter:blur(6px);"></div>
        <div class="edit-modal-box" style="position:relative; z-index:1; width:100%; max-width:560px; max-height:88vh; overflow-y:auto; background:#FFFFFF; border-radius:16px; border:1px solid #E5E7EB; padding:24px; box-shadow:0 12px 40px rgba(0,0,0,0.12);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <div>
                    <p style="font-size:15px; font-weight:600; color:#2E2E2E; margin:0 0 2px;">Edit Produk</p>
                    <p style="font-size:11px; color:#9CA3AF; margin:0;" id="edit-modal-sub">—</p>
                </div>
                <button onclick="closeEditModal()" style="background:#FAF7F2; border:1px solid #E5E7EB; color:#6B7280; width:30px; height:30px; border-radius:50%; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center; font-family:inherit;">×</button>
            </div>
            <div id="edit-errors" style="display:none; background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.2); color:#DC2626; border-radius:8px; padding:12px 16px; font-size:13px; margin-bottom:16px;"></div>
            <form id="edit-form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
                    <div>
                        <label class="label-dark">Kode Produk <span style="color:#EF4444;">*</span></label>
                        <input type="text" name="kode_produk" id="edit-kode" class="input-dark">
                    </div>
                    <div>
                        <label class="label-dark">Kategori <span style="color:#EF4444;">*</span></label>
                        <select name="kategori" id="edit-kategori" class="input-dark">
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Snack">Snack</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom:14px;">
                    <label class="label-dark">Nama Produk <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="nama_produk" id="edit-nama" class="input-dark">
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
                    <div>
                        <label class="label-dark">Harga (Rp) <span style="color:#EF4444;">*</span></label>
                        <input type="number" name="harga" id="edit-harga" min="0" class="input-dark">
                    </div>
                    <div>
                        <label class="label-dark">Stok <span style="color:#EF4444;">*</span></label>
                        <input type="number" name="stok" id="edit-stok" min="0" class="input-dark">
                    </div>
                </div>
                <div style="margin-bottom:14px;">
                    <label class="label-dark">Deskripsi <span style="font-size:10px; color:#9CA3AF; font-weight:400; text-transform:none; letter-spacing:0;">(opsional)</span></label>
                    <textarea name="deskripsi" id="edit-deskripsi" rows="3" class="input-dark" placeholder="Deskripsi produk..."></textarea>
                </div>
                <div style="margin-bottom:20px;">
                    <label class="label-dark">Foto Produk <span style="font-size:10px; color:#9CA3AF; font-weight:400; text-transform:none; letter-spacing:0;">(opsional)</span></label>
                    <div style="display:flex; align-items:center; gap:14px;">
                        <div id="edit-preview-container" style="width:72px; height:72px; border-radius:10px; border:1.5px dashed #E5E7EB; background:#FAF7F2; display:flex; align-items:center; justify-content:center; overflow:hidden; flex-shrink:0;">
                            <svg id="edit-preview-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <img id="edit-preview-img" src="" alt="" style="width:100%; height:100%; object-fit:cover; display:none;">
                        </div>
                        <div style="display:flex; flex-direction:column; gap:8px;">
                            <div style="display:flex; gap:8px;">
                                <input type="file" name="gambar" id="edit-input-gambar" accept="image/*" onchange="previewEditGambar(this)" style="display:none;">
                                <button type="button" onclick="document.getElementById('edit-input-gambar').click()" class="btn-ghost" style="font-size:12px; padding:6px 12px;">Pilih Foto</button>
                                <button type="button" id="btn-hapus-foto" onclick="hapusFoto()" style="display:none; font-size:12px; padding:6px 12px; background:rgba(239,68,68,0.08); color:#EF4444; border:1px solid rgba(239,68,68,0.2); border-radius:8px; cursor:pointer; font-family:inherit;">Hapus Foto</button>
                            </div>
                            <p style="font-size:11px; color:#9CA3AF; margin:0;">JPG, PNG, atau WEBP. Maks 2MB.</p>
                        </div>
                    </div>
                    <input type="hidden" name="hapus_gambar" id="edit-hapus-gambar" value="0">
                </div>
                <div style="display:flex; gap:10px; padding-top:16px; border-top:1px solid #E5E7EB;">
                    <button type="submit" class="btn-gold">Simpan Perubahan</button>
                    <button type="button" onclick="closeEditModal()" class="btn-ghost">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ===== SEARCH & FILTER =====
        function filterTable() {
            const search = document.getElementById('search-input').value.toLowerCase();
            const kat    = document.getElementById('filter-kategori').value.toLowerCase();
            const rows   = document.querySelectorAll('#product-table tbody tr.product-row');
            let visible  = 0;

            rows.forEach(row => {
                const nama     = row.dataset.nama || '';
                const kategori = row.dataset.kategori || '';
                const matchSearch = nama.includes(search);
                const matchKat    = !kat || kategori.toLowerCase() === kat;
                if (matchSearch && matchKat) { row.style.display = ''; visible++; }
                else { row.style.display = 'none'; }
            });

            document.getElementById('product-count').textContent = `Menampilkan ${visible} produk`;
        }

        // ===== EDIT MODAL =====
        let currentProductId = null;

        function openEditModal(id) {
            currentProductId = id;
            const modal = document.getElementById('edit-modal');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';

            fetch(`/products/${id}/edit`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
            .then(res => res.json())
            .then(p => {
                document.getElementById('edit-kode').value      = p.kode_produk;
                document.getElementById('edit-nama').value      = p.nama_produk;
                document.getElementById('edit-harga').value     = p.harga;
                document.getElementById('edit-stok').value      = p.stok;
                document.getElementById('edit-kategori').value  = p.kategori;
                document.getElementById('edit-deskripsi').value = p.deskripsi ?? '';
                document.getElementById('edit-modal-sub').textContent = p.kode_produk;
                document.getElementById('edit-form').action = `/products/${id}`;

                const img      = document.getElementById('edit-preview-img');
                const icon     = document.getElementById('edit-preview-icon');
                const btnHapus = document.getElementById('btn-hapus-foto');

                if (p.gambar) {
                    img.src = p.gambar;
                    img.style.display = 'block';
                    icon.style.display = 'none';
                    btnHapus.style.display = 'inline-flex';
                } else {
                    img.src = '';
                    img.style.display = 'none';
                    icon.style.display = 'block';
                    btnHapus.style.display = 'none';
                }
            });
        }

        function closeEditModal() {
            document.getElementById('edit-modal').style.display = 'none';
            document.body.style.overflow = '';
            document.getElementById('edit-input-gambar').value = '';
        }

        function previewEditGambar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('edit-preview-img').src = e.target.result;
                    document.getElementById('edit-preview-img').style.display = 'block';
                    document.getElementById('edit-preview-icon').style.display = 'none';
                    document.getElementById('btn-hapus-foto').style.display = 'inline-flex';
                    document.getElementById('edit-hapus-gambar').value = '0';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function hapusFoto() {
            Swal.fire({
                title: 'Hapus Foto?',
                text: 'Foto produk akan dihapus permanen.',
                icon: 'warning',
                background: '#FFFFFF',
                color: '#2E2E2E',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#9CA3AF',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then(result => {
                if (result.isConfirmed) {
                    document.getElementById('edit-hapus-gambar').value = '1';
                    document.getElementById('edit-input-gambar').value = '';
                    document.getElementById('edit-preview-img').src = '';
                    document.getElementById('edit-preview-img').style.display = 'none';
                    document.getElementById('edit-preview-icon').style.display = 'block';
                    document.getElementById('btn-hapus-foto').style.display = 'none';
                }
            });
        }

        function confirmDeleteProduct(id, nama) {
            Swal.fire({
                title: 'Hapus Produk?',
                text: nama + ' akan dihapus permanen.',
                icon: 'warning',
                background: '#FFFFFF',
                color: '#2E2E2E',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#9CA3AF',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then(result => {
                if (result.isConfirmed) {
                    document.getElementById('delete-product-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>