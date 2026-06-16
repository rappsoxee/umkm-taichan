<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
            <h2 style="font-family:'Playfair Display',serif; font-size:20px; font-weight:600; color:#2E2E2E; margin:0;">Detail Pelanggan</h2>
            <a href="{{ route('customers.index') }}" style="display:flex; align-items:center; gap:6px; padding:7px 14px; background:transparent; border:1px solid #E5E7EB; color:#6B7280; font-family:'Inter',sans-serif; font-size:12px; font-weight:600; text-decoration:none; border-radius:8px; transition:all 0.15s;" onmouseover="this.style.borderColor='#6B8E5A';this.style.color='#6B8E5A'" onmouseout="this.style.borderColor='#E5E7EB';this.style.color='#6B7280'">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <style>
        @keyframes fadeInUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
        .info-card { background:#FFFFFF; border:1px solid #E5E7EB; border-radius:12px; overflow:hidden; animation:fadeInUp 0.3s ease both; }
        .card-header { padding:14px 20px; border-bottom:1px solid #E5E7EB; display:flex; justify-content:space-between; align-items:center; }
        .card-title { font-family:'Playfair Display',serif; font-size:15px; font-weight:600; color:#2E2E2E; margin:0; }
        .card-body { padding:20px; }
        .info-row { margin-bottom:14px; }
        .info-row:last-child { margin-bottom:0; }
        .info-label { font-family:'Inter',sans-serif; font-size:10px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:#9CA3AF; margin:0 0 3px; }
        .info-value { font-family:'Inter',sans-serif; font-size:13px; color:#2E2E2E; margin:0; line-height:1.5; }

        /* Table */
        .tbl { width:100%; border-collapse:collapse; }
        .tbl thead th { font-family:'Inter',sans-serif; font-size:11px; font-weight:600; letter-spacing:0.07em; text-transform:uppercase; color:#9CA3AF; text-align:left; padding:10px 16px; border-bottom:1px solid #E5E7EB; }
        .tbl tbody td { padding:10px 16px; border-bottom:1px solid #F1EFE8; font-family:'Inter',sans-serif; font-size:12px; color:#2E2E2E; vertical-align:middle; }

        .badge-masuk  { background:rgba(34,197,94,0.1); color:#16A34A; border:1px solid rgba(34,197,94,0.2); font-family:'Inter',sans-serif; font-size:10px; font-weight:700; padding:2px 8px; border-radius:9999px; }
        .badge-keluar { background:rgba(239,68,68,0.1); color:#EF4444; border:1px solid rgba(239,68,68,0.2); font-family:'Inter',sans-serif; font-size:10px; font-weight:700; padding:2px 8px; border-radius:9999px; }

        @php
            $poin = $customer->poin ?? 0;
            if ($poin >= 50)     { $level = 'Gold';   $lColor = '#E8631C'; $lBg = 'rgba(255,122,48,0.12)'; $lBorder = 'rgba(255,122,48,0.25)'; }
            elseif ($poin >= 20) { $level = 'Silver'; $lColor = '#6B8E5A'; $lBg = 'rgba(107,142,90,0.12)'; $lBorder = 'rgba(107,142,90,0.2)'; }
            elseif ($poin >= 5)  { $level = 'Bronze'; $lColor = '#B45309'; $lBg = 'rgba(245,158,11,0.12)';  $lBorder = 'rgba(245,158,11,0.2)'; }
            else                 { $level = 'New';    $lColor = '#9CA3AF'; $lBg = '#FAF7F2'; $lBorder = '#E5E7EB'; }
        @endphp
    </style>

    <div style="display:grid; grid-template-columns:280px 1fr; gap:16px; align-items:start;">

        {{-- Kolom Kiri --}}
        <div style="display:flex; flex-direction:column; gap:14px;">

            {{-- Profile Card --}}
            <div class="info-card" style="animation-delay:0s;">
                <div class="card-body" style="text-align:center; padding:28px 20px;">
                    <div style="width:60px; height:60px; border-radius:50%; background:rgba(255,122,48,0.12); border:1px solid rgba(255,122,48,0.25); display:flex; align-items:center; justify-content:center; margin:0 auto 14px; font-family:'Inter',sans-serif; font-size:22px; font-weight:700; color:#E8631C;">
                        {{ strtoupper(substr($customer->nama_pelanggan, 0, 1)) }}
                    </div>
                    <p style="font-family:'Playfair Display',serif; font-size:17px; font-weight:600; color:#2E2E2E; margin:0 0 3px;">{{ $customer->nama_pelanggan }}</p>
                    <p style="font-family:'Inter',sans-serif; font-size:11px; color:#9CA3AF; margin:0 0 14px;">Member sejak {{ $customer->created_at->format('d M Y') }}</p>

                    {{-- Level badge --}}
                    <span style="background:{{ $lBg }}; color:{{ $lColor }}; border:1px solid {{ $lBorder }}; font-family:'Inter',sans-serif; font-size:10px; font-weight:700; padding:3px 12px; border-radius:9999px; text-transform:uppercase; letter-spacing:0.06em;">{{ $level }}</span>

                    {{-- Poin block --}}
                    <div style="background:rgba(255,122,48,0.06); border:1px solid rgba(255,122,48,0.15); border-radius:8px; padding:16px; margin-top:16px;">
                        <p style="font-family:'Inter',sans-serif; font-size:10px; color:#9CA3AF; text-transform:uppercase; letter-spacing:0.08em; margin:0 0 5px;">Total Poin</p>
                        <p style="font-family:'Playfair Display',serif; font-size:32px; font-weight:700; color:#FF7A30; margin:0 0 4px; line-height:1;">{{ $poin }}</p>
                        <p style="font-family:'Inter',sans-serif; font-size:11px; color:#9CA3AF; margin:0;">
                            = diskon Rp {{ number_format(\App\Models\Customer::hitungDiskon($poin), 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Info Detail --}}
            <div class="info-card" style="animation-delay:0.08s;">
                <div class="card-header">
                    <p class="card-title">Informasi</p>
                    <a href="{{ route('customers.edit', $customer->id) }}" style="font-family:'Inter',sans-serif; font-size:11px; font-weight:600; color:#FF7A30; text-decoration:none; padding:4px 10px; border:1px solid rgba(255,122,48,0.25); border-radius:6px; transition:all 0.15s;" onmouseover="this.style.background='rgba(255,122,48,0.08)'" onmouseout="this.style.background='transparent'">Edit</a>
                </div>
                <div class="card-body" style="display:flex; flex-direction:column; gap:14px;">
                    <div class="info-row">
                        <p class="info-label">No. Telepon</p>
                        <p class="info-value" style="font-family:monospace;">{{ $customer->no_telepon }}</p>
                    </div>
                    <div class="info-row">
                        <p class="info-label">Email</p>
                        <p class="info-value" style="color:{{ $customer->email ? '#2E2E2E' : '#9CA3AF' }};">{{ $customer->email ?? '—' }}</p>
                    </div>
                    <div class="info-row">
                        <p class="info-label">Alamat</p>
                        <p class="info-value" style="color:{{ $customer->alamat ? '#2E2E2E' : '#9CA3AF' }};">{{ $customer->alamat ?? '—' }}</p>
                    </div>
                    <div class="info-row">
                        <p class="info-label">Total Order</p>
                        <p class="info-value"><span style="color:#FF7A30; font-weight:600;">{{ $customer->orders->count() }}</span> order</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Riwayat Poin --}}
        <div class="info-card" style="animation-delay:0.12s;">
            <div class="card-header">
                <p class="card-title">Riwayat Poin</p>
                <span style="font-family:'Inter',sans-serif; font-size:11px; color:#9CA3AF;">{{ $pointLogs->count() }} transaksi</span>
            </div>

            @if($pointLogs->isEmpty())
                <div style="padding:48px; text-align:center; color:#9CA3AF; font-family:'Inter',sans-serif; font-size:13px;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB" stroke-width="1.2" style="display:block; margin:0 auto 10px;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    Belum ada riwayat poin.
                </div>
            @else
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th style="text-align:center;">Tipe</th>
                            <th style="text-align:right;">Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pointLogs as $log)
                        <tr>
                            <td style="color:#9CA3AF; font-size:11px; white-space:nowrap;">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td style="color:#6B7280; font-size:12px;">{{ $log->keterangan ?? '—' }}</td>
                            <td style="text-align:center;">
                                @if($log->tipe === 'masuk')
                                    <span class="badge-masuk">+ Masuk</span>
                                @else
                                    <span class="badge-keluar">- Keluar</span>
                                @endif
                            </td>
                            <td style="text-align:right; font-weight:700; color:{{ $log->tipe === 'masuk' ? '#16A34A' : '#EF4444' }}; font-size:13px;">
                                {{ $log->tipe === 'masuk' ? '+' : '-' }}{{ $log->jumlah }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Poin summary footer --}}
                <div style="padding:12px 20px; border-top:1px solid #F1EFE8; display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-family:'Inter',sans-serif; font-size:11px; color:#9CA3AF;">
                        +{{ $pointLogs->where('tipe','masuk')->sum('jumlah') }} masuk · -{{ $pointLogs->where('tipe','keluar')->sum('jumlah') }} keluar
                    </span>
                    <span style="font-family:'Inter',sans-serif; font-size:12px; font-weight:700; color:#FF7A30;">
                        Saldo: {{ $poin }} poin
                    </span>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>