<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
            <div>
                <h2 style="font-family:'Playfair Display',serif; font-size:20px; font-weight:700; color:#1b1c1c; margin:0;">Manajemen QR Code</h2>
                <p style="font-family:'Inter',sans-serif; font-size:12px; color:#43483e; margin:2px 0 0;">Kelola dan kustomisasi kode QR untuk setiap meja.</p>
            </div>
            <button class="no-print" style="display:flex; align-items:center; gap:6px; padding:10px 20px; background:#446435; color:#fff; font-family:'Inter',sans-serif; font-size:12px; font-weight:700; letter-spacing:0.05em; border:none; border-radius:4px; cursor:pointer; box-shadow:0 4px 12px rgba(68,100,53,0.2); transition:all 0.15s;" onmouseover="this.style.background='#5b7e4b'" onmouseout="this.style.background='#446435'">
                <span class="material-symbols-outlined" style="font-size:18px;">add</span>
                TAMBAH MEJA BARU
            </button>
        </div>
    </x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1" rel="stylesheet">

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        @media print {
            .no-print, .sidebar, .topbar { display: none !important; }
            body { background: white !important; }
        }
        .card-light {
            background-color: #ffffff;
            border: 1px solid #c3c8bb;
            transition: all 0.3s ease;
        }
        .card-light:hover {
            box-shadow: 0px 8px 24px rgba(68,100,53,0.08);
            border-color: #446435;
        }
        .sage-pulse {
            animation: sage-pulse-anim 2s cubic-bezier(0.4,0,0.6,1) infinite;
        }
        @keyframes sage-pulse-anim {
            0%,100% { opacity:1; }
            50% { opacity:.6; }
        }
        .custom-scrollbar::-webkit-scrollbar { width:6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background:#f6f3f2; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background:#c3c8bb; border-radius:10px; }
    </style>

    {{-- Main Grid --}}
    <div style="display:grid; grid-template-columns:7fr 5fr; gap:24px; align-items:start;">

        {{-- LEFT: Preview + Opsi Cetak --}}
        <div style="display:flex; flex-direction:column; gap:24px;">

            {{-- Preview Card --}}
            <div class="card-light" style="padding:32px; border-radius:12px; position:relative; overflow:hidden; background:#fff;">
                {{-- BG Decoration --}}
                <div style="position:absolute; top:0; right:0; width:256px; height:256px; background:rgba(68,100,53,0.05); border-radius:50%; filter:blur(60px); margin-right:-128px; margin-top:-128px; pointer-events:none;"></div>

                <div style="display:flex; gap:40px; align-items:center;">

                    {{-- QR Preview Print Card --}}
                    <div id="qr-preview-card" style="width:260px; flex-shrink:0; background:#fff; padding:24px; border-radius:16px; box-shadow:0 20px 40px rgba(0,0,0,0.12); border:12px solid #f0eded; display:flex; flex-direction:column; align-items:center; justify-content:space-between; min-height:400px; position:relative;">
                        <div style="text-align:center; margin-bottom:16px;">
                            <p style="font-family:'Playfair Display',serif; color:#446435; font-size:20px; font-weight:700; text-transform:uppercase; letter-spacing:0.15em; margin:0 0 2px;">SoChan</p>
                            <p style="font-family:'Inter',sans-serif; font-size:9px; font-weight:700; color:rgba(67,72,62,0.6); letter-spacing:0.2em; text-transform:uppercase; margin:0;">Solo & Taichan</p>
                        </div>

                        {{-- QR Area --}}
                        <div style="padding:8px; background:#fff; border-radius:12px; border:4px solid rgba(68,100,53,0.1);">
                            <div style="width:160px; height:160px; background:#fff; display:flex; align-items:center; justify-content:center; position:relative;">
                                {{-- Real SVG QR dari library --}}
                                <div id="qr-preview-svg" style="width:160px; height:160px; display:flex; align-items:center; justify-content:center;">
                                    {{-- Default: tampilkan QR meja pertama --}}
                                    {!! array_values((array)$qrcodes)[0] ?? '' !!}
                                </div>

                            </div>
                        </div>

                        <div style="margin-top:20px; text-align:center;">
                            <h3 id="preview-label" style="font-family:'Playfair Display',serif; font-size:28px; font-weight:700; color:#1b1c1c; margin:0 0 6px;">MEJA {{ array_key_first((array)$qrcodes) }}</h3>
                            <div style="display:inline-flex; align-items:center; gap:6px; padding:6px 14px; background:rgba(68,100,53,0.1); border-radius:99px;">
                                <span class="material-symbols-outlined" style="color:#446435; font-size:14px;">charging_station</span>
                                <p style="font-family:'Inter',sans-serif; font-size:10px; font-weight:700; color:#446435; letter-spacing:0.15em; text-transform:uppercase; font-style:italic; margin:0;">Scan untuk Pesan</p>
                            </div>
                        </div>

                        <div style="margin-top:14px; width:100%; height:1px; background:rgba(195,200,187,0.5);"></div>
                        <p style="margin-top:6px; font-family:'Inter',sans-serif; font-size:8px; color:rgba(67,72,62,0.5); font-weight:500;">{{ config('app.name') }} • Terminal ID: 01-SoChan</p>
                    </div>

                    {{-- Opsi Cetak --}}
                    <div style="flex:1; display:flex; flex-direction:column; gap:24px;">
                        <div>
                            <h4 style="font-family:'Inter',sans-serif; font-size:12px; font-weight:700; color:#446435; text-transform:uppercase; letter-spacing:0.1em; margin:0 0 14px;">Opsi Cetak</h4>
                            <div style="display:flex; flex-direction:column; gap:10px;">
                                {{-- A4 --}}
                                <button onclick="window.print()" style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; background:#fff; border:1px solid rgba(68,100,53,0.3); border-radius:8px; cursor:pointer; transition:all 0.15s;" onmouseover="this.style.background='rgba(68,100,53,0.05)'" onmouseout="this.style.background='#fff'">
                                    <div style="display:flex; align-items:center; gap:12px;">
                                        <span class="material-symbols-outlined" style="color:#446435;">description</span>
                                        <div style="text-align:left;">
                                            <p style="font-family:'Inter',sans-serif; font-size:13px; font-weight:600; color:#1b1c1c; margin:0;">Ukuran A4 / A5</p>
                                            <p style="font-family:'Inter',sans-serif; font-size:10px; color:#43483e; margin:0;">Cocok untuk menu berdiri di meja</p>
                                        </div>
                                    </div>
                                    <span class="material-symbols-outlined" style="color:#43483e; font-size:20px;">download</span>
                                </button>
                                {{-- Stiker --}}
                                <button style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; background:#fff; border:1px solid #c3c8bb; border-radius:8px; cursor:pointer; transition:all 0.15s;" onmouseover="this.style.borderColor='rgba(68,100,53,0.3)';this.style.background='rgba(68,100,53,0.05)'" onmouseout="this.style.borderColor='#c3c8bb';this.style.background='#fff'">
                                    <div style="display:flex; align-items:center; gap:12px;">
                                        <span class="material-symbols-outlined" style="color:#43483e;">label</span>
                                        <div style="text-align:left;">
                                            <p style="font-family:'Inter',sans-serif; font-size:13px; font-weight:600; color:#1b1c1c; margin:0;">Stiker (8x8cm)</p>
                                            <p style="font-family:'Inter',sans-serif; font-size:10px; color:#43483e; margin:0;">Tahan air untuk permukaan meja</p>
                                        </div>
                                    </div>
                                    <span class="material-symbols-outlined" style="color:#43483e; font-size:20px;">download</span>
                                </button>
                                {{-- Katalog --}}
                                <button style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; background:#fff; border:1px solid #c3c8bb; border-radius:8px; cursor:pointer; transition:all 0.15s;" onmouseover="this.style.borderColor='rgba(68,100,53,0.3)';this.style.background='rgba(68,100,53,0.05)'" onmouseout="this.style.borderColor='#c3c8bb';this.style.background='#fff'">
                                    <div style="display:flex; align-items:center; gap:12px;">
                                        <span class="material-symbols-outlined" style="color:#43483e;">grid_view</span>
                                        <div style="text-align:left;">
                                            <p style="font-family:'Inter',sans-serif; font-size:13px; font-weight:600; color:#1b1c1c; margin:0;">Katalog Promosi</p>
                                            <p style="font-family:'Inter',sans-serif; font-size:10px; color:#43483e; margin:0;">Format poster sosial media</p>
                                        </div>
                                    </div>
                                    <span class="material-symbols-outlined" style="color:#43483e; font-size:20px;">share</span>
                                </button>
                            </div>
                        </div>

                        <button onclick="window.print()" style="width:100%; padding:14px; background:#446435; color:#fff; font-family:'Inter',sans-serif; font-size:13px; font-weight:700; letter-spacing:0.05em; border:none; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 8px 20px rgba(68,100,53,0.2); transition:all 0.15s; active:transform:scale(0.97);" onmouseover="this.style.background='#5b7e4b'" onmouseout="this.style.background='#446435'">
                            <span class="material-symbols-outlined" style="font-size:20px;">print</span>
                            CETAK SEKARANG
                        </button>
                    </div>
                </div>
            </div>

            {{-- Instruksi --}}
            <div class="card-light" style="padding:20px 24px; border-radius:12px; border-style:dashed; border-color:rgba(68,100,53,0.4); background:#fff; display:flex; align-items:flex-start; gap:16px;">
                <span class="material-symbols-outlined sage-pulse" style="color:#446435; font-size:28px; flex-shrink:0;">info</span>
                <div>
                    <h5 style="font-family:'Inter',sans-serif; font-size:13px; font-weight:700; color:#1b1c1c; margin:0 0 6px;">Cara Penggunaan QR</h5>
                    <ul style="font-family:'Inter',sans-serif; font-size:13px; color:#43483e; padding-left:16px; margin:0; display:flex; flex-direction:column; gap:4px;">
                        <li>Cetak menggunakan bahan stiker vinyl laminasi doff agar tahan panas dan air.</li>
                        <li>Pastikan posisi logo Bara Api berada tepat di tengah area QR.</li>
                        <li>Test scan sebelum menempelkan secara permanen di meja.</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- RIGHT: Daftar Meja --}}
        <div class="card-light" style="border-radius:12px; overflow:hidden; background:#fff; display:flex; flex-direction:column;">
            <div style="padding:20px 24px; border-bottom:1px solid #c3c8bb; display:flex; justify-content:space-between; align-items:center;">
                <h4 style="font-family:'Inter',sans-serif; font-size:12px; font-weight:700; color:#446435; text-transform:uppercase; letter-spacing:0.1em; margin:0;">Daftar Meja</h4>
                <span style="font-family:'Inter',sans-serif; font-size:12px; color:#43483e; padding:4px 10px; background:#f0eded; border-radius:4px;">Total: {{ $jumlahMeja }} Meja</span>
            </div>

            <div class="custom-scrollbar" style="flex:1; overflow-y:auto; max-height:600px;">
                <table style="width:100%; text-align:left; border-collapse:collapse;">
                    <thead style="background:#f6f3f2;">
                        <tr>
                            <th style="padding:10px 24px; font-family:'Inter',sans-serif; font-size:11px; font-weight:700; color:#43483e; text-transform:uppercase; letter-spacing:0.07em;">Label</th>
                            <th style="padding:10px 24px; font-family:'Inter',sans-serif; font-size:11px; font-weight:700; color:#43483e; text-transform:uppercase; letter-spacing:0.07em;">Status</th>
                            <th style="padding:10px 24px; font-family:'Inter',sans-serif; font-size:11px; font-weight:700; color:#43483e; text-transform:uppercase; letter-spacing:0.07em;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($qrcodes as $meja => $qr)
                        <tr onclick="selectMeja({{ $meja }})" style="border-bottom:1px solid rgba(195,200,187,0.3); cursor:pointer; transition:background 0.15s;" onmouseover="this.style.background='rgba(68,100,53,0.05)'" onmouseout="this.style.background='transparent'" id="row-meja-{{ $meja }}">
                            <td style="padding:14px 24px;">
                                <p style="font-family:'Inter',sans-serif; font-size:13px; font-weight:600; color:#1b1c1c; margin:0;">Meja {{ $meja }}</p>
                                <p style="font-family:'Inter',sans-serif; font-size:10px; color:#43483e; margin:0;">Area Makan</p>
                            </td>
                            <td style="padding:14px 24px;">
                                <span style="display:inline-flex; align-items:center; padding:2px 8px; border-radius:4px; font-family:'Inter',sans-serif; font-size:10px; font-weight:700; background:#dcfce7; color:#446435; border:1px solid rgba(68,100,53,0.2);">AKTIF</span>
                            </td>
                            <td style="padding:14px 24px;">
                                <div style="display:flex; gap:10px; align-items:center;">
                                    <span class="material-symbols-outlined" style="font-size:18px; color:#43483e; cursor:pointer; transition:color 0.15s;" onmouseover="this.style.color='#446435'" onmouseout="this.style.color='#43483e'">visibility</span>
                                    <a href="{{ config('app.url') }}/menu?meja={{ $meja }}" target="_blank" style="display:flex;">
                                        <span class="material-symbols-outlined" style="font-size:18px; color:#43483e; cursor:pointer; transition:color 0.15s;" onmouseover="this.style.color='#446435'" onmouseout="this.style.color='#43483e'">download</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Generate form --}}
            <div style="padding:16px 24px; border-top:1px solid #c3c8bb; background:#f6f3f2;" class="no-print">
                <form method="GET" action="{{ route('qrcodes.index') }}" style="display:flex; align-items:center; gap:10px;">
                    <p style="font-family:'Inter',sans-serif; font-size:12px; color:#43483e; margin:0; white-space:nowrap;">Jumlah meja:</p>
                    <input type="number" name="meja" value="{{ $jumlahMeja }}" min="1" max="50"
                           style="width:64px; padding:6px 10px; background:#fff; border:1px solid #c3c8bb; border-radius:6px; font-family:'Inter',sans-serif; font-size:13px; color:#1b1c1c; outline:none;"
                           onfocus="this.style.borderColor='#446435'" onblur="this.style.borderColor='#c3c8bb'">
                    <button type="submit" style="padding:7px 16px; background:#446435; color:#fff; font-family:'Inter',sans-serif; font-size:12px; font-weight:700; border:none; border-radius:6px; cursor:pointer; transition:background 0.15s;" onmouseover="this.style.background='#5b7e4b'" onmouseout="this.style.background='#446435'">
                        Generate
                    </button>
                </form>
            </div>
        </div>

    </div>

    {{-- FAB --}}
    <button class="no-print" style="position:fixed; bottom:32px; right:32px; width:56px; height:56px; background:#446435; color:#fff; border-radius:50%; border:none; box-shadow:0 8px 24px rgba(0,0,0,0.2); display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.15s; z-index:50;" onmouseover="this.style.background='#5b7e4b'" onmouseout="this.style.background='#446435'" title="Scan Test">
        <span class="material-symbols-outlined" style="font-size:28px;">qr_code_scanner</span>
    </button>

    <script>
        // Simpan semua SVG QR dari PHP ke JS object
        const qrData = {
            @foreach($qrcodes as $meja => $qr)
            {{ $meja }}: `{!! addslashes(str_replace(["\n", "\r"], '', $qr)) !!}`,
            @endforeach
        };

        function selectMeja(meja) {
            // Update label
            document.getElementById('preview-label').textContent = 'MEJA ' + String(meja).padStart(2, '0');

            // Update SVG QR preview
            const svgContainer = document.getElementById('qr-preview-svg');
            if (qrData[meja]) {
                svgContainer.innerHTML = qrData[meja];
                // Pastikan SVG mengisi container
                const svg = svgContainer.querySelector('svg');
                if (svg) {
                    svg.style.width  = '160px';
                    svg.style.height = '160px';
                }
            }

            // Reset semua row
            document.querySelectorAll('tbody tr').forEach(row => {
                row.style.background = 'transparent';
                const p = row.querySelector('p:first-child');
                if (p) { p.style.color = '#1b1c1c'; p.style.fontWeight = '600'; }
            });

            // Highlight row yang dipilih
            const currentRow = event.currentTarget;
            currentRow.style.background = 'rgba(68,100,53,0.06)';
            const targetP = currentRow.querySelector('p:first-child');
            if (targetP) { targetP.style.color = '#446435'; targetP.style.fontWeight = '700'; }
        }

        // Set ukuran SVG default (meja pertama)
        document.addEventListener('DOMContentLoaded', () => {
            const svgContainer = document.getElementById('qr-preview-svg');
            const svg = svgContainer?.querySelector('svg');
            if (svg) { svg.style.width = '160px'; svg.style.height = '160px'; }

            // Highlight row pertama by default
            const firstRow = document.querySelector('tbody tr');
            if (firstRow) {
                firstRow.style.background = 'rgba(68,100,53,0.06)';
                const p = firstRow.querySelector('p:first-child');
                if (p) { p.style.color = '#446435'; p.style.fontWeight = '700'; }
            }
        });

        // Fire icon pulse animation
        const qrLogo = document.querySelector('.material-symbols-outlined[style*="local_fire_department"]');
        if (qrLogo) {
            setInterval(() => {
                qrLogo.style.transform = 'scale(1.1)';
                qrLogo.style.transition = 'transform 0.5s ease-in-out';
                setTimeout(() => { qrLogo.style.transform = 'scale(1.0)'; }, 500);
            }, 3000);
        }
    </script>
</x-app-layout>