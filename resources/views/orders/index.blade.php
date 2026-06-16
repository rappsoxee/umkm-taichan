<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
            <h2 class="font-display-lg text-on-surface" style="font-family:'Playfair Display', serif; font-size:20px; font-weight:600; color:#2E2E2E;">Manajemen Pesanan</h2>
            <div style="display:flex; align-items:center; gap:12px;">
                <div id="polling-indicator" style="display:flex; align-items:center; gap:6px; font-size:11px; color:#9CA3AF;">
                    <span id="polling-dot" style="width:7px; height:7px; border-radius:50%; background:#FF7A30; display:inline-block; animation:pulse 2s infinite;"></span>
                    Live
                </div>
            </div>
        </div>
    </x-slot>

    <style>
        @keyframes pulse {
            0%, 100% { opacity:1; }
            50% { opacity:0.3; }
        }
        @keyframes slideInRight {
            from { transform: translateX(120%); opacity:0; }
            to   { transform: translateX(0); opacity:1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity:1; }
            to   { transform: translateX(120%); opacity:0; }
        }
        @keyframes fadeInUp {
            from { transform: translateY(12px); opacity:0; }
            to   { transform: translateY(0); opacity:1; }
        }
        .toast { animation: slideInRight 0.4s cubic-bezier(0.32, 0.72, 0, 1) both; }
        .toast.out { animation: slideOutRight 0.4s cubic-bezier(0.32, 0.72, 0, 1) both; }
        .order-card-new { animation: fadeInUp 0.35s cubic-bezier(0.32,0.72,0,1) both; }

        .order-card {
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 10px;
            padding: 16px;
            transition: border-color 0.2s, transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }
        .order-card:hover {
            border-color: #FF7A30;
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        }
        .order-card.active-glow {
            border-left: 4px solid #FF7A30;
            box-shadow: 0px 4px 20px rgba(255,122,48,0.12);
        }

        .kanban-col {
            min-height: calc(100vh - 260px);
            background: #FAF7F2;
            border-radius: 12px;
            padding: 8px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn-action {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.05em;
            padding: 5px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: transform 0.1s, opacity 0.2s;
        }
        .btn-action:active { transform: scale(0.95); }

        .btn-proses {
            background: #FF7A30;
            color: #fff;
        }
        .btn-proses:hover { background: #E8631C; }
        .btn-selesai {
            background: transparent;
            color: #FF7A30;
            border: 1px solid #FF7A30;
        }
        .btn-selesai:hover {
            background: #FF7A30;
            color: #fff;
        }

        .badge-col {
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.05em;
        }

        .col-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 8px 8px;
        }
        .col-label {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .col-count {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: #9CA3AF;
        }

        .item-line {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            line-height: 20px;
        }
        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #E5E7EB;
            padding-top: 12px;
            margin-top: 12px;
        }
        .card-meta {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: #9CA3AF;
        }
        .card-id {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.05em;
        }
        .card-time {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: #9CA3AF;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .note-block {
            background: #FAF7F2;
            border-left: 2px solid #FF7A30;
            padding: 8px 10px;
            border-radius: 0 6px 6px 0;
            font-size: 12px;
            font-style: italic;
            color: #6B7280;
            margin: 10px 0;
        }
        .progress-bar-wrap {
            width: 100%;
            background: #E5E7EB;
            height: 4px;
            border-radius: 9999px;
            overflow: hidden;
            margin-top: 4px;
        }
        .progress-bar-fill {
            background: #FF7A30;
            height: 100%;
            transition: width 1s;
        }
        .status-done {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 600;
            color: #16A34A;
            letter-spacing: 0.05em;
        }
        .status-cancelled {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 600;
            color: #EF4444;
        }
        .empty-col {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
            color: #D1D5DB;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            text-align: center;
        }

        /* Summary bar */
        .summary-pill {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 500;
        }
        .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }

        /* Select override */
        select.status-select {
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            color: #2E2E2E;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 6px;
            cursor: pointer;
            width: auto;
        }
        select.status-select:focus {
            outline: none;
            border-color: #FF7A30;
        }
    </style>

    {{-- Toast Container --}}
    <div id="toast-container" style="position:fixed; top:20px; right:20px; z-index:9999; display:flex; flex-direction:column; gap:8px; pointer-events:none;"></div>

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
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        });
    </script>
    @endif

    {{-- Page Header --}}
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:24px;">
        <div>
            <h2 style="font-family:'Playfair Display',serif; font-size:32px; font-weight:700; color:#2E2E2E; line-height:1.2; margin:0 0 10px;">Manajemen Pesanan</h2>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <span class="summary-pill">
                    <span class="dot" style="background:#F59E0B;"></span>
                    <span style="color:#B45309;" id="count-pending">{{ $orders->where('status','pending')->count() }}</span>
                    <span style="color:#9CA3AF;">Pending</span>
                </span>
                <span class="summary-pill">
                    <span class="dot" style="background:#FF7A30; animation:pulse 2s infinite;"></span>
                    <span style="color:#FF7A30;" id="count-proses">{{ $orders->where('status','proses')->count() }}</span>
                    <span style="color:#9CA3AF;">Diproses</span>
                </span>
                <span class="summary-pill">
                    <span class="dot" style="background:#22C55E;"></span>
                    <span style="color:#16A34A;" id="count-selesai">{{ $orders->where('status','selesai')->count() }}</span>
                    <span style="color:#9CA3AF;">Selesai</span>
                </span>
            </div>
        </div>
        <div style="display:flex; gap:10px;">
            <button style="display:flex; align-items:center; gap:6px; padding:10px 18px; background:#FFFFFF; border:1px solid #E5E7EB; color:#6B7280; font-family:'Inter',sans-serif; font-size:13px; font-weight:600; letter-spacing:0.04em; border-radius:8px; cursor:pointer;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="20" y2="12"/><line x1="12" y1="18" x2="20" y2="18"/></svg>
                Filter
            </button>
        </div>
    </div>

    {{-- Kanban Board --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:20px;">

        {{-- COLUMN: PENDING --}}
        <div>
            <div class="col-header">
                <span class="col-label" style="color:#B45309;">
                    <span class="dot" style="background:#F59E0B;"></span>
                    Pending
                </span>
                <span class="col-count" id="col-count-pending">{{ $orders->where('status','pending')->count() }}</span>
            </div>
            <div class="kanban-col" id="col-pending">
                @forelse($orders->where('status','pending') as $order)
                <div class="order-card" id="order-card-{{ $order->id }}" data-order-id="{{ $order->id }}" data-status="pending">
                    <div style="display:flex; justify-content:space-between; margin-bottom:12px;">
                        <span class="card-id" style="color:#B45309;">#BA-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                        <span class="card-time">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $order->created_at->format('H:i') }}
                        </span>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:4px; margin-bottom:12px;">
                        @foreach($order->items as $item)
                        <div class="item-line">
                            <span style="color:#2E2E2E;">{{ $item->qty }}× {{ $item->product->nama_produk }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <span class="card-meta">Meja {{ $order->no_meja }} • {{ $order->nama_pemesan }}</span>
                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" style="margin:0;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="proses">
                            <button type="submit" class="btn-action btn-proses">PROSES</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="empty-col" id="empty-pending">Tidak ada pesanan pending.</div>
                @endforelse
            </div>
        </div>

        {{-- COLUMN: PROSES --}}
        <div>
            <div class="col-header">
                <span class="col-label" style="color:#FF7A30;">
                    <span class="dot" style="background:#FF7A30; animation:pulse 2s infinite;"></span>
                    Proses
                </span>
                <span class="col-count" id="col-count-proses">{{ $orders->where('status','proses')->count() }}</span>
            </div>
            <div class="kanban-col" id="col-proses">
                @forelse($orders->where('status','proses') as $order)
                <div class="order-card active-glow" id="order-card-{{ $order->id }}" data-order-id="{{ $order->id }}" data-status="proses">
                    <div style="display:flex; justify-content:space-between; margin-bottom:12px;">
                        <span class="card-id" style="color:#FF7A30;">#BA-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                        <span class="card-time" style="color:#FF7A30;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span class="timer" data-start="0">00:00</span>
                        </span>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:4px; margin-bottom:12px;">
                        @foreach($order->items as $item)
                        <div class="item-line">
                            <span style="color:#2E2E2E;">{{ $item->qty }}× {{ $item->product->nama_produk }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div style="margin-bottom:12px;">
                        <span style="font-family:'Inter',sans-serif; font-size:11px; color:#9CA3AF;">Sedang diproses</span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar-fill" style="width:50%;"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <span class="card-meta">Meja {{ $order->no_meja }} • {{ $order->nama_pemesan }}</span>
                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" style="margin:0;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="btn-action btn-selesai">SELESAI</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="empty-col">Tidak ada pesanan diproses.</div>
                @endforelse
            </div>
        </div>

        {{-- COLUMN: SELESAI --}}
        <div>
            <div class="col-header">
                <span class="col-label" style="color:#16A34A;">
                    <span class="dot" style="background:#22C55E;"></span>
                    Selesai
                </span>
                <span class="col-count" id="col-count-selesai">{{ $orders->where('status','selesai')->count() }}</span>
            </div>
            <div class="kanban-col" id="col-selesai">
                @forelse($orders->where('status','selesai') as $order)
                <div class="order-card" style="opacity:0.7;" id="order-card-{{ $order->id }}" data-order-id="{{ $order->id }}" data-status="selesai">
                    <div style="display:flex; justify-content:space-between; margin-bottom:12px;">
                        <span class="card-id" style="color:#16A34A;">#BA-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                        <span class="card-time">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            {{ $order->created_at->format('H:i') }}
                        </span>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:4px; margin-bottom:12px;">
                        @foreach($order->items as $item)
                        <div class="item-line">
                            <span style="color:#9CA3AF;">{{ $item->qty }}× {{ $item->product->nama_produk }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <span class="card-meta">Meja {{ $order->no_meja }} • {{ $order->nama_pemesan }}</span>
                        <span class="status-done">DITERIMA</span>
                    </div>
                </div>
                @empty
                <div class="empty-col">Belum ada pesanan selesai.</div>
                @endforelse
            </div>
        </div>

        {{-- COLUMN: SEMUA (table view ringkas) --}}
        <div>
            <div class="col-header">
                <span class="col-label" style="color:#9CA3AF;">
                    <span class="dot" style="background:#9CA3AF;"></span>
                    Total
                </span>
                <span class="col-count">{{ $orders->count() }}</span>
            </div>
            <div class="kanban-col" style="padding:12px; gap:0; overflow:auto;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="font-family:'Inter',sans-serif; font-size:11px; font-weight:600; letter-spacing:0.07em; text-transform:uppercase; color:#9CA3AF; text-align:left; padding:0 0 10px; border-bottom:1px solid #E5E7EB;">Order</th>
                            <th style="font-family:'Inter',sans-serif; font-size:11px; font-weight:600; letter-spacing:0.07em; text-transform:uppercase; color:#9CA3AF; text-align:left; padding:0 0 10px; border-bottom:1px solid #E5E7EB;">Meja</th>
                            <th style="font-family:'Inter',sans-serif; font-size:11px; font-weight:600; letter-spacing:0.07em; text-transform:uppercase; color:#9CA3AF; text-align:right; padding:0 0 10px; border-bottom:1px solid #E5E7EB;">Total</th>
                        </tr>
                    </thead>
                    <tbody id="summary-tbody">
                        @forelse($orders as $order)
                        <tr style="border-bottom:1px solid #F1EFE8;">
                            <td style="padding:8px 0; font-family:'Inter',sans-serif; font-size:12px; color:#2E2E2E;">
                                #BA-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}<br>
                                <span style="font-size:11px; color:#9CA3AF;">{{ $order->nama_pemesan }}</span>
                            </td>
                            <td style="padding:8px 0; font-family:'Inter',sans-serif; font-size:12px; color:#6B7280;">{{ $order->no_meja }}</td>
                            <td style="padding:8px 0; font-family:'Inter',sans-serif; font-size:12px; font-weight:600; color:#FF7A30; text-align:right;">
                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="padding:24px 0; text-align:center; color:#D1D5DB; font-family:'Inter',sans-serif; font-size:12px;">Belum ada pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Live FAB --}}
    <div id="pending-badge-fab" style="position:fixed; bottom:32px; right:32px; z-index:50;">
        @if(\App\Models\Order::where('status','pending')->count() > 0)
        <div style="background:#FF7A30; color:#fff; font-family:'Inter',sans-serif; font-size:13px; font-weight:700; padding:12px 20px; border-radius:12px; box-shadow:0px 4px 20px rgba(255,122,48,0.3); display:flex; align-items:center; gap:8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            <span id="fab-pending-count">{{ \App\Models\Order::where('status','pending')->count() }}</span> pending
        </div>
        @endif
    </div>

    <script>
        let lastOrderId = {{ $orders->first()?->id ?? 0 }};

        function showToast(order) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.style.cssText = `
                background: #FFFFFF;
                border: 1px solid rgba(255,122,48,0.3);
                border-radius: 10px;
                padding: 14px 16px;
                min-width: 280px;
                max-width: 320px;
                pointer-events: all;
                box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            `;
            const itemsHtml = order.items.map(i => `${i.nama} ×${i.qty}`).join(', ');
            toast.innerHTML = `
                <div style="display:flex; align-items:flex-start; gap:10px;">
                    <div style="width:32px; height:32px; background:rgba(255,122,48,0.12); border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; border:1px solid rgba(255,122,48,0.2);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#FF7A30" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div style="flex:1;">
                        <p style="font-family:'Inter',sans-serif; font-size:12px; font-weight:600; color:#E8631C; margin:0 0 2px;">Order Baru — Meja ${order.no_meja}</p>
                        <p style="font-family:'Inter',sans-serif; font-size:12px; color:#2E2E2E; margin:0 0 3px;">${order.nama_pemesan}</p>
                        <p style="font-family:'Inter',sans-serif; font-size:11px; color:#9CA3AF; margin:0;">${itemsHtml}</p>
                    </div>
                    <button onclick="this.closest('.toast').remove()" style="background:none; border:none; color:#9CA3AF; cursor:pointer; font-size:18px; padding:0; line-height:1;">×</button>
                </div>
            `;
            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('out');
                setTimeout(() => toast.remove(), 400);
            }, 5000);
        }

        function addOrderCard(order) {
            const col = document.getElementById('col-pending');
            const empty = col.querySelector('.empty-col');
            if (empty) empty.remove();

            const paddedId = String(order.id).padStart(4, '0');
            const itemsHtml = order.items.map(i =>
                `<div class="item-line"><span style="color:#2E2E2E;">${i.qty}× ${i.nama}</span></div>`
            ).join('');

            const card = document.createElement('div');
            card.className = 'order-card order-card-new';
            card.id = `order-card-${order.id}`;
            card.dataset.orderId = order.id;
            card.dataset.status = 'pending';
            card.innerHTML = `
                <div style="display:flex; justify-content:space-between; margin-bottom:12px;">
                    <span class="card-id" style="color:#B45309;">#BA-${paddedId}</span>
                    <span class="card-time">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        ${order.created_at}
                    </span>
                </div>
                <div style="display:flex; flex-direction:column; gap:4px; margin-bottom:12px;">${itemsHtml}</div>
                <div class="card-footer">
                    <span class="card-meta">Meja ${order.no_meja} • ${order.nama_pemesan}</span>
                    <form action="/orders/${order.id}/status" method="POST" style="margin:0;">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="status" value="proses">
                        <button type="submit" class="btn-action btn-proses">PROSES</button>
                    </form>
                </div>
            `;

            col.insertBefore(card, col.firstChild);
            updateColCount('pending', 1);
        }

        function updateColCount(status, delta) {
            const el = document.getElementById(`col-count-${status}`);
            const countEl = document.getElementById(`count-${status}`);
            if (el) el.textContent = parseInt(el.textContent || 0) + delta;
            if (countEl) countEl.textContent = parseInt(countEl.textContent || 0) + delta;
        }

        function updatePendingBadge(count) {
            const fab = document.getElementById('fab-pending-count');
            if (fab) fab.textContent = count;
            const navBadge = document.querySelector('.nav-badge');
            if (navBadge) {
                navBadge.textContent = count;
                navBadge.style.display = count > 0 ? 'inline-flex' : 'none';
            }
        }

        function pollNewOrders() {
            fetch(`/orders/check-new?last_id=${lastOrderId}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.count > 0) {
                    data.new_orders.forEach(order => {
                        addOrderCard(order);
                        showToast(order);
                        if (order.id > lastOrderId) lastOrderId = order.id;
                    });
                }
                updatePendingBadge(data.pending_count);
            })
            .catch(() => {});
        }

        document.addEventListener('DOMContentLoaded', function() {
            setInterval(pollNewOrders, 5000);

            // Hover lift on cards
            document.querySelectorAll('.order-card').forEach(card => {
                card.addEventListener('mouseleave', () => {
                    if (!card.classList.contains('active-glow')) {
                        card.style.transform = 'translateY(0)';
                    }
                });
            });
        });
    </script>
</x-app-layout>