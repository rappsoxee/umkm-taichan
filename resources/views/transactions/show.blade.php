<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
            <h2 class="topbar-title">Detail Transaksi</h2>
            <a href="{{ route('transactions.index') }}" class="btn-ghost">
                <span class="material-symbols-outlined" style="font-size:16px;">arrow_back</span>
                Kembali
            </a>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div style="display:grid; grid-template-columns:1.2fr 1fr; gap:16px; align-items:start;">

        {{-- Kiri: Info Transaksi --}}
        <div style="display:flex; flex-direction:column; gap:16px;">

            {{-- Header card dengan invoice besar --}}
            <div class="card-dark" style="position:relative; overflow:hidden; border-color:rgba(255,122,48,0.25);">
                <div class="card-dark-body" style="padding:20px;">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <div>
                            <p style="font-size:10px; font-weight:600; color:#9CA3AF; text-transform:uppercase; letter-spacing:0.1em; margin:0 0 6px;">No. Invoice</p>
                            <p style="font-size:20px; font-weight:700; color:#FF7A30; margin:0; font-family:'Playfair Display',serif;">{{ $transaction->no_invoice }}</p>
                        </div>
                        <span id="badge-status">
                            @if($transaction->status_pembayaran === 'lunas')
                                <span class="badge-selesai">Lunas</span>
                            @else
                                <span class="badge-pending">Belum Lunas</span>
                            @endif
                        </span>
                    </div>
                    <div style="margin-top:18px; padding-top:14px; border-top:1px solid #F1EFE8;">
                        <p style="font-size:11px; color:#9CA3AF; margin:0 0 4px;">Total Pembayaran</p>
                        <p style="font-size:28px; font-weight:700; color:#2E2E2E; margin:0; font-family:'Playfair Display',serif;">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</p>
                    </div>
                </div>
                <span class="material-symbols-outlined" style="position:absolute; right:-10px; bottom:-16px; font-size:110px; opacity:0.05; color:#FF7A30;">receipt_long</span>
            </div>

            {{-- Info detail --}}
            <div class="card-dark">
                <div class="card-dark-header">
                    <p class="card-dark-title">Informasi Transaksi</p>
                </div>
                <div class="card-dark-body" style="display:flex; flex-direction:column; gap:0;">

                    <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #F1EFE8;">
                        <span style="display:flex; align-items:center; gap:8px; font-size:12px; color:#9CA3AF; font-weight:600; text-transform:uppercase; letter-spacing:0.06em;">
                            <span class="material-symbols-outlined" style="font-size:16px;">calendar_today</span>
                            Tanggal
                        </span>
                        <span style="font-size:13px; color:#2E2E2E;">{{ \Carbon\Carbon::parse($transaction->tanggal_transaksi)->format('d F Y') }}</span>
                    </div>

                    <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #F1EFE8;">
                        <span style="display:flex; align-items:center; gap:8px; font-size:12px; color:#9CA3AF; font-weight:600; text-transform:uppercase; letter-spacing:0.06em;">
                            <span class="material-symbols-outlined" style="font-size:16px;">person</span>
                            Pelanggan
                        </span>
                        <div style="display:flex; align-items:center; gap:8px;">
                            @if($transaction->customer)
                                <div style="width:24px; height:24px; border-radius:50%; background:rgba(107,142,90,0.12); border:1px solid rgba(107,142,90,0.2); display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:700; color:#6B8E5A;">
                                    {{ strtoupper(substr($transaction->customer->nama_pelanggan, 0, 2)) }}
                                </div>
                            @endif
                            <span style="font-size:13px; color:#2E2E2E;">{{ $transaction->customer?->nama_pelanggan ?? 'Pelanggan Umum' }}</span>
                        </div>
                    </div>

                    <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; {{ $transaction->catatan ? 'border-bottom:1px solid #F1EFE8;' : '' }}">
                        <span style="display:flex; align-items:center; gap:8px; font-size:12px; color:#9CA3AF; font-weight:600; text-transform:uppercase; letter-spacing:0.06em;">
                            <span class="material-symbols-outlined icon-filled" style="font-size:16px;">{{ $transaction->metode_pembayaran === 'qris' ? 'qr_code_2' : 'payments' }}</span>
                            Metode
                        </span>
                        <span style="font-size:13px; color:#2E2E2E;">{{ $transaction->metode_pembayaran === 'qris' ? 'QRIS' : 'Tunai' }}</span>
                    </div>

                    @if($transaction->catatan)
                    <div style="padding:10px 0;">
                        <span style="display:flex; align-items:center; gap:8px; font-size:12px; color:#9CA3AF; font-weight:600; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:6px;">
                            <span class="material-symbols-outlined" style="font-size:16px;">notes</span>
                            Catatan
                        </span>
                        <p style="font-size:13px; color:#6B7280; margin:0; line-height:1.6;">{{ $transaction->catatan }}</p>
                    </div>
                    @endif

                </div>
            </div>

            {{-- Update Status AJAX --}}
            <div class="card-dark" style="border-color:rgba(255,122,48,0.25);">
                <div class="card-dark-body">
                    <p style="font-size:11px; color:#6B7280; margin:0 0 10px; text-transform:uppercase; letter-spacing:0.08em; font-weight:600;">Update Status Pembayaran</p>
                    <div style="display:flex; gap:8px;">
                        <button onclick="updateStatus('lunas')" class="btn-gold" style="flex:1; justify-content:center;">
                            <span class="material-symbols-outlined" style="font-size:16px;">check_circle</span>
                            Tandai Lunas
                        </button>
                        <button onclick="updateStatus('belum_lunas')" class="btn-danger" style="flex:1; justify-content:center; padding:8px 16px;">
                            <span class="material-symbols-outlined" style="font-size:16px;">schedule</span>
                            Belum Lunas
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kanan: Item Pesanan --}}
        <div class="card-dark">
            <div class="card-dark-header">
                <p class="card-dark-title">Item Pesanan</p>
                <span style="font-size:11px; color:#9CA3AF;">{{ $transaction->items->count() }} item</span>
            </div>
            <div class="card-dark-body" style="padding:0;">
                <table class="table-dark">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th style="text-align:center;">Qty</th>
                            <th style="text-align:right;">Harga</th>
                            <th style="text-align:right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->items as $item)
                        <tr>
                            <td style="color:#2E2E2E; font-weight:500;">{{ $item->product->nama_produk }}</td>
                            <td style="text-align:center; color:#6B7280;">{{ $item->qty }}</td>
                            <td style="text-align:right; color:#6B7280;">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td style="text-align:right; color:#FF7A30; font-weight:600;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="border-top:1px solid #E5E7EB;">
                            <td colspan="3" style="text-align:right; font-size:11px; font-weight:600; color:#6B7280; text-transform:uppercase; letter-spacing:0.08em; padding:14px 16px;">Total</td>
                            <td style="text-align:right; font-size:16px; font-weight:700; color:#FF7A30; padding:14px 16px;">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    <script>
        const transactionId = {{ $transaction->id }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function updateStatus(status) {
            const label = status === 'lunas' ? 'Lunas' : 'Belum Lunas';
            Swal.fire({
                title: 'Update Status?',
                text: 'Tandai transaksi ini sebagai ' + label + '?',
                icon: 'question',
                background: '#FFFFFF',
                color: '#2E2E2E',
                showCancelButton: true,
                confirmButtonColor: '#FF7A30',
                cancelButtonColor: '#9CA3AF',
                confirmButtonText: 'Ya, Update!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (!result.isConfirmed) return;

                fetch(`/transactions/${transactionId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ status_pembayaran: status }),
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const badge = document.getElementById('badge-status');
                        badge.innerHTML = status === 'lunas'
                            ? '<span class="badge-selesai">Lunas</span>'
                            : '<span class="badge-pending">Belum Lunas</span>';
                        Swal.fire({
                            icon: 'success', title: 'Berhasil!', text: 'Status diperbarui ke ' + label,
                            background: '#FFFFFF', color: '#2E2E2E', confirmButtonColor: '#FF7A30',
                            timer: 2000, timerProgressBar: true, showConfirmButton: false,
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal!', text: data.message ?? 'Terjadi kesalahan.', background: '#FFFFFF', color: '#2E2E2E', confirmButtonColor: '#FF7A30' });
                    }
                })
                .catch(() => {
                    Swal.fire({ icon: 'error', title: 'Error!', text: 'Koneksi bermasalah.', background: '#FFFFFF', color: '#2E2E2E', confirmButtonColor: '#FF7A30' });
                });
            });
        }
    </script>
</x-app-layout>