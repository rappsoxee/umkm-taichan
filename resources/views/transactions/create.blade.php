<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
            <h2 class="topbar-title">Tambah Transaksi</h2>
            <a href="{{ route('transactions.index') }}" class="btn-ghost">
                <span class="material-symbols-outlined" style="font-size:16px;">arrow_back</span>
                Kembali
            </a>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <form method="POST" action="{{ route('transactions.store') }}" id="form-transaksi">
        @csrf

        <div style="display:grid; grid-template-columns:1.2fr 1fr; gap:16px; align-items:start;">

            {{-- Kiri: Info Transaksi --}}
            <div style="display:flex; flex-direction:column; gap:16px;">

                <div class="card-dark">
                    <div class="card-dark-header">
                        <p class="card-dark-title">Informasi Transaksi</p>
                    </div>
                    <div class="card-dark-body" style="display:flex; flex-direction:column; gap:14px;">

                        @if($errors->any())
                        <div class="alert-error">
                            <ul style="margin:0; padding-left:16px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        {{-- Tanggal --}}
                        <div>
                            <label class="label-dark">Tanggal Transaksi <span style="color:#f87171;">*</span></label>
                            <input type="date" name="tanggal_transaksi" value="{{ old('tanggal_transaksi', date('Y-m-d')) }}" class="input-dark">
                        </div>

                        {{-- Pelanggan --}}
                        <div>
                            <label class="label-dark">Pelanggan <span style="color:rgba(255,255,255,0.25); font-weight:400; text-transform:none; letter-spacing:0;">(opsional)</span></label>
                            <select name="customer_id" class="input-dark">
                                <option value="">— Umum / Tanpa Member —</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->nama_pelanggan }} ({{ $customer->no_telepon }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Metode Pembayaran (UI only) --}}
                        <div>
                            <label class="label-dark">Metode Pembayaran</label>
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                                <button type="button" id="metode-tunai" onclick="pilihMetode('tunai')" class="metode-btn metode-active" style="display:flex; align-items:center; justify-content:center; gap:8px; padding:12px; border-radius:10px; border:1px solid rgba(194,120,10,0.3); background:rgba(194,120,10,0.1); color:#e09020; cursor:pointer; font-family:inherit; font-size:13px; font-weight:600; transition:all 0.15s;">
                                    <span class="material-symbols-outlined icon-filled" style="font-size:18px;">payments</span>
                                    Tunai
                                </button>
                                <button type="button" id="metode-qris" onclick="pilihMetode('qris')" class="metode-btn" style="display:flex; align-items:center; justify-content:center; gap:8px; padding:12px; border-radius:10px; border:1px solid rgba(255,255,255,0.08); background:rgba(255,255,255,0.03); color:rgba(255,255,255,0.4); cursor:pointer; font-family:inherit; font-size:13px; font-weight:600; transition:all 0.15s;">
                                    <span class="material-symbols-outlined icon-filled" style="font-size:18px;">qr_code_2</span>
                                    QRIS
                                </button>
                            </div>
                            <input type="hidden" name="metode_pembayaran" id="metode_pembayaran" value="tunai">
                        </div>

                        {{-- Status Pembayaran --}}
                        <div>
                            <label class="label-dark">Status Pembayaran <span style="color:#f87171;">*</span></label>
                            <select name="status_pembayaran" class="input-dark">
                                <option value="lunas" {{ old('status_pembayaran') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="belum_lunas" {{ old('status_pembayaran') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            </select>
                        </div>

                        {{-- Catatan --}}
                        <div>
                            <label class="label-dark">Catatan <span style="color:rgba(255,255,255,0.25); font-weight:400; text-transform:none; letter-spacing:0;">(opsional)</span></label>
                            <textarea name="catatan" rows="2" class="input-dark" placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
                        </div>

                    </div>
                </div>

                {{-- Summary Total --}}
                <div class="card-dark" style="border-color:rgba(194,120,10,0.2);">
                    <div class="card-dark-body">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <p style="font-size:13px; color:rgba(255,255,255,0.4); margin:0;">Total Transaksi</p>
                            <p id="grand-total" style="font-size:22px; font-weight:700; color:#e09020; margin:0; font-family:'Playfair Display',serif;">Rp 0</p>
                        </div>
                        <button type="submit" class="btn-gold" style="width:100%; justify-content:center; margin-top:14px; padding:10px;">
                            <span class="material-symbols-outlined" style="font-size:16px;">save</span>
                            Simpan Transaksi
                        </button>
                    </div>
                </div>

            </div>

            {{-- Kanan: Pilih Produk --}}
            <div class="card-dark">
                <div class="card-dark-header">
                    <p class="card-dark-title">Pilih Produk</p>
                    <button type="button" onclick="tambahBaris()" class="btn-ghost" style="padding:5px 12px; font-size:11px;">
                        <span class="material-symbols-outlined" style="font-size:14px;">add</span>
                        Tambah
                    </button>
                </div>
                <div class="card-dark-body" style="padding:12px;">
                    <div id="product-rows" style="display:flex; flex-direction:column; gap:8px;">
                        <div class="product-row" style="display:grid; grid-template-columns:1fr 80px 32px; gap:8px; align-items:center;">
                            <select name="products[0][id]" class="input-dark product-select" onchange="hitungTotal()">
                                <option value="">— Pilih Produk —</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-harga="{{ $product->harga }}" data-stok="{{ $product->stok }}">
                                        {{ $product->nama_produk }} (Stok: {{ $product->stok }})
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" name="products[0][qty]" class="input-dark product-qty" placeholder="Qty" min="1" value="1" onchange="hitungTotal()" style="text-align:center;">
                            <button type="button" onclick="hapusBaris(this)" style="background:rgba(220,38,38,0.15); border:1px solid rgba(220,38,38,0.2); color:#f87171; border-radius:6px; width:32px; height:36px; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                                <span class="material-symbols-outlined" style="font-size:16px;">close</span>
                            </button>
                        </div>
                    </div>

                    <div id="subtotal-list" style="margin-top:12px; border-top:1px solid rgba(255,255,255,0.05); padding-top:12px; display:flex; flex-direction:column; gap:6px;">
                    </div>
                </div>
            </div>

        </div>
    </form>

    <script>
        let rowIndex = 1;
        const productsData = @json($products->keyBy('id'));

        function pilihMetode(metode) {
            document.getElementById('metode_pembayaran').value = metode;
            const tunai = document.getElementById('metode-tunai');
            const qris = document.getElementById('metode-qris');

            if (metode === 'tunai') {
                tunai.style.border = '1px solid rgba(194,120,10,0.3)';
                tunai.style.background = 'rgba(194,120,10,0.1)';
                tunai.style.color = '#e09020';
                qris.style.border = '1px solid rgba(255,255,255,0.08)';
                qris.style.background = 'rgba(255,255,255,0.03)';
                qris.style.color = 'rgba(255,255,255,0.4)';
            } else {
                qris.style.border = '1px solid rgba(194,120,10,0.3)';
                qris.style.background = 'rgba(194,120,10,0.1)';
                qris.style.color = '#e09020';
                tunai.style.border = '1px solid rgba(255,255,255,0.08)';
                tunai.style.background = 'rgba(255,255,255,0.03)';
                tunai.style.color = 'rgba(255,255,255,0.4)';
            }
        }

        function tambahBaris() {
            const container = document.getElementById('product-rows');
            const options = buildOptions();
            const div = document.createElement('div');
            div.className = 'product-row';
            div.style.cssText = 'display:grid; grid-template-columns:1fr 80px 32px; gap:8px; align-items:center;';
            div.innerHTML = `
                <select name="products[${rowIndex}][id]" class="input-dark product-select" onchange="hitungTotal()">
                    <option value="">— Pilih Produk —</option>
                    ${options}
                </select>
                <input type="number" name="products[${rowIndex}][qty]" class="input-dark product-qty" placeholder="Qty" min="1" value="1" onchange="hitungTotal()" style="text-align:center;">
                <button type="button" onclick="hapusBaris(this)" style="background:rgba(220,38,38,0.15); border:1px solid rgba(220,38,38,0.2); color:#f87171; border-radius:6px; width:32px; height:36px; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                    <span class="material-symbols-outlined" style="font-size:16px;">close</span>
                </button>
            `;
            container.appendChild(div);
            rowIndex++;
        }

        function buildOptions() {
            return Object.values(productsData).map(p =>
                `<option value="${p.id}" data-harga="${p.harga}" data-stok="${p.stok}">${p.nama_produk} (Stok: ${p.stok})</option>`
            ).join('');
        }

        function hapusBaris(btn) {
            const rows = document.querySelectorAll('.product-row');
            if (rows.length <= 1) return;
            btn.closest('.product-row').remove();
            hitungTotal();
        }

        function hitungTotal() {
            let grandTotal = 0;
            const subtotalList = document.getElementById('subtotal-list');
            subtotalList.innerHTML = '';

            document.querySelectorAll('.product-row').forEach(row => {
                const select = row.querySelector('.product-select');
                const qty    = parseInt(row.querySelector('.product-qty').value) || 0;
                const option = select.options[select.selectedIndex];

                if (!select.value) return;

                const harga    = parseInt(option.dataset.harga) || 0;
                const subtotal = harga * qty;
                grandTotal    += subtotal;

                const nama = option.text.split(' (')[0];
                const div  = document.createElement('div');
                div.style.cssText = 'display:flex; justify-content:space-between; font-size:12px; color:rgba(255,255,255,0.5);';
                div.innerHTML = `<span>${nama} × ${qty}</span><span>Rp ${subtotal.toLocaleString('id-ID')}</span>`;
                subtotalList.appendChild(div);
            });

            document.getElementById('grand-total').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
        }

        document.getElementById('form-transaksi').addEventListener('submit', function(e) {
            const rows = document.querySelectorAll('.product-row');
            let valid = false;
            rows.forEach(row => {
                if (row.querySelector('.product-select').value) valid = true;
            });
            if (!valid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Produk kosong!',
                    text: 'Pilih minimal 1 produk.',
                    background: '#1a0f0a',
                    color: 'rgba(255,255,255,0.85)',
                    confirmButtonColor: '#c2780a',
                });
            }
        });
    </script>
</x-app-layout>