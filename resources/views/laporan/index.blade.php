<x-app-layout>
    <x-slot name="header">
        <h2 class="topbar-title">Laporan Penjualan</h2>
    </x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <style>
        .lap-wrap { font-family: 'Inter', sans-serif; }
        .lap-display { font-family: 'Playfair Display', serif; }
        .msym {
            font-family: 'Material Symbols Outlined';
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
            line-height: 1;
        }

        .lap-card {
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 14px;
            transition: box-shadow 0.25s ease, border-color 0.25s ease;
        }
        .lap-card:hover {
            border-color: #FFD3B6;
            box-shadow: 0 8px 28px rgba(255, 122, 48, 0.08);
        }

        .lap-pill {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 999px;
            font-size: 11px; font-weight: 700; letter-spacing: 0.03em;
        }

        .lap-input {
            background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 10px;
            padding: 9px 14px; font-size: 13px; color: #2E2E2E;
            outline: none; transition: border-color 0.2s ease;
        }
        .lap-input:focus { border-color: #FF7A30; box-shadow: 0 0 0 3px rgba(255,122,48,0.1); }

        .lap-btn-primary {
            background: #FF7A30;
            color: #FFFFFF; font-weight: 700; font-size: 13px;
            padding: 10px 20px; border-radius: 10px;
            display: inline-flex; align-items: center; gap: 6px;
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
            box-shadow: 0 4px 16px rgba(255, 122, 48, 0.25);
        }
        .lap-btn-primary:hover { background: #E8631C; transform: translateY(-1px); box-shadow: 0 6px 22px rgba(255, 122, 48, 0.35); }
        .lap-btn-primary:active { transform: translateY(0); }

        .lap-btn-ghost {
            background: transparent; border: 1px solid #E5E7EB; color: #6B7280;
            font-weight: 600; font-size: 13px; padding: 10px 18px; border-radius: 10px;
            display: inline-flex; align-items: center; gap: 6px;
            transition: all 0.15s ease;
        }
        .lap-btn-ghost:hover { border-color: #FF7A30; color: #FF7A30; background: rgba(255,122,48,0.06); }

        .lap-table th {
            font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;
            color: #9CA3AF; padding: 12px 18px; text-align: left; border-bottom: 1px solid #E5E7EB;
        }
        .lap-table td { padding: 14px 18px; font-size: 13px; border-bottom: 1px solid #F1EFE8; color: #2E2E2E; }
        .lap-table tbody tr:hover { background: #FAF7F2; }
        .lap-table tbody tr:last-child td { border-bottom: none; }

        /* Bar chart */
        .lap-bar-wrap { height: 200px; display: flex; align-items: flex-end; justify-content: space-between; gap: 10px; }
        .lap-bar-col { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; height: 100%; justify-content: flex-end; }
        .lap-bar {
            width: 100%; max-width: 36px; border-radius: 6px 6px 2px 2px;
            background: #E5E7EB; transition: all 0.4s cubic-bezier(.4,0,.2,1);
            position: relative; min-height: 4px;
        }
        .lap-bar.lap-bar-peak {
            background: linear-gradient(180deg, #6B8E5A, #FF7A30);
        }
        .lap-bar-label { font-size: 11px; color: #6B7280; font-weight: 600; }
        .lap-bar-label.peak { color: #FF7A30; }

        /* Status badges */
        .badge-selesai-l { background: rgba(34,197,94,0.1); color: #16A34A; border: 1px solid rgba(34,197,94,0.25); }
        .badge-proses-l  { background: rgba(245,158,11,0.1); color: #B45309; border: 1px solid rgba(245,158,11,0.25); }
        .badge-pending-l { background: rgba(239,68,68,0.1); color: #DC2626; border: 1px solid rgba(239,68,68,0.25); }
    </style>

    <div class="lap-wrap flex flex-col gap-6">

        {{-- ── Subjudul & Filter ──────────────────────────────── --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <p class="text-[#6B7280] text-sm">Pantau performa SoChan dari satu tempat.</p>
            </div>

            <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-wrap items-center gap-2">
                <input type="date" name="dari" value="{{ $dari }}" class="lap-input">
                <span class="text-[#6B7280] text-sm">sampai</span>
                <input type="date" name="sampai" value="{{ $sampai }}" class="lap-input">
                <button type="submit" class="lap-btn-primary">
                    <span class="msym text-[18px]">filter_alt</span> Terapkan
                </button>
                <a href="{{ route('laporan.exportExcel', ['dari' => $dari, 'sampai' => $sampai]) }}" class="lap-btn-ghost">
                    <span class="msym text-[18px]">table_view</span> Excel
                </a>
                <a href="{{ route('laporan.exportPdf', ['dari' => $dari, 'sampai' => $sampai]) }}" class="lap-btn-primary">
                    <span class="msym text-[18px]">picture_as_pdf</span> PDF
                </a>
            </form>
        </div>

        {{-- ── Bento Grid ───────────────────────────────────── --}}
        <div class="grid grid-cols-12 gap-6">

            {{-- Stat Cards --}}
            <div class="col-span-12 lg:col-span-8 grid grid-cols-1 sm:grid-cols-3 gap-6">

                <div class="lap-card p-6 flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <span class="p-2 bg-[#FF7A30]/10 rounded-lg text-[#FF7A30] msym text-[22px]">payments</span>
                    </div>
                    <div class="mt-4">
                        <p class="text-[#6B7280] text-[11px] uppercase tracking-widest font-bold">Total Pendapatan</p>
                        <h3 class="lap-display text-xl font-bold mt-1 text-[#2E2E2E]">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <div class="lap-card p-6 flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <span class="p-2 bg-[#FF7A30]/10 rounded-lg text-[#FF7A30] msym text-[22px]">receipt_long</span>
                    </div>
                    <div class="mt-4">
                        <p class="text-[#6B7280] text-[11px] uppercase tracking-widest font-bold">Total Order</p>
                        <h3 class="lap-display text-xl font-bold mt-1 text-[#2E2E2E]">{{ $totalOrder }}</h3>
                    </div>
                </div>

                <div class="lap-card p-6 flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <span class="p-2 bg-[#FF7A30]/10 rounded-lg text-[#FF7A30] msym text-[22px]">trending_up</span>
                    </div>
                    <div class="mt-4">
                        <p class="text-[#6B7280] text-[11px] uppercase tracking-widest font-bold">Rata-rata / Order</p>
                        <h3 class="lap-display text-xl font-bold mt-1 text-[#2E2E2E]">Rp {{ number_format($rataRata, 0, ',', '.') }}</h3>
                    </div>
                </div>

                {{-- Bar Chart Tren Bulanan --}}
                <div class="col-span-1 sm:col-span-3 lap-card p-7">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h4 class="lap-display text-lg font-bold text-[#2E2E2E]">Tren Pendapatan</h4>
                            <p class="text-[#6B7280] text-xs mt-0.5">6 bulan terakhir</p>
                        </div>
                        <span class="lap-pill bg-[#FF7A30]/10 text-[#FF7A30] border border-[#FF7A30]/25">
                            <span class="msym text-[13px]">local_fire_department</span> Bulanan
                        </span>
                    </div>

                    @php $maxTren = max($dataBulanan) ?: 1; @endphp
                    <div class="lap-bar-wrap">
                        @foreach($labelBulanan as $i => $label)
                            @php
                                $val = $dataBulanan[$i];
                                $heightPct = $maxTren > 0 ? max(4, ($val / $maxTren) * 100) : 4;
                                $isPeak = $val == $maxTren && $val > 0;
                            @endphp
                            <div class="lap-bar-col">
                                <div class="lap-bar {{ $isPeak ? 'lap-bar-peak' : '' }}" style="height: {{ $heightPct }}%;" title="Rp {{ number_format($val, 0, ',', '.') }}"></div>
                                <span class="lap-bar-label {{ $isPeak ? 'peak' : '' }}">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Pie Chart Menu Terlaris --}}
            <div class="col-span-12 lg:col-span-4 lap-card p-7">
                <h4 class="lap-display text-lg font-bold text-[#2E2E2E] mb-1">Menu Terlaris</h4>
                <p class="text-[#6B7280] text-xs mb-7">Berdasarkan jumlah terjual</p>

                @if($produkTerlaris->count() > 0)
                    @php
                        $top = $produkTerlaris->first();
                        $topPct = $totalTerjualSemua > 0 ? round(($top->total_terjual / $totalTerjualSemua) * 100) : 0;

                        // Hitung dasharray untuk tiap segmen pie (circumference = 2*pi*40 ≈ 251.2)
                        $circumference = 251.2;
                        $colors = ['#FF7A30', '#6B8E5A', '#F59E0B', '#9CA3AF', '#D1D5DB'];
                        $offset = 0;
                        $segments = [];
                        foreach($produkTerlaris as $idx => $p) {
                            $pct = $totalTerjualSemua > 0 ? ($p->total_terjual / $totalTerjualSemua) : 0;
                            $segments[] = [
                                'dash'  => $pct * $circumference,
                                'gap'   => $circumference,
                                'offset'=> -$offset,
                                'color' => $colors[$idx] ?? '#D1D5DB',
                            ];
                            $offset += $pct * $circumference;
                        }
                    @endphp

                    <div class="relative w-40 h-40 mx-auto mb-8">
                        <svg class="w-full h-full -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="40" fill="transparent" stroke="#E5E7EB" stroke-width="16"></circle>
                            @foreach($segments as $seg)
                                <circle cx="50" cy="50" r="40" fill="transparent"
                                    stroke="{{ $seg['color'] }}"
                                    stroke-width="16"
                                    stroke-dasharray="{{ $seg['dash'] }} {{ $seg['gap'] }}"
                                    stroke-dashoffset="{{ $seg['offset'] }}"
                                ></circle>
                            @endforeach
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="lap-display text-2xl font-bold text-[#FF7A30]">{{ $topPct }}%</span>
                            <span class="text-[9px] text-[#6B7280] uppercase tracking-widest text-center px-4 mt-1 leading-tight">{{ $top->nama_produk }}</span>
                        </div>
                    </div>

                    <ul class="space-y-3.5">
                        @foreach($produkTerlaris as $idx => $p)
                            <li class="flex items-center justify-between">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background: {{ $colors[$idx] ?? '#D1D5DB' }};"></span>
                                    <span class="text-sm text-[#2E2E2E] truncate">{{ $p->nama_produk }}</span>
                                </div>
                                <span class="text-sm font-semibold text-[#2E2E2E] flex-shrink-0 ml-2">{{ $p->total_terjual }}x</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="flex flex-col items-center justify-center py-16 text-center">
                        <span class="msym text-[40px] text-[#D1D5DB] mb-3">donut_large</span>
                        <p class="text-[#6B7280] text-sm">Belum ada data penjualan<br>di periode ini.</p>
                    </div>
                @endif
            </div>

            {{-- Tabel Detail Transaksi --}}
            <div class="col-span-12 lap-card overflow-hidden">
                <div class="p-7 border-b border-[#E5E7EB] flex justify-between items-center">
                    <div>
                        <h4 class="lap-display text-lg font-bold text-[#2E2E2E]">Detail Transaksi</h4>
                        <p class="text-[#6B7280] text-xs mt-0.5">{{ \Carbon\Carbon::parse($dari)->format('d M') }} — {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}</p>
                    </div>
                    <span class="lap-pill bg-[#F1EFE8] text-[#6B7280]">{{ $totalOrder }} transaksi</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full lap-table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Nama</th>
                                <th>Meja</th>
                                <th>Item</th>
                                <th class="text-right">Total</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td class="text-[#6B7280]">{{ $order->created_at->format('d/m H:i') }}</td>
                                    <td class="font-medium text-[#2E2E2E]">{{ $order->nama_pemesan }}</td>
                                    <td>Meja {{ $order->no_meja }}</td>
                                    <td class="text-[#6B7280] text-xs max-w-[280px] truncate">{{ $order->items->map(fn($i) => $i->product->nama_produk.' x'.$i->qty)->join(', ') }}</td>
                                    <td class="text-right font-semibold text-[#FF7A30]">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if($order->status == 'selesai')
                                            <span class="lap-pill badge-selesai-l">Selesai</span>
                                        @elseif($order->status == 'proses')
                                            <span class="lap-pill badge-proses-l">Proses</span>
                                        @else
                                            <span class="lap-pill badge-pending-l">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-12 text-[#9CA3AF]">
                                        <span class="msym text-[32px] block mb-2">inbox</span>
                                        Tidak ada transaksi di periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>