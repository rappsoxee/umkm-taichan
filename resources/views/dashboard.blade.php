<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
            <div>
                <h2 class="topbar-title">Dashboard</h2>
                <p style="font-size:12px; color:#6B7280; margin:2px 0 0;">Ringkasan aktivitas operasional hari ini.</p>
            </div>
            <div style="display:flex; gap:10px; align-items:center;">
                <a href="{{ route('qrcodes.index') }}" class="btn-ghost" style="display:inline-flex; align-items:center; gap:6px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="5" y="5" width="3" height="3" fill="currentColor" stroke="none"/><rect x="16" y="5" width="3" height="3" fill="currentColor" stroke="none"/><rect x="5" y="16" width="3" height="3" fill="currentColor" stroke="none"/></svg>
                    Cetak QR
                </a>
                <a href="{{ route('products.create') }}" class="btn-gold" style="display:inline-flex; align-items:center; gap:6px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Produk
                </a>
            </div>
        </div>
    </x-slot>

    <style>
        .stat-card-new {
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 14px;
            padding: 22px 20px;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            cursor: default;
        }
        .stat-card-new:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(107,142,90,0.12);
            border-color: rgba(107,142,90,0.3);
        }
        .stat-card-new .bg-icon {
            position: absolute;
            right: -10px;
            bottom: -10px;
            opacity: 0.04;
            transition: opacity 0.2s;
        }
        .stat-card-new:hover .bg-icon { opacity: 0.08; }

        .stat-icon-wrap {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Strip ringkasan UAS */
        .uas-summary-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }
        .uas-summary-item {
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: border-color 0.2s, transform 0.2s;
        }
        .uas-summary-item:hover {
            border-color: rgba(107,142,90,0.35);
            transform: translateY(-2px);
        }
        .uas-summary-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .uas-summary-label {
            font-size: 10px;
            font-weight: 600;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin: 0 0 2px;
        }
        .uas-summary-value {
            font-size: 18px;
            font-weight: 700;
            color: #2E2E2E;
            margin: 0;
            line-height: 1.2;
        }

        .progress-bar-wrap {
            background: #E5E7EB;
            border-radius: 4px;
            height: 5px;
            overflow: hidden;
            margin-top: 6px;
        }
        .progress-bar-fill {
            height: 100%;
            border-radius: 4px;
            background: #FF7A30;
        }

        .avatar-initials {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255,122,48,0.12);
            border: 1px solid rgba(255,122,48,0.25);
            color: #E8631C;
            font-size: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        @keyframes fadeInUp {
            from { opacity:0; transform:translateY(12px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .fade-up { animation: fadeInUp 0.4s ease both; }

        @media (max-width: 900px) {
            .uas-summary-strip { grid-template-columns: repeat(2, 1fr); }
        }
    </style>

    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- ===== STRIP 4 METRIK WAJIB UAS ===== --}}
        <div class="uas-summary-strip fade-up" style="animation-delay:0s;">

            {{-- Total Produk --}}
            <div class="uas-summary-item">
                <div class="uas-summary-icon" style="background:rgba(99,102,241,0.1);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6366F1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                </div>
                <div>
                    <p class="uas-summary-label">Total Produk</p>
                    <p class="uas-summary-value">{{ $totalProduk }}</p>
                </div>
            </div>

            {{-- Total Pelanggan --}}
            <div class="uas-summary-item">
                <div class="uas-summary-icon" style="background:rgba(107,142,90,0.12);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6B8E5A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <p class="uas-summary-label">Total Pelanggan</p>
                    <p class="uas-summary-value">{{ $totalPelanggan }}</p>
                </div>
            </div>

            {{-- Total Penjualan --}}
            <div class="uas-summary-item">
                <div class="uas-summary-icon" style="background:rgba(255,122,48,0.12);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF7A30" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                </div>
                <div>
                    <p class="uas-summary-label">Total Penjualan</p>
                    <p class="uas-summary-value">{{ $totalPenjualan }}</p>
                </div>
            </div>

            {{-- Total Pendapatan --}}
            <div class="uas-summary-item" style="border-color:rgba(255,122,48,0.3);">
                <div class="uas-summary-icon" style="background:rgba(255,122,48,0.12);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF7A30" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <div>
                    <p class="uas-summary-label">Total Pendapatan</p>
                    <p class="uas-summary-value" style="color:#FF7A30;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
            </div>

        </div>

        {{-- ===== STAT CARDS OPERASIONAL HARIAN ===== --}}
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px;">

            {{-- Pendapatan Hari Ini --}}
            <div class="stat-card-new fade-up" style="animation-delay:0.08s; border-color:rgba(255,122,48,0.3);">
                <svg class="bg-icon" width="80" height="80" viewBox="0 0 24 24" fill="#FF7A30"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z"/></svg>
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:14px;">
                    <div class="stat-icon-wrap" style="background:rgba(255,122,48,0.12);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF7A30" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <span style="font-size:10px; font-weight:600; color:#16A34A; background:rgba(34,197,94,0.1); border-radius:20px; padding:3px 8px;">Hari ini</span>
                </div>
                <p style="font-size:10px; font-weight:600; color:#6B7280; text-transform:uppercase; letter-spacing:0.08em; margin:0 0 5px;">Pendapatan</p>
                <p style="font-size:22px; font-weight:700; color:#FF7A30; margin:0; line-height:1.1;">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
            </div>

            {{-- Order Hari Ini --}}
            <div class="stat-card-new fade-up" style="animation-delay:0.16s;">
                <svg class="bg-icon" width="80" height="80" viewBox="0 0 24 24" fill="#6B8E5A"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/></svg>
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:14px;">
                    <div class="stat-icon-wrap" style="background:rgba(107,142,90,0.12);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6B8E5A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    </div>
                    <span style="font-size:10px; font-weight:600; color:#6B7280; background:#FAF7F2; border-radius:20px; padding:3px 8px;">Order</span>
                </div>
                <p style="font-size:10px; font-weight:600; color:#6B7280; text-transform:uppercase; letter-spacing:0.08em; margin:0 0 5px;">Order Hari Ini</p>
                <p style="font-size:22px; font-weight:700; color:#2E2E2E; margin:0; line-height:1.1;">{{ $orderHariIni }}</p>
            </div>

            {{-- Order Pending --}}
            <div class="stat-card-new fade-up" style="animation-delay:0.24s; {{ $orderPending > 0 ? 'border-color:rgba(239,68,68,0.3);' : '' }}">
                <svg class="bg-icon" width="80" height="80" viewBox="0 0 24 24" fill="{{ $orderPending > 0 ? '#EF4444' : '#F59E0B' }}"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:14px;">
                    <div class="stat-icon-wrap" style="background:{{ $orderPending > 0 ? 'rgba(239,68,68,0.12)' : 'rgba(245,158,11,0.12)' }};">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $orderPending > 0 ? '#EF4444' : '#F59E0B' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    @if($orderPending > 0)
                    <span style="font-size:10px; font-weight:600; color:#DC2626; background:rgba(239,68,68,0.1); border-radius:20px; padding:3px 8px;">⚠ Perlu diproses</span>
                    @else
                    <span style="font-size:10px; font-weight:600; color:#16A34A; background:rgba(34,197,94,0.1); border-radius:20px; padding:3px 8px;">✓ Aman</span>
                    @endif
                </div>
                <p style="font-size:10px; font-weight:600; color:#6B7280; text-transform:uppercase; letter-spacing:0.08em; margin:0 0 5px;">Order Pending</p>
                <p style="font-size:22px; font-weight:700; color:{{ $orderPending > 0 ? '#EF4444' : '#2E2E2E' }}; margin:0; line-height:1.1;">{{ $orderPending }}</p>
            </div>

        </div>

        {{-- ===== GRAFIK + PRODUK TERLARIS ===== --}}
        <div style="display:grid; grid-template-columns:1.6fr 1fr; gap:14px;">

            {{-- Chart --}}
            <div class="card-dark fade-up" style="animation-delay:0.4s;">
                <div class="card-dark-header">
                    <div>
                        <p class="card-dark-title">Tren Pendapatan</p>
                        <p style="font-size:11px; color:#9CA3AF; margin:3px 0 0;">7 hari terakhir</p>
                    </div>
                </div>
                <div class="card-dark-body">
                    <canvas id="chartPendapatan" height="120"></canvas>
                </div>
            </div>

            {{-- Produk Terlaris --}}
            <div class="card-dark fade-up" style="animation-delay:0.48s;">
                <div class="card-dark-header">
                    <p class="card-dark-title">Menu Terlaris</p>
                </div>
                <div class="card-dark-body" style="padding-top:8px;">
                    @php $maxTerjual = $produkTerlaris->max('total_terjual') ?: 1; @endphp
                    @forelse($produkTerlaris as $i => $produk)
                    <div style="margin-bottom:14px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:5px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="width:20px; height:20px; border-radius:50%; background:rgba(255,122,48,0.12); border:1px solid rgba(255,122,48,0.25); color:#E8631C; font-size:10px; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0;">{{ $i+1 }}</span>
                                <p style="font-size:12px; font-weight:500; color:#2E2E2E; margin:0;">{{ $produk->nama_produk }}</p>
                            </div>
                            <span style="font-size:12px; font-weight:700; color:#FF7A30;">{{ $produk->total_terjual }}x</span>
                        </div>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar-fill" style="width:{{ min(($produk->total_terjual / $maxTerjual) * 100, 100) }}%;"></div>
                        </div>
                    </div>
                    @empty
                    <p style="font-size:13px; color:#9CA3AF; text-align:center; padding:20px 0;">Belum ada data.</p>
                    @endforelse
                    <a href="{{ route('products.index') }}" style="display:block; text-align:center; margin-top:8px; font-size:12px; font-weight:600; color:#FF7A30; border:1px solid rgba(255,122,48,0.25); border-radius:8px; padding:8px; text-decoration:none; transition:background 0.15s;" onmouseover="this.style.background='rgba(255,122,48,0.08)'" onmouseout="this.style.background='transparent'">Lihat Semua Menu</a>
                </div>
            </div>

        </div>

        {{-- ===== ORDER TERBARU ===== --}}
        <div class="card-dark fade-up" style="animation-delay:0.55s;">
            <div class="card-dark-header">
                <div>
                    <p class="card-dark-title">Pesanan Terbaru</p>
                </div>
                <a href="{{ route('laporan.index') }}" style="font-size:12px; font-weight:600; color:#FF7A30; text-decoration:none; transition:opacity 0.15s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">Download Laporan →</a>
            </div>
            <div style="overflow-x:auto;">
                <table class="table-dark">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Meja</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orderTerbaru as $order)
                        <tr>
                            <td style="color:#9CA3AF; font-size:11px; font-weight:600;">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <div class="avatar-initials">{{ strtoupper(substr($order->nama_pemesan, 0, 2)) }}</div>
                                    <span style="font-size:13px; font-weight:500; color:#2E2E2E;">{{ $order->nama_pemesan }}</span>
                                </div>
                            </td>
                            <td>Meja {{ $order->no_meja }}</td>
                            <td style="color:#FF7A30; font-weight:600;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td>
                                @if($order->status == 'pending')
                                    <span class="badge-pending">Pending</span>
                                @elseif($order->status == 'diproses')
                                    <span class="badge-diproses">Diproses</span>
                                @else
                                    <span class="badge-selesai">Selesai</span>
                                @endif
                            </td>
                            <td style="color:#9CA3AF; font-size:12px;">{{ $order->created_at->format('d/m H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:32px; color:#9CA3AF;">Belum ada order.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="padding:12px 18px; border-top:1px solid #F1EFE8; display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:11px; color:#9CA3AF;">Menampilkan {{ $orderTerbaru->count() }} pesanan terbaru</span>
                <a href="{{ route('orders.index') }}" style="font-size:12px; font-weight:600; color:#FF7A30; text-decoration:none;">Lihat Semua →</a>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($pendapatan7Hari->pluck('tanggal'));
        const data   = @json($pendapatan7Hari->pluck('total'));
        const allDates = [], allData = [];
        for (let i = 6; i >= 0; i--) {
            const d = new Date();
            d.setDate(d.getDate() - i);
            const dateStr = d.toISOString().split('T')[0];
            const idx = labels.indexOf(dateStr);
            allDates.push(d.toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric' }));
            allData.push(idx !== -1 ? data[idx] : 0);
        }

        new Chart(document.getElementById('chartPendapatan'), {
            type: 'bar',
            data: {
                labels: allDates,
                datasets: [{
                    data: allData,
                    backgroundColor: ctx => {
                        const chart = ctx.chart;
                        const {ctx: c, chartArea} = chart;
                        if (!chartArea) return 'rgba(255,122,48,0.4)';
                        const gradient = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                        gradient.addColorStop(0, 'rgba(255,122,48,0.8)');
                        gradient.addColorStop(1, 'rgba(255,122,48,0.15)');
                        return gradient;
                    },
                    borderColor: '#FF7A30',
                    borderWidth: 1,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#2E2E2E',
                        borderColor: 'rgba(255,122,48,0.3)',
                        borderWidth: 1,
                        titleColor: 'rgba(255,255,255,0.7)',
                        bodyColor: '#FFB088',
                        bodyFont: { weight: '600' },
                        callbacks: { label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID') }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#9CA3AF', font: { size: 11 } },
                        grid: { color: '#F1EFE8' },
                        border: { color: '#E5E7EB' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#9CA3AF', font: { size: 11 }, callback: val => 'Rp ' + val.toLocaleString('id-ID') },
                        grid: { color: '#F1EFE8' },
                        border: { color: '#E5E7EB' }
                    }
                }
            }
        });

        // Micro-interaction hover cards
        document.querySelectorAll('.stat-card-new').forEach(card => {
            card.addEventListener('mouseenter', () => card.style.transform = 'translateY(-3px)');
            card.addEventListener('mouseleave', () => card.style.transform = 'translateY(0)');
        });
    </script>
</x-app-layout>