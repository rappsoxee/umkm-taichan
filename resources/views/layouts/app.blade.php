<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SoChan') }} — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=block" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif !important; background: #FAF7F2 !important; color: #2E2E2E !important; letter-spacing: -0.01em; }
        .font-display { font-family: 'Playfair Display', serif; }
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 2px; }
        ::-webkit-scrollbar-thumb:hover { background: #6B8E5A; }

        .admin-layout { display: flex; min-height: 100vh; }

        /* ───── Sidebar ───── */
        .sidebar {
            width: 62px;
            background: #FFFFFF !important;
            border-right: 1px solid #E5E7EB;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 30;
            transition: width 0.25s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden;
        }
        .sidebar.expanded { width: 220px; }

        /* Logo */
        .sidebar-logo {
            padding: 16px 0;
            border-bottom: 1px solid #E5E7EB;
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 62px;
            padding-left: 15px;
            overflow: hidden;
        }
        .sidebar-logo-icon {
            width: 32px;
            height: 32px;
            background: rgba(107,142,90,0.12);
            border: 1px solid rgba(107,142,90,0.3);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .sidebar-logo-icon span {
            font-size: 12px;
            font-weight: 700;
            color: #6B8E5A;
            font-family: 'Playfair Display', serif;
        }
        .sidebar-logo-text { overflow: hidden; white-space: nowrap; }
        .sidebar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 15px;
            font-weight: 700;
            color: #2E2E2E !important;
            margin: 0 0 1px;
            opacity: 0;
            transition: opacity 0.15s;
        }
        .sidebar.expanded .sidebar-brand { opacity: 1; }
        .sidebar-sub {
            font-size: 10px;
            color: #6B7280 !important;
            margin: 0;
            opacity: 0;
            transition: opacity 0.15s;
        }
        .sidebar.expanded .sidebar-sub { opacity: 1; }

        /* Nav */
        .sidebar-nav { padding: 10px 8px; flex: 1; overflow-y: auto; overflow-x: hidden; }
        .nav-label {
            font-size: 9px;
            font-weight: 600;
            color: #9CA3AF !important;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 8px 8px 4px;
            margin: 0;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.15s;
            height: 26px;
        }
        .sidebar.expanded .nav-label { opacity: 1; }
        .nav-item {
            display: flex !important;
            align-items: center;
            gap: 10px;
            padding: 9px 8px;
            border-radius: 8px;
            font-size: 13px;
            color: #6B7280 !important;
            cursor: pointer;
            margin-bottom: 1px;
            transition: background 0.15s, color 0.15s;
            text-decoration: none !important;
            white-space: nowrap;
            overflow: hidden;
        }
        .nav-item:hover { background: #FAF7F2 !important; color: #2E2E2E !important; }
        .nav-item.active { background: rgba(107,142,90,0.12) !important; color: #6B8E5A !important; }
        .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; }
        .nav-item.active svg { stroke: #6B8E5A; }
        .nav-text {
            opacity: 0;
            transition: opacity 0.15s;
            flex: 1;
        }
        .sidebar.expanded .nav-text { opacity: 1; }
        .nav-badge {
            margin-left: auto;
            background: #EF4444 !important;
            color: #fff !important;
            font-size: 9px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
            line-height: 1.4;
            flex-shrink: 0;
            opacity: 0;
            transition: opacity 0.15s;
        }
        .sidebar.expanded .nav-badge { opacity: 1; }

        /* Toggle button */
        .sidebar-toggle {
            margin: 0 8px 8px;
            padding: 8px;
            border-radius: 8px;
            background: #FAF7F2;
            border: 1px solid #E5E7EB;
            color: #6B7280;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s;
            flex-shrink: 0;
        }
        .sidebar-toggle:hover { background: #E5E7EB; color: #2E2E2E; }

        /* User */
        .sidebar-user {
            padding: 10px 10px;
            border-top: 1px solid #E5E7EB;
            display: flex;
            align-items: center;
            gap: 10px;
            overflow: hidden;
            flex-shrink: 0;
        }
        .user-avatar {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: rgba(107,142,90,0.12) !important;
            border: 1px solid rgba(107,142,90,0.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 600;
            color: #6B8E5A !important;
            flex-shrink: 0;
        }
        .sidebar-user-info { overflow: hidden; white-space: nowrap; opacity: 0; transition: opacity 0.15s; }
        .sidebar.expanded .sidebar-user-info { opacity: 1; }
        .user-name { font-size: 12px; font-weight: 600; color: #2E2E2E !important; margin: 0; }
        .user-role { font-size: 10px; color: #6B7280 !important; margin: 0; }

        /* ───── Main ───── */
        .main-content {
            flex: 1;
            margin-left: 62px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.25s cubic-bezier(0.4,0,0.2,1);
        }
        .topbar {
            background: #FFFFFF !important;
            border-bottom: 1px solid #E5E7EB;
            padding: 0 24px;
            height: 71px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 20;
            box-sizing: border-box;
            overflow: hidden;
        }

        .topbar > * {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .topbar-title {
            font-size: 16px;
            font-weight: 600;
            color: #2E2E2E !important;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .topbar-date { font-size: 11px; color: #6B7280 !important; }
        .topbar-actions { display: flex; align-items: center; gap: 8px; }
        .page-content { padding: 24px; flex: 1; }

        /* ───── Cards ───── */
        .card-dark { background: #FFFFFF !important; border: 1px solid #E5E7EB !important; border-radius: 12px !important; overflow: hidden; }
        .card-dark-header { padding: 14px 18px; border-bottom: 1px solid #E5E7EB; display: flex; justify-content: space-between; align-items: center; }
        .card-dark-title { font-size: 13px; font-weight: 600; color: #2E2E2E !important; margin: 0; }
        .card-dark-body { padding: 16px 18px; }

        /* ───── Buttons ───── */
        .btn-gold { background: #FF7A30 !important; color: #fff !important; border: none !important; border-radius: 8px !important; padding: 8px 16px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: inherit; letter-spacing: -0.01em; transition: background 0.15s, transform 0.15s; display: inline-flex !important; align-items: center; gap: 6px; text-decoration: none !important; }
        .btn-gold:hover { background: #E8631C !important; color: #fff !important; }
        .btn-gold:active { transform: scale(0.96); }
        .btn-ghost { background: #FAF7F2 !important; color: #6B7280 !important; border: 1px solid #E5E7EB !important; border-radius: 8px !important; padding: 8px 14px; font-size: 12px; font-weight: 500; cursor: pointer; font-family: inherit; transition: all 0.15s; display: inline-flex !important; align-items: center; gap: 6px; text-decoration: none !important; }
        .btn-ghost:hover { background: #E5E7EB !important; color: #2E2E2E !important; }
        .btn-danger { background: rgba(239,68,68,0.1) !important; color: #EF4444 !important; border: 1px solid rgba(239,68,68,0.2) !important; border-radius: 8px !important; padding: 6px 12px; font-size: 12px; font-weight: 500; cursor: pointer; font-family: inherit; transition: all 0.15s; display: inline-flex !important; align-items: center; text-decoration: none !important; }
        .btn-danger:hover { background: rgba(239,68,68,0.18) !important; }

        /* ───── Table ───── */
        .table-dark { width: 100%; border-collapse: collapse; font-size: 13px; }
        .table-dark thead tr { border-bottom: 1px solid #E5E7EB; }
        .table-dark thead th { padding: 10px 16px; text-align: left; font-size: 10px; font-weight: 600; color: #9CA3AF !important; text-transform: uppercase; letter-spacing: 0.08em; background: transparent !important; }
        .table-dark tbody tr { border-bottom: 1px solid #F1EFE8; transition: background 0.15s; }
        .table-dark tbody tr:hover { background: #FAF7F2 !important; }
        .table-dark tbody tr:last-child { border-bottom: none; }
        .table-dark tbody td { padding: 12px 16px; color: #2E2E2E !important; vertical-align: middle; background: transparent !important; }

        /* ───── Badges ───── */
        .badge-pending { background: rgba(245,158,11,0.12) !important; color: #B45309 !important; font-size: 10px; font-weight: 600; padding: 3px 9px; border-radius: 20px; display: inline-block; }
        .badge-diproses { background: rgba(59,130,246,0.12) !important; color: #2563EB !important; font-size: 10px; font-weight: 600; padding: 3px 9px; border-radius: 20px; display: inline-block; }
        .badge-selesai { background: rgba(34,197,94,0.12) !important; color: #16A34A !important; font-size: 10px; font-weight: 600; padding: 3px 9px; border-radius: 20px; display: inline-block; }

        /* ───── Form ───── */
        .input-dark { background: #FFFFFF !important; border: 1px solid #E5E7EB !important; border-radius: 8px !important; padding: 9px 13px; font-size: 13px; color: #2E2E2E !important; font-family: inherit; width: 100%; outline: none; transition: border-color 0.2s; }
        .input-dark:focus { border-color: #6B8E5A !important; box-shadow: 0 0 0 3px rgba(107,142,90,0.1); }
        .input-dark::placeholder { color: #9CA3AF !important; }
        select.input-dark option { background: #FFFFFF; color: #2E2E2E; }
        .label-dark { display: block; font-size: 11px; font-weight: 600; color: #6B7280 !important; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.08em; }

        /* ───── Alerts ───── */
        .alert-success { background: rgba(34,197,94,0.08) !important; border: 1px solid rgba(34,197,94,0.25) !important; color: #16A34A !important; border-radius: 8px; padding: 12px 16px; font-size: 13px; margin-bottom: 16px; }
        .alert-error { background: rgba(239,68,68,0.08) !important; border: 1px solid rgba(239,68,68,0.25) !important; color: #DC2626 !important; border-radius: 8px; padding: 12px 16px; font-size: 13px; margin-bottom: 16px; }

        /* ───── Stat Cards ───── */
        .stat-card { background: #FFFFFF !important; border: 1px solid #E5E7EB !important; border-radius: 12px; padding: 16px 18px; }
        .stat-card.gold { border-color: rgba(255,122,48,0.3) !important; }
        .stat-label { font-size: 10px; color: #6B7280 !important; text-transform: uppercase; letter-spacing: 0.08em; margin: 0 0 8px; }
        .stat-value { font-size: 22px; font-weight: 600; color: #2E2E2E !important; margin: 0 0 4px; }
        .stat-card.gold .stat-value { color: #FF7A30 !important; }
        .stat-sub { font-size: 11px; color: #9CA3AF !important; margin: 0; }

        /* ───── Toast ───── */
        @keyframes slideInRight { from { transform: translateX(120%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes slideOutRight { from { transform: translateX(0); opacity: 1; } to { transform: translateX(120%); opacity: 0; } }
        .toast-notif { animation: slideInRight 0.4s cubic-bezier(0.32,0.72,0,1) both; }
        .toast-notif.out { animation: slideOutRight 0.4s cubic-bezier(0.32,0.72,0,1) both; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0 !important; }
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
            font-size: 20px;
            line-height: 1;
        }
        .icon-filled { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body>

    <div id="global-toast-container" style="position:fixed; top:20px; right:20px; z-index:9999; display:flex; flex-direction:column; gap:8px; pointer-events:none;"></div>

    <div class="admin-layout">
        @include('layouts.navigation')
        <div class="main-content" id="mainContent">
            @isset($header)
                <div class="topbar">
                    {{ $header }}
                </div>
            @endisset
            <main class="page-content">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        let globalLastOrderId = 0;
        let isFirstPoll = true;

        function showGlobalToast(order) {
            const container = document.getElementById('global-toast-container');
            const toast = document.createElement('div');
            toast.className = 'toast-notif';
            toast.style.cssText = 'background:#FFFFFF; border:1px solid rgba(255,122,48,0.35); box-shadow:0 8px 24px rgba(0,0,0,0.08); border-radius:12px; padding:14px 16px; min-width:280px; max-width:320px; pointer-events:all;';
            const itemsHtml = order.items.map(i => `${i.nama} ×${i.qty}`).join(', ');
            toast.innerHTML = `
                <div style="display:flex; align-items:flex-start; gap:10px;">
                    <div style="width:32px; height:32px; background:rgba(255,122,48,0.12); border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; border:1px solid rgba(255,122,48,0.25);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#FF7A30" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div style="flex:1;">
                        <p style="font-size:12px; font-weight:600; color:#E8631C; margin:0 0 2px;">Order Baru! — Meja ${order.no_meja}</p>
                        <p style="font-size:12px; color:#2E2E2E; margin:0 0 3px;">${order.nama_pemesan}</p>
                        <p style="font-size:11px; color:#6B7280; margin:0 0 6px;">${itemsHtml}</p>
                        <a href="/orders" style="font-size:11px; color:#FF7A30; text-decoration:none; font-weight:600;">Lihat Pesanan →</a>
                    </div>
                    <button onclick="this.closest('.toast-notif').remove()" style="background:none; border:none; color:#9CA3AF; cursor:pointer; font-size:16px; padding:0; line-height:1; pointer-events:all;">×</button>
                </div>
            `;
            container.appendChild(toast);
            setTimeout(() => { toast.classList.add('out'); setTimeout(() => toast.remove(), 400); }, 6000);
        }

        function updateNavBadge(count) {
            const navBadge = document.querySelector('.nav-badge');
            if (count > 0) {
                if (navBadge) { navBadge.textContent = count; navBadge.style.display = 'inline-block'; }
            } else {
                if (navBadge) navBadge.style.display = 'none';
            }
        }

        function pollOrders() {
            fetch(`/orders/check-new?last_id=${globalLastOrderId}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
            .then(res => res.json())
            .then(data => {
                if (isFirstPoll) {
                    if (data.new_orders && data.new_orders.length > 0) globalLastOrderId = Math.max(...data.new_orders.map(o => o.id));
                    isFirstPoll = false;
                } else {
                    if (data.count > 0) {
                        data.new_orders.forEach(order => {
                            showGlobalToast(order);
                            if (order.id > globalLastOrderId) globalLastOrderId = order.id;
                        });
                    }
                }
                if (data.pending_count !== undefined) updateNavBadge(data.pending_count);
            })
            .catch(() => {});
        }

        document.addEventListener('DOMContentLoaded', function() {
            pollOrders();
            setInterval(pollOrders, 5000);
        });
    </script>

</body>
</html>