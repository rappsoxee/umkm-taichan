@php
    $pendingCount = \App\Models\Order::where('status','pending')->count();
@endphp

<aside class="sidebar" id="sidebar">

    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <span>SC</span>
        </div>
        <div class="sidebar-logo-text">
            <p class="sidebar-brand">SoChan</p>
            <p class="sidebar-sub">Solo Taichan</p>
        </div>
    </div>

    <nav class="sidebar-nav">
        <p class="nav-label">Menu Utama</p>

        <a href="{{ route('dashboard') }}"
           class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            <span class="nav-text">Dashboard</span>
        </a>

        <a href="{{ route('products.index') }}"
           class="nav-item {{ request()->routeIs('products*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
            <span class="nav-text">Produk</span>
        </a>

        <a href="{{ route('customers.index') }}"
           class="nav-item {{ request()->routeIs('customers*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <span class="nav-text">Pelanggan</span>
        </a>

        <a href="{{ route('transactions.index') }}"
           class="nav-item {{ request()->routeIs('transactions*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            <span class="nav-text">Transaksi</span>
        </a>

        <a href="{{ route('orders.index') }}"
           class="nav-item {{ request()->routeIs('orders*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            <span class="nav-text">Pesanan</span>
            @if($pendingCount > 0)
                <span class="nav-badge">{{ $pendingCount }}</span>
            @endif
        </a>

        <a href="{{ route('laporan.index') }}"
           class="nav-item {{ request()->routeIs('laporan*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            <span class="nav-text">Laporan</span>
        </a>

        <a href="{{ route('qrcodes.index') }}"
           class="nav-item {{ request()->routeIs('qrcodes*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="5" y="5" width="3" height="3" fill="currentColor" stroke="none"/><rect x="16" y="5" width="3" height="3" fill="currentColor" stroke="none"/><rect x="5" y="16" width="3" height="3" fill="currentColor" stroke="none"/><path d="M14 14h2v2h-2z M18 14h2v2h-2z M14 18h2v2h-2z M18 18h2v2h-2z" fill="currentColor" stroke="none"/></svg>
            <span class="nav-text">QR Code</span>
        </a>

        <p class="nav-label" style="margin-top:12px;">Akun</p>

        <a href="{{ route('profile.edit') }}"
           class="nav-item {{ request()->routeIs('profile*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span class="nav-text">Profil</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-item" style="width:100%; background:none; border:none; text-align:left; cursor:pointer;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span class="nav-text">Keluar</span>
            </button>
        </form>
    </nav>

    {{-- Toggle button --}}
    <button class="sidebar-toggle" id="sidebarToggle" title="Toggle sidebar">
        <svg id="toggleIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;transition:transform 0.25s;"><polyline points="9 18 15 12 9 6"/></svg>
    </button>

    @auth
    <div class="sidebar-user">
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div class="sidebar-user-info">
            <p class="user-name">{{ Auth::user()->name }}</p>
            <p class="user-role">Administrator</p>
        </div>
    </div>
    @endauth

</aside>

<script>
    const sidebar    = document.getElementById('sidebar');
    const toggleBtn  = document.getElementById('sidebarToggle');
    const toggleIcon = document.getElementById('toggleIcon');
    const mainContent = document.querySelector('.main-content');

    const EXPANDED_KEY = 'sidebar_expanded';
    const isExpanded   = localStorage.getItem(EXPANDED_KEY) !== 'false';

    function setSidebar(expanded) {
        if (expanded) {
            sidebar.classList.add('expanded');
            if (mainContent) mainContent.style.marginLeft = '220px';
            toggleIcon.style.transform = 'rotate(180deg)';
        } else {
            sidebar.classList.remove('expanded');
            if (mainContent) mainContent.style.marginLeft = '62px';
            toggleIcon.style.transform = 'rotate(0deg)';
        }
        localStorage.setItem(EXPANDED_KEY, expanded);
    }

    setSidebar(isExpanded);

    toggleBtn.addEventListener('click', () => {
        setSidebar(!sidebar.classList.contains('expanded'));
    });
</script>