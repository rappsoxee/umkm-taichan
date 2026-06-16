<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
            <div>
                <h2 style="font-family:'Playfair Display',serif; font-size:20px; font-weight:600; color:#2E2E2E; margin:0;">Data Pelanggan</h2>
                <p style="font-size:11px; color:#9CA3AF; margin:2px 0 0; font-family:'Inter',sans-serif;">Kelola basis data pelanggan dan sistem poin reward.</p>
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="display:flex; align-items:center; gap:8px; background:#FFFFFF; border:1px solid #E5E7EB; border-radius:8px; padding:7px 12px;" id="search-wrap">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" placeholder="Cari pelanggan..." id="search-input" oninput="filterTable()"
                           style="background:transparent; border:none; outline:none; font-size:13px; color:#2E2E2E; font-family:'Inter',sans-serif; width:160px;"
                           onfocus="document.getElementById('search-wrap').style.borderColor='#6B8E5A'"
                           onblur="document.getElementById('search-wrap').style.borderColor='#E5E7EB'">
                </div>
                <a href="{{ route('customers.create') }}" style="display:flex; align-items:center; gap:6px; padding:8px 16px; background:#FF7A30; color:#fff; font-family:'Inter',sans-serif; font-size:12px; font-weight:700; letter-spacing:0.05em; text-decoration:none; border-radius:8px; transition:background 0.15s;" onmouseover="this.style.background='#E8631C'" onmouseout="this.style.background='#FF7A30'">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    Tambah Pelanggan
                </a>
            </div>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success', title: 'Berhasil!',
                text: '{{ session('success') }}',
                background: '#FFFFFF', color: '#2E2E2E',
                confirmButtonColor: '#FF7A30', timer: 2500,
                timerProgressBar: true, showConfirmButton: false,
            });
        });
    </script>
    @endif

    <style>
        @keyframes fadeInUp { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }

        .customer-row { animation: fadeInUp 0.3s ease both; transition: background 0.15s; }
        .customer-row:hover { background: #FAF7F2 !important; }
        .customer-row:hover .row-actions { opacity:1; }
        .row-actions { opacity:0.5; transition: opacity 0.15s; display:flex; gap:5px; justify-content:flex-end; }

        .action-btn {
            width:30px; height:30px; border-radius:6px; border:none;
            display:flex; align-items:center; justify-content:center;
            cursor:pointer; transition:all 0.15s; text-decoration:none;
        }
        .action-btn:active { transform:scale(0.92); }
        .action-btn.view   { background:#FAF7F2; color:#6B7280; }
        .action-btn.view:hover { background:#E5E7EB; color:#2E2E2E; }
        .action-btn.edit   { background:rgba(107,142,90,0.1); color:#6B8E5A; }
        .action-btn.edit:hover { background:rgba(107,142,90,0.18); }
        .action-btn.del    { background:rgba(239,68,68,0.1); color:#EF4444; }
        .action-btn.del:hover { background:rgba(239,68,68,0.18); }

        .poin-bar-wrap { background:#E5E7EB; border-radius:9999px; height:3px; width:56px; overflow:hidden; }
        .poin-bar-fill { height:100%; border-radius:9999px; background:#FF7A30; }

        .badge-level {
            font-family:'Inter',sans-serif; font-size:10px; font-weight:700;
            padding:2px 8px; border-radius:9999px; text-transform:uppercase; letter-spacing:0.06em;
        }
        .badge-gold   { background:rgba(255,122,48,0.12); color:#E8631C; border:1px solid rgba(255,122,48,0.25); }
        .badge-silver { background:rgba(107,142,90,0.12); color:#6B8E5A; border:1px solid rgba(107,142,90,0.2); }
        .badge-bronze { background:rgba(245,158,11,0.12); color:#B45309; border:1px solid rgba(245,158,11,0.2); }
        .badge-new    { background:#FAF7F2; color:#9CA3AF; border:1px solid #E5E7EB; }

        .stat-card {
            background:#FFFFFF; border:1px solid #E5E7EB;
            border-radius:8px; padding:12px 20px; text-align:center;
        }

        /* Table */
        .tbl { width:100%; border-collapse:collapse; }
        .tbl thead th {
            font-family:'Inter',sans-serif; font-size:11px; font-weight:600;
            letter-spacing:0.08em; text-transform:uppercase; color:#9CA3AF;
            text-align:left; padding:10px 16px; border-bottom:1px solid #E5E7EB;
        }
        .tbl tbody td { padding:12px 16px; border-bottom:1px solid #F1EFE8; vertical-align:middle; }
    </style>

    @php
        $totalPelanggan   = $customers->count();
        $totalPoin        = $customers->sum('poin');
        $topCustomer      = $customers->sortByDesc('poin')->first();
        $pelangganBerpoin = $customers->where('poin', '>', 0)->count();
    @endphp

    <div style="display:flex; flex-direction:column; gap:16px;">

        {{-- Stats Banner --}}
        <div style="display:grid; grid-template-columns:1fr auto; gap:14px;">
            <div style="background:#FFFFFF; border:1px solid #E5E7EB; border-radius:12px; padding:20px 24px; display:flex; justify-content:space-between; align-items:center; position:relative; overflow:hidden;">
                <div style="position:absolute; inset:0; background:radial-gradient(ellipse 60% 80% at 0% 50%, rgba(255,122,48,0.05) 0%, transparent 70%); pointer-events:none;"></div>
                <div style="position:relative;">
                    <p style="font-family:'Inter',sans-serif; font-size:10px; font-weight:600; color:#9CA3AF; text-transform:uppercase; letter-spacing:0.1em; margin:0 0 4px;">Pelanggan Setia</p>
                    <p style="font-family:'Playfair Display',serif; font-size:18px; font-weight:700; color:#2E2E2E; margin:0 0 3px;">SoChan</p>
                    <p style="font-family:'Inter',sans-serif; font-size:12px; color:#6B7280; margin:0;">Kelola data member dan sistem poin reward</p>
                </div>
                <div style="display:flex; gap:10px; position:relative;">
                    <div class="stat-card">
                        <p style="font-family:'Inter',sans-serif; font-size:9px; font-weight:600; color:#9CA3AF; text-transform:uppercase; letter-spacing:0.1em; margin:0 0 4px;">Total</p>
                        <p style="font-family:'Playfair Display',serif; font-size:22px; font-weight:700; color:#FF7A30; margin:0;">{{ $totalPelanggan }}</p>
                    </div>
                    <div class="stat-card">
                        <p style="font-family:'Inter',sans-serif; font-size:9px; font-weight:600; color:#9CA3AF; text-transform:uppercase; letter-spacing:0.1em; margin:0 0 4px;">Berpoin</p>
                        <p style="font-family:'Playfair Display',serif; font-size:22px; font-weight:700; color:#16A34A; margin:0;">{{ $pelangganBerpoin }}</p>
                    </div>
                    <div class="stat-card">
                        <p style="font-family:'Inter',sans-serif; font-size:9px; font-weight:600; color:#9CA3AF; text-transform:uppercase; letter-spacing:0.1em; margin:0 0 4px;">Total Poin</p>
                        <p style="font-family:'Playfair Display',serif; font-size:22px; font-weight:700; color:#6B8E5A; margin:0;">{{ $totalPoin }}</p>
                    </div>
                </div>
            </div>

            @if($topCustomer && $topCustomer->poin > 0)
            <div style="background:#FFFFFF; border:1px solid rgba(255,122,48,0.25); border-radius:12px; padding:18px 20px; min-width:190px; display:flex; flex-direction:column; justify-content:space-between; box-shadow:0 4px 20px rgba(255,122,48,0.08);">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <p style="font-family:'Inter',sans-serif; font-size:9px; font-weight:700; color:#FF7A30; text-transform:uppercase; letter-spacing:0.15em; margin:0 0 3px;">⭐ Top Member</p>
                        <p style="font-family:'Inter',sans-serif; font-size:13px; font-weight:600; color:#2E2E2E; margin:0;">{{ $topCustomer->nama_pelanggan }}</p>
                    </div>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#FF7A30"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
                <div style="margin-top:12px;">
                    <p style="font-family:'Inter',sans-serif; font-size:10px; color:#9CA3AF; margin:0 0 3px;">Total Poin</p>
                    <p style="font-family:'Playfair Display',serif; font-size:28px; font-weight:700; color:#FF7A30; margin:0; line-height:1;">{{ $topCustomer->poin }}</p>
                    <p style="font-family:'Inter',sans-serif; font-size:10px; color:#9CA3AF; margin:4px 0 0;">≈ Rp {{ number_format(floor($topCustomer->poin / 10) * 15000, 0, ',', '.') }} diskon</p>
                </div>
            </div>
            @endif
        </div>

        {{-- Table Card --}}
        <div style="background:#FFFFFF; border:1px solid #E5E7EB; border-radius:12px; overflow:hidden;">
            <div style="display:flex; justify-content:space-between; align-items:center; padding:16px 20px; border-bottom:1px solid #E5E7EB;">
                <p style="font-family:'Playfair Display',serif; font-size:16px; font-weight:600; color:#2E2E2E; margin:0;">Daftar Pelanggan</p>
                <span id="customer-count" style="font-family:'Inter',sans-serif; font-size:11px; color:#9CA3AF;">{{ $customers->count() }} pelanggan terdaftar</span>
            </div>

            @if($customers->isEmpty())
                <div style="padding:56px; text-align:center; color:#9CA3AF; font-family:'Inter',sans-serif; font-size:13px;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB" stroke-width="1.2" style="display:block; margin:0 auto 12px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Belum ada pelanggan. <a href="{{ route('customers.create') }}" style="color:#FF7A30; text-decoration:underline;">Tambah sekarang</a>
                </div>
            @else
            <div style="overflow-x:auto;">
                <table class="tbl" id="customer-table">
                    <thead>
                        <tr>
                            <th>Pelanggan</th>
                            <th>No. Telepon</th>
                            <th>Level</th>
                            <th>Poin</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $index => $customer)
                        @php
                            $initials = strtoupper(substr($customer->nama_pelanggan, 0, 1)) . strtoupper(substr(strstr($customer->nama_pelanggan, ' '), 1, 1) ?: substr($customer->nama_pelanggan, 1, 1));
                            $poin = $customer->poin ?? 0;
                            if ($poin >= 50)     { $level = 'Gold';   $lClass = 'badge-gold'; }
                            elseif ($poin >= 20) { $level = 'Silver'; $lClass = 'badge-silver'; }
                            elseif ($poin >= 5)  { $level = 'Bronze'; $lClass = 'badge-bronze'; }
                            else                 { $level = 'New';    $lClass = 'badge-new'; }
                            $avatarColors = [
                                ['rgba(255,122,48,0.12)','#E8631C'],
                                ['rgba(107,142,90,0.12)','#6B8E5A'],
                                ['rgba(245,158,11,0.12)','#B45309'],
                                ['rgba(34,197,94,0.12)','#16A34A'],
                                ['rgba(107,114,128,0.12)','#6B7280'],
                            ];
                            $ci = $index % 5;
                        @endphp
                        <tr class="customer-row" data-nama="{{ strtolower($customer->nama_pelanggan) }}" data-telepon="{{ $customer->no_telepon }}" style="animation-delay:{{ $index * 0.04 }}s;">
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div style="width:34px; height:34px; border-radius:50%; background:{{ $avatarColors[$ci][0] }}; border:1px solid #E5E7EB; display:flex; align-items:center; justify-content:center; font-family:'Inter',sans-serif; font-size:11px; font-weight:700; color:{{ $avatarColors[$ci][1] }}; flex-shrink:0;">{{ $initials }}</div>
                                    <div>
                                        <p style="font-family:'Inter',sans-serif; font-size:13px; font-weight:600; color:#2E2E2E; margin:0 0 2px;">{{ $customer->nama_pelanggan }}</p>
                                        <p style="font-family:'Inter',sans-serif; font-size:10px; color:#9CA3AF; margin:0;">Sejak {{ $customer->created_at->format('M Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="font-family:monospace; font-size:13px; color:#6B7280;">{{ $customer->no_telepon }}</td>
                            <td><span class="badge-level {{ $lClass }}">{{ $level }}</span></td>
                            <td>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="font-family:'Inter',sans-serif; font-size:13px; font-weight:700; color:{{ $poin > 0 ? '#FF7A30' : '#D1D5DB' }}; min-width:24px;">{{ $poin }}</span>
                                    @if($poin > 0)
                                    <div class="poin-bar-wrap">
                                        <div class="poin-bar-fill" style="width:{{ min(($poin / max($customers->max('poin'), 1)) * 100, 100) }}%;"></div>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="row-actions">
                                    <a href="{{ route('customers.show', $customer->id) }}" class="action-btn view" title="Detail">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="action-btn edit" title="Edit">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <button onclick="confirmDelete({{ $customer->id }}, '{{ $customer->nama_pelanggan }}')" class="action-btn del" title="Hapus">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                    </button>
                                    <form id="delete-form-{{ $customer->id }}" action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:none;">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding:10px 20px; border-top:1px solid #F1EFE8; display:flex; justify-content:space-between; align-items:center;">
                <span id="customer-count-footer" style="font-family:'Inter',sans-serif; font-size:11px; color:#9CA3AF;">Menampilkan {{ $customers->count() }} pelanggan</span>
                <span style="font-family:'Inter',sans-serif; font-size:11px; color:#D1D5DB;">
                    {{ $customers->where('poin','>=',50)->count() }} Gold ·
                    {{ $customers->where('poin','>=',20)->where('poin','<',50)->count() }} Silver ·
                    {{ $customers->where('poin','>=',5)->where('poin','<',20)->count() }} Bronze
                </span>
            </div>
            @endif
        </div>
    </div>

    <script>
        function filterTable() {
            const search = document.getElementById('search-input').value.toLowerCase();
            const rows   = document.querySelectorAll('#customer-table tbody tr.customer-row');
            let visible  = 0;
            rows.forEach(row => {
                const match = (row.dataset.nama||'').includes(search) || (row.dataset.telepon||'').includes(search);
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            document.getElementById('customer-count').textContent       = visible + ' pelanggan' + (search ? ' ditemukan' : ' terdaftar');
            document.getElementById('customer-count-footer').textContent = 'Menampilkan ' + visible + ' pelanggan';
        }
        function confirmDelete(id, nama) {
            Swal.fire({
                title: 'Hapus Pelanggan?', text: nama + ' akan dihapus permanen.',
                icon: 'warning', background: '#FFFFFF', color: '#2E2E2E',
                showCancelButton: true, confirmButtonColor: '#DC2626',
                cancelButtonColor: '#9CA3AF', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
            }).then(r => { if (r.isConfirmed) document.getElementById('delete-form-' + id).submit(); });
        }
    </script>
</x-app-layout>