<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
            <h2 class="topbar-title">Transaksi Penjualan</h2>
            <a href="{{ route('transactions.create') }}" class="btn-gold">
                <span class="material-symbols-outlined" style="font-size:16px;">add</span>
                Tambah Transaksi
            </a>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}',
                background: '#FFFFFF', color: '#2E2E2E', confirmButtonColor: '#FF7A30',
                timer: 3000, timerProgressBar: true, showConfirmButton: false,
            });
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error', title: 'Gagal!', text: '{{ session('error') }}',
                background: '#FFFFFF', color: '#2E2E2E', confirmButtonColor: '#FF7A30',
            });
        });
    </script>
    @endif

    @php
        $totalTransaksi   = $transactions->count();
        $totalPendapatan  = $transactions->sum('total_harga');
        $totalLunas       = $transactions->where('status_pembayaran', 'lunas')->count();
        $totalBelumLunas  = $transactions->where('status_pembayaran', 'belum_lunas')->count();
        $totalQris        = $transactions->where('metode_pembayaran', 'qris')->count();
        $totalTunai       = $transactions->where('metode_pembayaran', 'tunai')->count();
        $persenQris       = $totalTransaksi > 0 ? round(($totalQris / $totalTransaksi) * 100) : 0;
        $rataRata         = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;
    @endphp

    <div style="display:flex; flex-direction:column; gap:16px;">

        {{-- ===== Bento Stat Cards ===== --}}
        <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:14px;">

            {{-- Total Pendapatan --}}
            <div class="card-dark" style="position:relative; overflow:hidden; padding:18px; border-color:rgba(255,122,48,0.25);">
                <p style="font-size:10px; font-weight:600; color:#6B7280; text-transform:uppercase; letter-spacing:0.08em; margin:0 0 8px;">Total Pendapatan</p>
                <h3 style="font-size:22px; font-weight:700; color:#FF7A30; margin:0; font-family:'Playfair Display',serif;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                <div style="margin-top:10px; display:flex; align-items:center; gap:6px; color:#9CA3AF; font-size:11px;">
                    <span class="material-symbols-outlined" style="font-size:14px;">payments</span>
                    Dari {{ $totalTransaksi }} transaksi
                </div>
                <span class="material-symbols-outlined" style="position:absolute; right:-8px; bottom:-12px; font-size:96px; opacity:0.05; color:#FF7A30;">payments</span>
            </div>

            {{-- Total Transaksi --}}
            <div class="card-dark" style="position:relative; overflow:hidden; padding:18px;">
                <p style="font-size:10px; font-weight:600; color:#6B7280; text-transform:uppercase; letter-spacing:0.08em; margin:0 0 8px;">Total Transaksi</p>
                <h3 style="font-size:22px; font-weight:700; color:#2E2E2E; margin:0; font-family:'Playfair Display',serif;">{{ $totalTransaksi }}</h3>
                <div style="margin-top:10px; display:flex; align-items:center; gap:6px; color:#9CA3AF; font-size:11px;">
                    <span class="material-symbols-outlined" style="font-size:14px;">receipt</span>
                    Rata-rata Rp {{ number_format($rataRata, 0, ',', '.') }}
                </div>
                <span class="material-symbols-outlined" style="position:absolute; right:-8px; bottom:-12px; font-size:96px; opacity:0.04; color:#2E2E2E;">receipt_long</span>
            </div>

            {{-- Metode QRIS --}}
            <div class="card-dark" style="position:relative; overflow:hidden; padding:18px;">
                <p style="font-size:10px; font-weight:600; color:#6B7280; text-transform:uppercase; letter-spacing:0.08em; margin:0 0 8px;">Metode QRIS</p>
                <h3 style="font-size:22px; font-weight:700; color:#FF7A30; margin:0; font-family:'Playfair Display',serif;">{{ $persenQris }}%</h3>
                <div style="margin-top:10px; display:flex; align-items:center; gap:6px; color:#9CA3AF; font-size:11px;">
                    <span class="material-symbols-outlined" style="font-size:14px;">qr_code_2</span>
                    {{ $totalQris }} Transaksi Digital
                </div>
                <span class="material-symbols-outlined" style="position:absolute; right:-8px; bottom:-12px; font-size:96px; opacity:0.05; color:#FF7A30;">cell_tower</span>
            </div>

            {{-- Belum Lunas --}}
            <div class="card-dark" style="position:relative; overflow:hidden; padding:18px; {{ $totalBelumLunas > 0 ? 'border-color:rgba(239,68,68,0.25);' : '' }}">
                <p style="font-size:10px; font-weight:600; color:#6B7280; text-transform:uppercase; letter-spacing:0.08em; margin:0 0 8px;">Belum Lunas</p>
                <h3 style="font-size:22px; font-weight:700; color:{{ $totalBelumLunas > 0 ? '#EF4444' : '#2E2E2E' }}; margin:0; font-family:'Playfair Display',serif;">{{ $totalBelumLunas }}</h3>
                <div style="margin-top:10px; display:flex; align-items:center; gap:6px; color:#9CA3AF; font-size:11px;">
                    <span class="material-symbols-outlined" style="font-size:14px;">schedule</span>
                    Menunggu pembayaran
                </div>
                <span class="material-symbols-outlined" style="position:absolute; right:-8px; bottom:-12px; font-size:96px; opacity:0.05; color:#EF4444;">schedule</span>
            </div>
        </div>

        {{-- ===== Search + Filter ===== --}}
        <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:12px;">
            <div style="position:relative; max-width:320px; width:100%;">
                <span class="material-symbols-outlined" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:18px; color:#9CA3AF;">search</span>
                <input type="text" id="search-input" placeholder="Cari invoice atau pelanggan..." class="input-dark" style="padding-left:38px;" oninput="applyFilter()">
            </div>

            <div style="display:flex; flex-wrap:wrap; gap:8px;">
                {{-- Filter Status Pembayaran --}}
                <div style="display:flex; background:#FFFFFF; border:1px solid #E5E7EB; border-radius:10px; padding:4px; gap:2px;">
                    <button onclick="filterStatus('semua', this)" class="filter-status-btn" data-status="semua" style="padding:6px 16px; border-radius:7px; font-size:12px; font-weight:600; border:none; cursor:pointer; font-family:inherit; background:rgba(255,122,48,0.12); color:#E8631C;">Semua</button>
                    <button onclick="filterStatus('lunas', this)" class="filter-status-btn" data-status="lunas" style="padding:6px 16px; border-radius:7px; font-size:12px; font-weight:600; border:none; cursor:pointer; font-family:inherit; background:transparent; color:#9CA3AF;">Lunas</button>
                    <button onclick="filterStatus('belum_lunas', this)" class="filter-status-btn" data-status="belum_lunas" style="padding:6px 16px; border-radius:7px; font-size:12px; font-weight:600; border:none; cursor:pointer; font-family:inherit; background:transparent; color:#9CA3AF;">Belum Lunas</button>
                </div>

                {{-- Filter Metode Pembayaran --}}
                <div style="display:flex; background:#FFFFFF; border:1px solid #E5E7EB; border-radius:10px; padding:4px; gap:2px;">
                    <button onclick="filterMetode('semua', this)" class="filter-metode-btn" data-metode="semua" style="padding:6px 16px; border-radius:7px; font-size:12px; font-weight:600; border:none; cursor:pointer; font-family:inherit; background:rgba(107,142,90,0.12); color:#6B8E5A;">Semua</button>
                    <button onclick="filterMetode('tunai', this)" class="filter-metode-btn" data-metode="tunai" style="padding:6px 16px; border-radius:7px; font-size:12px; font-weight:600; border:none; cursor:pointer; font-family:inherit; background:transparent; color:#9CA3AF;">Tunai</button>
                    <button onclick="filterMetode('qris', this)" class="filter-metode-btn" data-metode="qris" style="padding:6px 16px; border-radius:7px; font-size:12px; font-weight:600; border:none; cursor:pointer; font-family:inherit; background:transparent; color:#9CA3AF;">QRIS</button>
                </div>
            </div>
        </div>

        {{-- ===== Table ===== --}}
        <div class="card-dark" style="overflow:hidden;">
            @if($transactions->isEmpty())
                <div style="padding:48px; text-align:center; color:#9CA3AF; font-size:13px;">
                    Belum ada data transaksi.
                </div>
            @else
                <table class="table-dark">
                    <thead>
                        <tr>
                            <th>No. Invoice</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Metode</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="transaction-rows">
                        @foreach($transactions as $trx)
                        <tr class="trx-row"
                            data-status="{{ $trx->status_pembayaran }}"
                            data-metode="{{ $trx->metode_pembayaran }}"
                            data-search="{{ strtolower($trx->no_invoice . ' ' . ($trx->customer?->nama_pelanggan ?? 'umum')) }}">

                            {{-- No. Invoice --}}
                            <td style="font-weight:600; color:#FF7A30;">
                                {{ $trx->no_invoice }}
                            </td>

                            {{-- Tanggal --}}
                            <td>
                                <span style="display:block; color:#2E2E2E; font-size:13px; line-height:1.4;">{{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('d M Y') }}</span>
                                <span style="display:block; color:#9CA3AF; font-size:11px; line-height:1.4;">{{ $trx->created_at->format('H:i') }} WIB</span>
                            </td>

                            {{-- Pelanggan --}}
                            <td>
                                <div style="display:flex; align-items:center; gap:10px; flex-wrap:nowrap;">
                                    @if($trx->customer)
                                        <div style="width:28px; height:28px; border-radius:50%; background:rgba(107,142,90,0.12); border:1px solid rgba(107,142,90,0.2); display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; color:#6B8E5A; flex-shrink:0; line-height:1;">
                                            {{ strtoupper(substr($trx->customer->nama_pelanggan, 0, 2)) }}
                                        </div>
                                        <span style="color:#2E2E2E; font-weight:500; white-space:nowrap;">{{ $trx->customer->nama_pelanggan }}</span>
                                    @else
                                        <div style="width:28px; height:28px; border-radius:50%; background:#FAF7F2; border:1px solid #E5E7EB; display:flex; align-items:center; justify-content:center; flex-shrink:0; line-height:1;">
                                            <span class="material-symbols-outlined" style="font-size:14px; color:#9CA3AF; vertical-align:middle;">person</span>
                                        </div>
                                        <span style="color:#9CA3AF; white-space:nowrap;">Pelanggan Umum</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Metode --}}
                            <td>
                                @if($trx->metode_pembayaran === 'qris')
                                    <div style="display:flex; align-items:center; gap:6px; color:#6B7280; font-size:12px; flex-wrap:nowrap;">
                                        <span class="material-symbols-outlined icon-filled" style="font-size:15px; color:#FF7A30; flex-shrink:0; vertical-align:middle;">qr_code_2</span>
                                        <span>QRIS</span>
                                    </div>
                                @else
                                    <div style="display:flex; align-items:center; gap:6px; color:#6B7280; font-size:12px; flex-wrap:nowrap;">
                                        <span class="material-symbols-outlined icon-filled" style="font-size:15px; flex-shrink:0; vertical-align:middle;">payments</span>
                                        <span>Tunai</span>
                                    </div>
                                @endif
                            </td>

                            {{-- Total --}}
                            <td style="font-weight:600; color:#2E2E2E; white-space:nowrap;">
                                Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                            </td>

                            {{-- Status --}}
                            <td>
                                @if($trx->status_pembayaran === 'lunas')
                                    <span class="badge-selesai">Lunas</span>
                                @else
                                    <span class="badge-pending">Belum Lunas</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td style="text-align:center;">
                                <div style="display:flex; justify-content:center; align-items:center; gap:6px;">
                                    <a href="{{ route('transactions.show', $trx->id) }}" class="btn-ghost" style="padding:5px 12px; font-size:11px;">
                                        <span class="material-symbols-outlined" style="font-size:14px;">visibility</span>
                                    </a>
                                    <button onclick="confirmDelete({{ $trx->id }}, '{{ $trx->no_invoice }}')" class="btn-danger" style="padding:5px 12px; font-size:11px;">
                                        <span class="material-symbols-outlined" style="font-size:14px;">delete</span>
                                    </button>
                                    <form id="delete-form-{{ $trx->id }}" action="{{ route('transactions.destroy', $trx->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- No results message --}}
                <div id="no-results" style="display:none; padding:48px; text-align:center; color:#9CA3AF; font-size:13px;">
                    Tidak ada transaksi yang cocok.
                </div>

                {{-- Footer info --}}
                <div style="padding:14px 18px; border-top:1px solid #F1EFE8; display:flex; justify-content:space-between; align-items:center;">
                    <p id="footer-count" style="font-size:11px; color:#9CA3AF; margin:0;">Menampilkan {{ $totalTransaksi }} dari {{ $totalTransaksi }} transaksi</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        function confirmDelete(id, invoice) {
            Swal.fire({
                title: 'Hapus Transaksi?',
                text: invoice + ' akan dihapus & stok produk dikembalikan.',
                icon: 'warning',
                background: '#FFFFFF',
                color: '#2E2E2E',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#9CA3AF',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        let currentStatus = 'semua';
        let currentMetode = 'semua';

        function filterStatus(status, btn) {
            currentStatus = status;
            document.querySelectorAll('.filter-status-btn').forEach(b => {
                b.style.background = 'transparent';
                b.style.color = '#9CA3AF';
            });
            btn.style.background = 'rgba(255,122,48,0.12)';
            btn.style.color = '#E8631C';
            applyFilter();
        }

        function filterMetode(metode, btn) {
            currentMetode = metode;
            document.querySelectorAll('.filter-metode-btn').forEach(b => {
                b.style.background = 'transparent';
                b.style.color = '#9CA3AF';
            });
            btn.style.background = 'rgba(107,142,90,0.12)';
            btn.style.color = '#6B8E5A';
            applyFilter();
        }

        function applyFilter() {
            const search = document.getElementById('search-input').value.toLowerCase();
            const rows = document.querySelectorAll('.trx-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const matchStatus = currentStatus === 'semua' || row.dataset.status === currentStatus;
                const matchMetode = currentMetode === 'semua' || row.dataset.metode === currentMetode;
                const matchSearch = row.dataset.search.includes(search);
                if (matchStatus && matchMetode && matchSearch) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const noResults = document.getElementById('no-results');
            const footerCount = document.getElementById('footer-count');
            const total = rows.length;

            if (noResults) noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            if (footerCount) footerCount.textContent = `Menampilkan ${visibleCount} dari ${total} transaksi`;
        }
    </script>
</x-app-layout>