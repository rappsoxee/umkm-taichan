<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu — Sate Taichan & Es Teh Solo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #FAF7F2;
            min-height: 100vh;
            letter-spacing: -0.01em;
            color: #2E2E2E;
        }
        .font-display { font-family: 'Playfair Display', serif; }
        .msym {
            font-family: 'Material Symbols Outlined';
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
            line-height: 1;
        }
        .msym.fill { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }

        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 10px; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes popIn { 0% { transform: scale(0.85); opacity: 0; } 70% { transform: scale(1.05); } 100% { transform: scale(1); opacity: 1; } }
        @keyframes slideUp { from { transform: translateY(100%); } to { transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        @keyframes bounceSubtle { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-4px); } }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        .fade-in-up { animation: fadeInUp 0.5s ease both; }
        .pop-in     { animation: popIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) both; }
        .slide-up   { animation: slideUp 0.35s cubic-bezier(0.32, 0.72, 0, 1) both; }
        .fade-in    { animation: fadeIn 0.25s ease both; }

        /* ===== Container (mobile-first, max 600px) ===== */
        .app-shell {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            min-height: 100vh;
            padding-bottom: 96px; /* ruang bottom nav */
        }

        /* ===== Header ===== */
        .topbar-sticky {
            position: sticky; top: 0; z-index: 30;
            background: rgba(250,247,242,0.92);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #E5E7EB;
            padding: 14px 16px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .topbar-brand { font-family: 'Playfair Display', serif; font-size: 19px; font-weight: 700; color: #2E2E2E; }
        .topbar-brand em { font-style: italic; color: #FF7A30; }
        .topbar-meja {
            font-size: 11px; font-weight: 600; color: #6B7280;
            background: #FFFFFF; border: 1px solid #E5E7EB;
            border-radius: 50px; padding: 5px 12px;
        }

        /* ===== Banner Carousel ===== */
        .banner-section { padding: 14px 12px 0; }
        .banner-track {
            display: flex; overflow-x: auto; scroll-snap-type: x mandatory;
            gap: 10px; padding-bottom: 4px;
        }
        .banner-slide {
            min-width: 100%; scroll-snap-align: center;
            position: relative; height: 132px; border-radius: 16px;
            overflow: hidden; cursor: pointer;
            background: linear-gradient(135deg, #FFFFFF 0%, #FFF3EA 100%);
            border: 1px solid #FFD3B6;
            display: flex; align-items: flex-end;
        }
        .banner-slide::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at 85% 20%, rgba(255,122,48,0.12), transparent 60%);
        }
        .banner-content { position: relative; z-index: 1; padding: 14px 16px; }
        .banner-tag {
            display: inline-block; font-size: 10px; font-weight: 700; letter-spacing: 0.08em;
            text-transform: uppercase; padding: 3px 10px; border-radius: 50px; margin-bottom: 6px;
        }
        .banner-tag.primary { background: #FF7A30; color: #FFFFFF; }
        .banner-tag.secondary { background: #6B8E5A; color: #FFFFFF; }
        .banner-title { font-size: 16px; font-weight: 700; color: #2E2E2E; margin: 0 0 3px; line-height: 1.25; font-family: 'Playfair Display', serif; }
        .banner-desc { font-size: 11.5px; color: #6B7280; margin: 0; line-height: 1.5; }

        .banner-dots { display: flex; justify-content: center; gap: 6px; padding: 8px 0 2px; }
        .b-dot { height: 5px; width: 6px; border-radius: 3px; background: #E5E7EB; cursor: pointer; transition: all 0.25s ease; }
        .b-dot.active { width: 18px; background: #FF7A30; }

        /* ===== Filter chips ===== */
        .filter-row { display: flex; gap: 8px; overflow-x: auto; padding: 14px 12px 4px; }
        .filter-btn {
            border: none; border-radius: 50px; font-family: inherit; letter-spacing: -0.01em;
            cursor: pointer; white-space: nowrap; transition: all 0.2s ease;
            padding: 7px 18px; font-size: 11.5px; font-weight: 600;
            background: #FFFFFF; color: #6B7280;
            border: 1px solid #E5E7EB;
        }
        .filter-btn.active { background: #FF7A30; color: #FFFFFF; border-color: transparent; }

        /* ===== Section label ===== */
        .section-label {
            font-size: 10px; font-weight: 700; color: #9CA3AF;
            letter-spacing: 0.14em; text-transform: uppercase; margin: 0 0 12px 2px;
        }
        .section-head {
            display: flex; align-items: center; justify-content: space-between;
            margin: 0 2px 12px;
        }
        .section-link {
            display: flex; align-items: center; gap: 2px;
            font-size: 11px; font-weight: 600; color: #FF7A30;
            background: none; border: none; cursor: pointer; font-family: inherit;
        }

        /* ===== Product grid ===== */
        .product-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; padding: 0 12px; }
        .product-card {
            background: #FFFFFF; border-radius: 16px; overflow: hidden;
            border: 1px solid #E5E7EB; display: flex; flex-direction: column;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .product-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); border-color: #FFD3B6; }
        .product-card.in-cart { border-color: #FF7A30; box-shadow: 0 0 0 1px rgba(255,122,48,0.25); }

        .product-img-wrap { width: 100%; aspect-ratio: 1/1; position: relative; overflow: hidden; cursor: pointer; }
        .product-img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; position: relative; z-index: 1; }
        .shimmer-img { background: linear-gradient(90deg, #F1EFE8 25%, #FAF7F2 50%, #F1EFE8 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; }
        .img-loaded { animation: fadeIn 0.4s ease; }
        .product-badge {
            position: absolute; top: 8px; left: 8px; z-index: 2;
            background: rgba(255,255,255,0.85); backdrop-filter: blur(4px);
            color: #2E2E2E; font-size: 9px; font-weight: 700;
            padding: 3px 10px; border-radius: 50px; letter-spacing: 0.02em;
        }

        .product-body { padding: 10px 11px 11px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; }
        .product-name { font-size: 12.5px; font-weight: 600; color: #2E2E2E; line-height: 1.35; margin: 0 0 3px; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .product-sub { font-size: 10.5px; color: #9CA3AF; margin: 0 0 8px; }
        .product-foot { display: flex; align-items: center; justify-content: space-between; margin-top: auto; }
        .product-price { font-size: 13.5px; font-weight: 700; color: #FF7A30; margin: 0; }

        /* Stepper */
        .stepper { display: flex; align-items: center; gap: 8px; }
        .step-btn {
            width: 26px; height: 26px; border-radius: 50%; border: none;
            font-family: inherit; cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: transform 0.15s ease, background 0.2s ease;
            background: #F1EFE8; color: #6B7280;
        }
        .step-btn.add { background: #FF7A30; color: #FFFFFF; }
        .step-btn:active { transform: scale(0.88); }
        .qty-num { transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1); font-size: 13px; font-weight: 700; color: #2E2E2E; min-width: 16px; text-align: center; }
        .qty-num.bump { animation: popIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }

        .add-btn-full {
            width: 100%; background: #FF7A30; color: #FFFFFF; border: none;
            border-radius: 50px; padding: 8px; font-size: 12px; font-weight: 600;
            font-family: inherit; cursor: pointer; transition: all 0.15s ease;
            display: flex; align-items: center; justify-content: center; gap: 4px;
        }
        .add-btn-full:active { transform: scale(0.96); }

        input[type="text"] { color-scheme: light; }
        input::placeholder { color: #9CA3AF; }

        /* ===== Floating Cart Bar ===== */
        .floating-bar {
            position: fixed; bottom: 78px; left: 0; right: 0; z-index:25;
            display: flex; justify-content: center; padding: 0 12px;
        }
        .floating-bar-inner {
            width: 100%; max-width: 576px;
            background: #FF7A30; color: #FFFFFF;
            border-radius: 50px; padding: 12px 10px 12px 20px;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 8px 28px rgba(255,122,48,0.35);
            animation: bounceSubtle 3s infinite ease-in-out;
        }
        .floating-bar-info p { margin: 0; line-height: 1.3; }
        .floating-bar-btn {
            background: #FFFFFF; color: #FF7A30; border: none;
            border-radius: 50px; padding: 10px 20px; font-size: 12.5px; font-weight: 700;
            font-family: inherit; cursor: pointer; display: flex; align-items: center; gap: 6px;
        }

        /* ===== Bottom Nav ===== */
        .bottom-nav {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 30;
            display: flex; justify-content: center;
        }
        .bottom-nav-inner {
            width: 100%; max-width: 600px; height: 72px;
            background: #FFFFFF; border-top: 1px solid #E5E7EB;
            display: flex; align-items: center; justify-content: space-around;
        }
        .nav-btn {
            display: flex; flex-direction: column; align-items: center; gap: 3px;
            background: none; border: none; cursor: pointer; font-family: inherit;
            color: #9CA3AF; font-size: 10.5px; font-weight: 600;
            transition: color 0.15s ease; position: relative; padding: 4px 12px;
        }
        .nav-btn.active { color: #6B8E5A; }
        .nav-badge {
            position: absolute; top: 0; right: 6px;
            background: #FF7A30; color: #FFFFFF; font-size: 9px; font-weight: 700;
            border-radius: 50%; width: 16px; height: 16px;
            display: flex; align-items: center; justify-content: center;
        }

        /* ===== Drawer / Modal generic ===== */
        .drawer-bg { animation: fadeIn 0.25s ease both; position: absolute; inset: 0; background: rgba(46,46,46,0.4); }
        .drawer-box {
            animation: slideUp 0.35s cubic-bezier(0.32, 0.72, 0, 1) both;
            position: absolute; bottom: 0; left: 0; right: 0; max-width: 600px; margin: 0 auto;
            background: #FAF7F2; border-radius: 24px 24px 0 0;
            border: 1px solid #E5E7EB; border-bottom: none;
            max-height: 85vh; overflow-y: auto;
        }
        .drawer-handle { padding: 6px 0 0; display: flex; justify-content: center; }
        .drawer-handle div { width: 36px; height: 4px; background: #E5E7EB; border-radius: 2px; }
        .drawer-pad { padding: 16px 20px 100px; }
        .drawer-title-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .drawer-title { font-size: 20px; color: #2E2E2E; margin: 0; }
        .drawer-close {
            background: #FFFFFF; border: 1px solid #E5E7EB; width: 32px; height: 32px;
            border-radius: 50%; color: #6B7280; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
        }

        .cart-item {
            display: flex; justify-content: space-between; align-items: center;
            background: #FFFFFF; border-radius: 12px; padding: 12px 14px; margin-bottom: 8px;
            border: 1px solid #E5E7EB;
        }
        .cart-total-box {
            background: #FFFFFF; border-radius: 14px; padding: 14px 16px; margin-bottom: 16px;
            border: 1px solid #E5E7EB;
            display: flex; justify-content: space-between; align-items: center;
        }

        .input-field-full {
            width: 100%; border: 1px solid #E5E7EB;
            background: #FFFFFF; border-radius: 12px;
            padding: 12px 14px; font-size: 14px; outline: none; font-family: inherit;
            color: #2E2E2E; transition: border-color 0.2s;
        }
        .input-field-full:focus { border-color: #FF7A30; box-shadow: 0 0 0 3px rgba(255,122,48,0.1); }

        .btn-pill-primary {
            width: 100%; background: #FF7A30; color: #FFFFFF; border: none;
            border-radius: 50px; padding: 14px; font-size: 14px; font-weight: 600;
            font-family: inherit; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-pill-outline {
            width: 100%; background: #FFFFFF; color: #6B7280;
            border: 1px solid #E5E7EB; border-radius: 50px; padding: 13px;
            font-size: 13px; font-weight: 600; font-family: inherit; cursor: pointer;
        }

        .poin-step-num {
            width: 22px; height: 22px; border-radius: 50%;
            background: rgba(255,122,48,0.12); border: 1px solid rgba(255,122,48,0.3);
            color: #E8631C; font-size: 11px; font-weight: 600;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }

        .redeem-opt {
            border: 1px solid #E5E7EB; border-radius: 50px;
            background: #FFFFFF; color: #6B7280;
            padding: 6px 14px; font-size: 11px; font-weight: 600; font-family: inherit;
            cursor: pointer; transition: all 0.15s;
        }
        .redeem-opt.selected { background: rgba(255,122,48,0.12); color: #E8631C; border-color: rgba(255,122,48,0.4); }

        /* ===== Multi Order Sticky Bars ===== */
        .order-stack {
            position: fixed; top: 64px; left: 0; right: 0; z-index: 35;
            display: flex; flex-direction: column; gap: 6px;
            padding: 0 12px; pointer-events: none;
            max-width: 600px; margin: 0 auto;
        }
        .order-bar {
            pointer-events: all;
            display: flex; align-items: center; gap: 10px;
            background: #FFFFFF; border: 1px solid #E5E7EB;
            border-radius: 50px; padding: 8px 14px 8px 10px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            animation: slideDown 0.3s cubic-bezier(0.34,1.56,0.64,1) both;
            transition: border-color 0.4s, box-shadow 0.4s;
            cursor: pointer;
        }
        .order-bar.status-pending  { border-color: #FFD3B6; }
        .order-bar.status-proses   { border-color: #93C5FD; box-shadow: 0 4px 16px rgba(59,130,246,0.15); }
        .order-bar.status-selesai  { border-color: #86EFAC; box-shadow: 0 4px 16px rgba(22,163,74,0.15); }
        .order-bar.status-batal    { border-color: #FCA5A5; }
        .order-bar.pulse { animation: barPulse 0.6s ease; }

        .order-bar-icon {
            width: 28px; height: 28px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; transition: background 0.4s;
        }
        .order-bar-text { flex: 1; min-width: 0; }
        .order-bar-dismiss {
            background: none; border: none; cursor: pointer;
            color: #9CA3AF; padding: 2px; display: flex; align-items: center;
            flex-shrink: 0;
        }

        @keyframes slideDown { from { opacity:0; transform:translateY(-12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes barPulse  { 0%,100% { transform:scale(1); } 50% { transform:scale(1.02); } }
    </style>
</head>
<body>
@if(!$noMeja)
{{-- Layar scan QR --}}
<div style="min-height:100vh; background:#FAF7F2; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:32px; text-align:center;">
    <div class="pop-in" style="width:88px; height:88px; background:#FFFFFF; border-radius:22px; display:flex; align-items:center; justify-content:center; margin-bottom:24px; border:1px solid #E5E7EB;">
        <span class="msym" style="font-size:40px; color:#FF7A30;">qr_code_2</span>
    </div>
    <p class="font-display fade-in-up" style="font-size:22px; color:#2E2E2E; margin:0 0 10px; animation-delay:0.1s;">Scan QR Code dulu</p>
    <p class="fade-in-up" style="font-size:14px; color:#6B7280; line-height:1.7; max-width:240px; animation-delay:0.2s;">Scan QR code yang ada di mejamu untuk mulai memesan</p>
</div>
@else
<div class="app-shell">

    {{-- Header --}}
    <header class="topbar-sticky">
        <h1 class="topbar-brand">Sate <em>Taichan</em></h1>
        <span class="topbar-meja">Meja {{ $noMeja }}</span>
    </header>

    <div id="order-stack" class="order-stack"></div>

    {{-- Banner Carousel --}}
    <section class="banner-section">
        <div class="banner-track" id="banner-track">
            <div class="banner-slide" onclick="openPoinModal()">
                <div class="banner-content">
                    <span class="banner-tag primary"><span class="msym" style="font-size:13px;vertical-align:middle;">card_giftcard</span> Program Reward</span>
                    <p class="banner-title">Belanja, kumpul poin,<br>dapat diskon!</p>
                    <p class="banner-desc">Daftar & kumpulkan poin dari setiap pesananmu.</p>
                </div>
            </div>
            <div class="banner-slide" onclick="openPoinModal()">
                <div class="banner-content">
                    <span class="banner-tag secondary"><span class="msym" style="font-size:13px;vertical-align:middle;">star</span> Cara Dapet Poin</span>
                    <p class="banner-title">Rp 15.000 = 1 poin,<br>Rp 35.000 = 2 poin!</p>
                    <p class="banner-desc">Makin banyak belanja, makin banyak poin.</p>
                </div>
            </div>
            <div class="banner-slide" onclick="openPoinModal()">
                <div class="banner-content">
                    <span class="banner-tag primary"><span class="msym" style="font-size:13px;vertical-align:middle;">savings</span> Redeem Poin</span>
                    <p class="banner-title">10 poin = diskon<br>Rp 15.000!</p>
                    <p class="banner-desc">Tukar poin saat checkout. Hemat tanpa syarat ribet.</p>
                </div>
            </div>
        </div>
        <div class="banner-dots" id="banner-dots">
            <div class="b-dot active" onclick="bannerGoTo(0)"></div>
            <div class="b-dot" onclick="bannerGoTo(1)"></div>
            <div class="b-dot" onclick="bannerGoTo(2)"></div>
        </div>
    </section>

    {{-- Filter Kategori --}}
    <div class="filter-row hide-scrollbar">
        <button onclick="filterKategori('semua')" id="filter-semua" class="filter-btn active">Semua</button>
        @foreach($kategori as $kat)
        <button onclick="filterKategori('{{ Str::slug($kat) }}')" id="filter-{{ Str::slug($kat) }}" class="filter-btn">{{ $kat }}</button>
        @endforeach
    </div>

    {{-- Product Grid --}}
    <section style="padding:18px 0 24px;">
        <p class="section-label" style="padding:0 14px;">Menu Pilihan</p>
        <div id="product-list" class="product-grid">
            @forelse($products as $i => $product)
            <div class="product-card fade-in-up" id="card-{{ $product->id }}" data-kategori="{{ Str::slug($product->kategori) }}" style="animation-delay:{{ $i * 0.05 }}s;">
                <div class="product-img-wrap" onclick="openProductDetail({{ $product->id }})">
                    @if($product->gambar)
                        <div class="shimmer-img" style="position:absolute; inset:0;"></div>
                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" onload="this.classList.add('img-loaded'); this.previousElementSibling.style.display='none';">
                    @else
                        <div class="shimmer-img" style="width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                            <span class="msym" style="font-size:36px; color:#D1D5DB;">restaurant</span>
                        </div>
                    @endif
                    <span class="product-badge">{{ $product->kategori }}</span>
                </div>
                <div class="product-body">
                    <div>
                        <p class="product-name">{{ $product->nama_produk }}</p>
                        <p class="product-sub">{{ $product->deskripsi ? Str::limit($product->deskripsi, 22) : 'Menu favorit' }}</p>
                    </div>
                    <div class="product-foot">
                        <p class="product-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                        <div class="stepper" id="stepper-{{ $product->id }}">
                            <button onclick="changeQty({{ $product->id }}, -1)" class="step-btn" id="minus-{{ $product->id }}" style="display:none;">
                                <span class="msym" style="font-size:16px;">remove</span>
                            </button>
                            <span id="qty-{{ $product->id }}" class="qty-num" style="display:none;">0</span>
                            <button onclick="changeQty({{ $product->id }}, 1)" class="step-btn add" id="plus-{{ $product->id }}">
                                <span class="msym" style="font-size:16px;">add</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1; text-align:center; padding:56px 0;"><p style="font-size:14px; color:#9CA3AF;">Menu belum tersedia.</p></div>
            @endforelse
        </div>
    </section>

</div>

{{-- Floating Cart Bar --}}
<div id="floating-bar" style="display:none;" class="floating-bar">
    <div class="floating-bar-inner">
        <div class="floating-bar-info">
            <p id="float-items" style="font-size:11px; opacity:0.85;"></p>
            <p id="float-total" style="font-size:16px; font-weight:700;"></p>
        </div>
        <button onclick="toggleCart()" class="floating-bar-btn">
            Lihat Keranjang <span class="msym" style="font-size:16px;">arrow_forward</span>
        </button>
    </div>
</div>

{{-- Bottom Navigation --}}
<nav class="bottom-nav">
    <div class="bottom-nav-inner">
        <button class="nav-btn active" onclick="closeAllDrawers()">
            <span class="msym fill" style="font-size:22px;">restaurant_menu</span>
            <span>Menu</span>
        </button>
        <button class="nav-btn" onclick="toggleHistory()">
            <span class="msym" style="font-size:22px;">receipt_long</span>
            <span>Riwayat</span>
        </button>
        <button class="nav-btn" onclick="openPoinModal()">
            <span class="msym" style="font-size:22px;">stars</span>
            <span>Poin</span>
        </button>
        <button class="nav-btn" onclick="toggleAccount()">
            <span class="msym" style="font-size:22px;">person</span>
            <span>Akun</span>
            <span id="cart-nav-badge" class="nav-badge" style="display:none;">0</span>
        </button>
    </div>
</nav>

{{-- Cart Drawer --}}
<div id="cart-drawer" style="display:none; position:fixed; inset:0; z-index:40;">
    <div class="drawer-bg" onclick="toggleCart()"></div>
    <div class="drawer-box">
        <div class="drawer-handle"><div></div></div>
        <div class="drawer-pad">
            <div class="drawer-title-row">
                <p class="font-display drawer-title">Keranjang</p>
                <button onclick="toggleCart()" class="drawer-close">×</button>
            </div>
            <div id="cart-items" style="margin-bottom:16px;"></div>

            <div class="cart-total-box">
                <span style="font-size:13px; font-weight:600; color:#6B7280;">Total Pembayaran</span>
                <span id="cart-total" style="font-size:16px; font-weight:700; color:#FF7A30;">Rp 0</span>
            </div>

            {{-- Checkout form --}}
            <div id="checkout-form" style="display:none;">

                @if(session('customer_id'))
                <div id="poin-section" style="background:rgba(255,122,48,0.06); border:1px solid rgba(255,122,48,0.18); border-radius:12px; padding:12px 14px; margin-bottom:14px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                        <div>
                            <p style="font-size:11px; color:#6B7280; margin:0 0 1px;">Poin kamu: <span style="color:#E8631C; font-weight:600;" id="poin-label">{{ session('customer_poin', 0) }} poin</span></p>
                            @if(session('customer_poin', 0) >= 10)
                            <p style="font-size:11px; color:#16A34A; margin:0;">Bisa hemat hingga Rp {{ number_format(floor(session('customer_poin', 0) / 10) * 15000, 0, ',', '.') }}</p>
                            @else
                            <p style="font-size:11px; color:#9CA3AF; margin:0;">Butuh {{ 10 - session('customer_poin', 0) }} poin lagi</p>
                            @endif
                        </div>
                        @if(session('customer_poin', 0) >= 10)
                        <button id="btn-redeem" onclick="toggleRedeem()" class="filter-btn" style="background:rgba(255,122,48,0.12); color:#E8631C; border:1px solid rgba(255,122,48,0.3); padding:7px 14px;">
                            Pakai Poin
                        </button>
                        @endif
                    </div>
                    <div id="redeem-panel" style="display:none;">
                        <p style="font-size:11px; color:#6B7280; margin:0 0 8px;">Pilih jumlah poin:</p>
                        <div style="display:flex; gap:8px; flex-wrap:wrap;" id="redeem-options"></div>
                        <p id="redeem-info" style="font-size:11px; color:#16A34A; margin:8px 0 0;"></p>
                    </div>
                </div>
                <input type="hidden" id="redeem_poin" value="0">
                @endif

                <div style="margin-bottom:14px;">
                    <label style="display:block; font-size:10px; font-weight:600; color:#6B7280; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.1em;">Nama Pemesan</label>
                    <input type="text" id="nama_pemesan" class="input-field-full" value="{{ session('customer_nama', '') }}" placeholder="Nama kamu">
                </div>
                <button id="btn-submit-order" onclick="submitOrder()" class="btn-pill-primary">
                    <span id="btn-submit-text">Kirim Pesanan</span>
                    <svg id="btn-submit-spinner" style="display:none; animation:spin 0.6s linear infinite;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                </button>
            </div>
            <button id="btn-checkout" onclick="showCheckoutForm()" class="btn-pill-primary">Lanjut ke Checkout</button>
        </div>
    </div>
</div>

{{-- Product Detail Modal --}}
<div id="product-detail-modal" style="display:none; position:fixed; inset:0; z-index:45;">
    <div onclick="closeProductDetail()" style="position:absolute; inset:0; background:rgba(46,46,46,0.4); backdrop-filter:blur(8px);"></div>
    <div style="position:absolute; bottom:0; left:0; right:0; max-width:480px; margin:0 auto; background:#FAF7F2; border-radius:24px 24px 0 0; border:1px solid #E5E7EB; border-bottom:none; max-height:90vh; overflow-y:auto; animation:slideUp 0.35s cubic-bezier(0.32,0.72,0,1) both;">
        <div class="drawer-handle"><div></div></div>
        <div id="detail-img-wrap" style="width:100%; aspect-ratio:4/3; overflow:hidden; position:relative;">
            <img id="detail-img" src="" alt="" style="width:100%; height:100%; object-fit:cover; display:block;">
            <div id="detail-no-img" style="display:none; width:100%; height:100%; background:#FFFFFF; align-items:center; justify-content:center;">
                <span class="msym" style="font-size:48px; color:#D1D5DB;">restaurant</span>
            </div>
            <button onclick="closeProductDetail()" style="position:absolute; top:12px; right:12px; background:rgba(255,255,255,0.85); border:none; width:32px; height:32px; border-radius:50%; font-size:18px; color:#2E2E2E; cursor:pointer; display:flex; align-items:center; justify-content:center; backdrop-filter:blur(4px);">×</button>
            <span id="detail-kategori" class="product-badge" style="left:12px; top:12px;"></span>
        </div>
        <div style="padding:18px 20px 32px;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:10px;">
                <p id="detail-nama" class="font-display" style="font-size:20px; font-weight:700; color:#2E2E2E; margin:0; line-height:1.2; flex:1; padding-right:12px;"></p>
                <p id="detail-harga" style="font-size:18px; font-weight:700; color:#FF7A30; margin:0; white-space:nowrap;"></p>
            </div>
            <div style="display:flex; align-items:center; gap:6px; margin-bottom:14px;">
                <div id="detail-stok-dot" style="width:7px; height:7px; border-radius:50%; background:#22C55E; flex-shrink:0;"></div>
                <p id="detail-stok" style="font-size:12px; color:#6B7280; margin:0;"></p>
            </div>
            <div style="background:#FFFFFF; border-radius:12px; padding:14px; margin-bottom:20px; border:1px solid #E5E7EB;">
                <p id="detail-deskripsi" style="font-size:13px; color:#6B7280; margin:0; line-height:1.7;"></p>
            </div>
            <div style="display:flex; align-items:center; gap:12px;">
                <div style="display:flex; align-items:center; gap:10px; background:#FFFFFF; border-radius:50px; padding:6px 14px; border:1px solid #E5E7EB;">
                    <button onclick="detailChangeQty(-1)" class="step-btn"><span class="msym" style="font-size:16px;">remove</span></button>
                    <span id="detail-qty" style="font-size:15px; font-weight:700; color:#2E2E2E; min-width:20px; text-align:center;">1</span>
                    <button onclick="detailChangeQty(1)" class="step-btn add"><span class="msym" style="font-size:16px;">add</span></button>
                </div>
                <button onclick="addToCartFromDetail()" class="add-btn-full" style="flex:1; padding:13px 20px; font-size:14px;">
                    <span class="msym" style="font-size:18px;">shopping_cart</span> Tambah ke Keranjang
                </button>
            </div>
        </div>
    </div>
</div>

{{-- History Drawer --}}
<div id="history-drawer" style="display:none; position:fixed; inset:0; z-index:40;">
    <div class="drawer-bg" onclick="toggleHistory()"></div>
    <div class="drawer-box">
        <div class="drawer-handle"><div></div></div>
        <div class="drawer-pad">
            <div class="drawer-title-row">
                <p class="font-display drawer-title">Riwayat Pesanan</p>
                <button onclick="toggleHistory()" class="drawer-close">×</button>
            </div>
            <div id="history-list"></div>
        </div>
    </div>
</div>

{{-- Poin Info Modal --}}
<div id="poin-modal" style="display:none; position:fixed; inset:0; z-index:45;">
    <div onclick="closePoinModal()" class="drawer-bg"></div>
    <div class="drawer-box">
        <div class="drawer-handle"><div></div></div>
        <div class="drawer-pad">
            <div class="drawer-title-row">
                <div>
                    <p class="font-display drawer-title" style="margin-bottom:2px;">Program Poin Reward</p>
                    <p style="font-size:12px; color:#9CA3AF; margin:0;">Kumpulkan poin, hemat lebih banyak</p>
                </div>
                <button onclick="closePoinModal()" class="drawer-close">×</button>
            </div>
            <div style="background:#FFFFFF; border:1px solid rgba(255,122,48,0.25); border-radius:14px; padding:14px 16px; margin-bottom:20px; display:flex; align-items:center; gap:14px;">
                <div style="width:44px; height:44px; background:rgba(255,122,48,0.1); border-radius:12px; border:1px solid rgba(255,122,48,0.25); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <span class="msym" style="font-size:24px; color:#FF7A30;">stars</span>
                </div>
                <div>
                    <p style="font-size:11px; color:#9CA3AF; margin:0 0 3px; text-transform:uppercase; letter-spacing:0.08em;">Poin kamu saat ini</p>
                    @if(session('customer_id'))
                    <p style="font-size:24px; font-weight:700; color:#E8631C; margin:0; line-height:1.1;">{{ session('customer_poin', 0) }} <span style="font-size:13px; font-weight:400; color:#9CA3AF;">poin</span></p>
                    @else
                    <p style="font-size:14px; color:#6B7280; margin:0;">Login untuk lihat poin kamu</p>
                    @endif
                </div>
            </div>
            <p class="section-label">Cara kerja</p>
            <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:20px;">
                <div style="display:flex; align-items:flex-start; gap:12px;"><div class="poin-step-num">1</div><div><p style="font-size:13px; font-weight:600; color:#2E2E2E; margin:0 0 2px;">Daftar atau login</p><p style="font-size:12px; color:#6B7280; margin:0; line-height:1.6;">Pakai nama & nomor HP. Gratis, tanpa ribet.</p></div></div>
                <div style="display:flex; align-items:flex-start; gap:12px;"><div class="poin-step-num">2</div><div><p style="font-size:13px; font-weight:600; color:#2E2E2E; margin:0 0 2px;">Kumpulkan poin tiap order</p><p style="font-size:12px; color:#6B7280; margin:0; line-height:1.6;">Rp 15.000 = 1 poin • Rp 35.000 = 2 poin • Rp 55.000 = 3 poin</p></div></div>
                <div style="display:flex; align-items:flex-start; gap:12px;"><div class="poin-step-num">3</div><div><p style="font-size:13px; font-weight:600; color:#2E2E2E; margin:0 0 2px;">Tukar jadi diskon</p><p style="font-size:12px; color:#6B7280; margin:0; line-height:1.6;">10 poin = diskon Rp 15.000 • 20 poin = Rp 30.000 • dst</p></div></div>
            </div>
            <button onclick="closePoinModal()" class="btn-pill-outline">Tutup</button>
        </div>
    </div>
</div>

{{-- Account Drawer --}}
<div id="account-drawer" style="display:none; position:fixed; inset:0; z-index:40;">
    <div class="drawer-bg" onclick="toggleAccount()"></div>
    <div class="drawer-box">
        <div class="drawer-handle"><div></div></div>
        <div class="drawer-pad">
            <div class="drawer-title-row">
                <p class="font-display drawer-title">Akun Saya</p>
                <button onclick="toggleAccount()" class="drawer-close">×</button>
            </div>

            @if(session('customer_id'))
                <div style="background:#FFFFFF; border-radius:14px; padding:16px; margin-bottom:16px; border:1px solid #E5E7EB; display:flex; align-items:center; gap:14px;">
                    <div style="width:44px; height:44px; border-radius:50%; background:rgba(255,122,48,0.12); border:1px solid rgba(255,122,48,0.3); display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:700; color:#E8631C; flex-shrink:0;">{{ strtoupper(substr(session('customer_nama', 'G'), 0, 1)) }}</div>
                    <div>
                        <p style="font-size:15px; font-weight:600; color:#2E2E2E; margin:0 0 2px;">{{ session('customer_nama') }}</p>
                        <p style="font-size:11px; color:#9CA3AF; margin:0;">Member Taichan</p>
                    </div>
                </div>

                <div style="background:rgba(255,122,48,0.06); border:1px solid rgba(255,122,48,0.2); border-radius:14px; padding:16px; margin-bottom:20px;">
                    <p class="section-label" style="margin-bottom:8px;">Poin Reward</p>
                    <div style="display:flex; align-items:baseline; gap:8px; margin-bottom:8px;">
                        <p id="profile-poin-display" style="font-size:32px; font-weight:700; color:#E8631C; margin:0; line-height:1;">{{ session('customer_poin', 0) }}</p>
                        <p style="font-size:13px; color:#6B7280; margin:0;">poin</p>
                    </div>
                    @php $poin = session('customer_poin', 0); @endphp
                    <p style="font-size:12px; color:#6B7280; margin:0 0 10px;">
                        @if($poin >= 10) Bisa redeem {{ floor($poin / 10) }}x diskon Rp 15.000!
                        @else Butuh {{ 10 - ($poin % 10) }} poin lagi untuk dapat diskon
                        @endif
                    </p>
                    <div style="background:#E5E7EB; border-radius:4px; height:6px; overflow:hidden;">
                        <div id="profile-poin-bar" style="background:#FF7A30; height:100%; border-radius:4px; width:{{ min(($poin % 10) * 10, 100) }}%; transition:width 0.5s ease;"></div>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-top:5px;">
                        <p id="profile-poin-fraction" style="font-size:10px; color:#9CA3AF; margin:0;">{{ $poin % 10 }}/10 menuju poin berikutnya</p>
                        <p style="font-size:10px; color:#9CA3AF; margin:0;">+Rp 15.000 diskon</p>
                    </div>
                </div>

                <div style="background:#FFFFFF; border-radius:12px; padding:14px 16px; margin-bottom:20px; border:1px solid #E5E7EB;">
                    <p class="section-label" style="margin-bottom:10px;">Cara dapat poin</p>
                    <div style="display:flex; flex-direction:column; gap:8px;">
                        <div style="display:flex; justify-content:space-between; font-size:12px;"><span style="color:#6B7280;">Belanja Rp 15.000</span><span style="color:#E8631C; font-weight:600;">+1 poin</span></div>
                        <div style="display:flex; justify-content:space-between; font-size:12px;"><span style="color:#6B7280;">Belanja Rp 35.000</span><span style="color:#E8631C; font-weight:600;">+2 poin</span></div>
                        <div style="display:flex; justify-content:space-between; font-size:12px;"><span style="color:#6B7280;">Belanja Rp 55.000</span><span style="color:#E8631C; font-weight:600;">+3 poin</span></div>
                        <div style="display:flex; justify-content:space-between; font-size:12px; padding-top:8px; border-top:1px solid #E5E7EB;"><span style="color:#6B7280;">10 poin =</span><span style="color:#16A34A; font-weight:600;">Diskon Rp 15.000</span></div>
                    </div>
                </div>

                <form method="POST" action="/menu/auth/logout">
                    @csrf
                    <button type="submit" style="width:100%; background:rgba(239,68,68,0.08); color:#DC2626; border:1px solid rgba(239,68,68,0.25); border-radius:50px; padding:13px; font-size:14px; font-weight:600; font-family:inherit; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px;">
                        <span class="msym" style="font-size:18px;">logout</span> Keluar dari Akun
                    </button>
                </form>
            @else
                <div style="text-align:center; padding:24px 0 8px;">
                    <div style="width:64px; height:64px; background:#FFFFFF; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; border:1px solid #E5E7EB;">
                        <span class="msym" style="font-size:30px; color:#FF7A30;">person</span>
                    </div>
                    <p class="font-display" style="font-size:18px; color:#2E2E2E; margin:0 0 6px;">Belum Login</p>
                    <p style="font-size:12.5px; color:#6B7280; margin:0 0 24px; line-height:1.6;">Login atau daftar untuk kumpulkan poin dan dapat diskon spesial.</p>
                    <a href="/menu/auth?meja={{ $noMeja }}" class="btn-pill-primary" style="text-decoration:none;">
                        <span class="msym" style="font-size:18px;">login</span> Login / Daftar
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Order Status Modal --}}
<div id="success-modal" style="display:none; position:fixed; inset:0; z-index:50; align-items:center; justify-content:center; padding:24px;">
    <div class="drawer-bg"></div>
    <div class="pop-in" style="position:relative; background:#FAF7F2; border:1px solid #E5E7EB; border-radius:24px; padding:28px 24px; text-align:center; max-width:320px; width:100%;">
        <button onclick="closeStatusModal()" style="position:absolute; top:14px; right:14px; background:none; border:none; cursor:pointer; color:#9CA3AF; display:flex; align-items:center; justify-content:center; padding:4px;">
            <span class="msym" style="font-size:20px;">close</span>
        </button>

        {{-- Icon status (berubah sesuai status) --}}
        <div id="status-icon-wrap" style="width:68px; height:68px; background:rgba(255,122,48,0.1); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; border:1px solid rgba(255,122,48,0.25); transition:all 0.4s ease;">
            <span id="status-icon" class="msym" style="font-size:32px; color:#FF7A30;">receipt_long</span>
        </div>

        {{-- Label & deskripsi status --}}
        <p id="status-label" class="font-display" style="font-size:20px; color:#2E2E2E; margin:0 0 6px; transition:all 0.3s;">Pesanan Terkirim!</p>
        <p id="status-desc" style="font-size:13px; color:#6B7280; margin:0 0 16px; line-height:1.7;">Pesanan kamu sedang menunggu dikonfirmasi kasir.</p>

        {{-- Step progress bar --}}
        <div style="display:flex; align-items:center; justify-content:center; gap:0; margin-bottom:20px;">
            <div id="step-pending" style="display:flex; flex-direction:column; align-items:center; gap:4px;">
                <div style="width:28px; height:28px; border-radius:50%; background:#FF7A30; color:#fff; font-size:11px; font-weight:700; display:flex; align-items:center; justify-content:center;">1</div>
                <span style="font-size:9px; color:#FF7A30; font-weight:600;">Menunggu</span>
            </div>
            <div id="line-1" style="height:2px; width:40px; background:#E5E7EB; transition:background 0.4s;"></div>
            <div id="step-proses" style="display:flex; flex-direction:column; align-items:center; gap:4px;">
                <div id="step-proses-circle" style="width:28px; height:28px; border-radius:50%; background:#E5E7EB; color:#9CA3AF; font-size:11px; font-weight:700; display:flex; align-items:center; justify-content:center; transition:all 0.4s;">2</div>
                <span id="step-proses-label" style="font-size:9px; color:#9CA3AF; font-weight:600; transition:color 0.4s;">Diproses</span>
            </div>
            <div id="line-2" style="height:2px; width:40px; background:#E5E7EB; transition:background 0.4s;"></div>
            <div id="step-selesai" style="display:flex; flex-direction:column; align-items:center; gap:4px;">
                <div id="step-selesai-circle" style="width:28px; height:28px; border-radius:50%; background:#E5E7EB; color:#9CA3AF; font-size:11px; font-weight:700; display:flex; align-items:center; justify-content:center; transition:all 0.4s;">3</div>
                <span id="step-selesai-label" style="font-size:9px; color:#9CA3AF; font-weight:600; transition:color 0.4s;">Siap!</span>
            </div>
        </div>

        {{-- Info poin (muncul kalau status selesai) --}}
        <div id="success-poin-info" style="display:none; background:rgba(255,122,48,0.06); border:1px solid rgba(255,122,48,0.2); border-radius:10px; padding:10px 14px; margin-bottom:10px;">
            <p id="success-poin-dapat" style="font-size:13px; font-weight:600; color:#E8631C; margin:0 0 2px;"></p>
            <p id="success-poin-total" style="font-size:11px; color:#6B7280; margin:0;"></p>
        </div>

        {{-- Info diskon --}}
        <div id="success-diskon-info" style="display:none; background:rgba(34,197,94,0.08); border:1px solid rgba(34,197,94,0.2); border-radius:10px; padding:10px 14px; margin-bottom:16px;">
            <p id="success-diskon-val" style="font-size:12px; color:#16A34A; margin:0;"></p>
        </div>

        {{-- Tombol: hanya muncul kalau selesai atau batal --}}
        <button id="btn-pesan-lagi" onclick="resetOrder()" style="display:none;" class="btn-pill-primary" style="padding:12px 32px;">
            <span class="msym" style="font-size:16px;">refresh</span> Pesan Lagi
        </button>

        {{-- Polling indicator --}}
        <p id="polling-hint" style="font-size:11px; color:#9CA3AF; margin:8px 0 0;">
            <span class="msym" style="font-size:12px; vertical-align:middle; animation:spin 1.5s linear infinite; display:inline-block;">sync</span>
            Memperbarui status otomatis...
        </p>
    </div>
</div>

@endif

<script>
    const noMeja = "{{ $noMeja }}";
    const prices = {@foreach($products as $product)
        {{ $product->id }}: {
            name: "{{ $product->nama_produk }}",
            price: {{ $product->harga }},
            kategori: "{{ Str::slug($product->kategori) }}",
            deskripsi: "{{ addslashes($product->deskripsi ?? '') }}",
            gambar: "{{ $product->gambar ? asset('storage/' . $product->gambar) : '' }}",
            stok: {{ $product->stok }},
        },
        @endforeach
    };

    let cart = {};
    let orderHistory = JSON.parse(localStorage.getItem('orderHistory_meja_' + noMeja) || '[]');
    let selectedRedeem = 0;
    let redeemActive = false;
    const customerPoin = {{ session('customer_poin', 0) }};

    // ===== BANNER =====
    let bannerCur = 0;
    const bannerTotal = 3;
    function bannerGoTo(n) {
        bannerCur = n;
        const track = document.getElementById('banner-track');
        const slideWidth = track.children[0].offsetWidth + 10;
        track.scrollTo({ left: n * slideWidth, behavior: 'smooth' });
        document.querySelectorAll('.b-dot').forEach((d, i) => d.classList.toggle('active', i === n));
    }
    setInterval(() => bannerGoTo((bannerCur + 1) % bannerTotal), 4000);

    // ===== POIN MODAL =====
    function openPoinModal() { closeAllDrawers(); document.getElementById('poin-modal').style.display = 'block'; }
    function closePoinModal() { document.getElementById('poin-modal').style.display = 'none'; }

    // ===== ACCOUNT DRAWER =====
    function toggleAccount() {
        closeAllDrawers('account-drawer');
        const d = document.getElementById('account-drawer');
        d.style.display = d.style.display === 'none' ? 'block' : 'none';
        updateBottomNav('account-drawer');
    }

    // ===== CLOSE HELPERS =====
    function closeAllDrawers(except = null) {
        ['cart-drawer', 'history-drawer', 'account-drawer', 'poin-modal'].forEach(id => {
            if (id !== except) {
                const el = document.getElementById(id);
                if (el) el.style.display = 'none';
            }
        });
        updateBottomNav(except);
    }

    function updateBottomNav(activeId) {
        document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
        const map = { 'history-drawer': 1, 'account-drawer': 3 };
        const btns = document.querySelectorAll('.nav-btn');
        if (activeId && map[activeId] !== undefined) {
            btns[map[activeId]].classList.add('active');
        } else {
            btns[0].classList.add('active');
        }
    }

    // ===== REDEEM =====
    function toggleRedeem() {
        const panel = document.getElementById('redeem-panel');
        const btn   = document.getElementById('btn-redeem');
        if (!panel) return;
        redeemActive = !redeemActive;
        if (redeemActive) {
            panel.style.display = 'block';
            btn.textContent = 'Batal';
            renderRedeemOptions();
        } else {
            panel.style.display = 'none';
            btn.textContent = 'Pakai Poin';
            setRedeem(0);
        }
    }

    function renderRedeemOptions() {
        const container = document.getElementById('redeem-options');
        if (!container) return;
        container.innerHTML = '';
        const maxSet = Math.floor(customerPoin / 10);
        for (let i = 1; i <= maxSet; i++) {
            const poin = i * 10;
            const diskon = i * 15000;
            const btn = document.createElement('button');
            btn.className = 'redeem-opt';
            btn.textContent = `${poin} poin (-Rp ${diskon.toLocaleString('id-ID')})`;
            btn.onclick = () => selectRedeem(poin, diskon, btn);
            container.appendChild(btn);
        }
    }

    function selectRedeem(poin, diskon, btnEl) {
        document.querySelectorAll('.redeem-opt').forEach(b => b.classList.remove('selected'));
        if (selectedRedeem === poin) {
            selectedRedeem = 0;
            setRedeem(0);
            document.getElementById('redeem-info').textContent = '';
        } else {
            selectedRedeem = poin;
            btnEl.classList.add('selected');
            setRedeem(poin);
            document.getElementById('redeem-info').textContent = `✓ Hemat Rp ${diskon.toLocaleString('id-ID')} dari ${poin} poin`;
        }
    }

    function setRedeem(poin) {
        const el = document.getElementById('redeem_poin');
        if (el) el.value = poin;
        selectedRedeem = poin;
        updateCartTotal();
    }

    function updateCartTotal() {
        const totalHarga = Object.keys(cart).reduce((a, id) => a + prices[id].price * cart[id], 0);
        const diskon = selectedRedeem ? Math.floor(selectedRedeem / 10) * 15000 : 0;
        const totalAkhir = Math.max(0, totalHarga - diskon);
        const el = document.getElementById('cart-total');
        if (!el) return;
        if (diskon > 0) {
            el.innerHTML = `<span style="text-decoration:line-through;color:#9CA3AF;font-size:12px;margin-right:6px;">Rp ${totalHarga.toLocaleString('id-ID')}</span><span style="color:#16A34A;">Rp ${totalAkhir.toLocaleString('id-ID')}</span>`;
        } else {
            el.textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');
        }
    }

    // ===== FILTER =====
    function filterKategori(kat) {
        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        const active = document.getElementById('filter-' + kat);
        if (active) active.classList.add('active');
        let delay = 0;
        document.querySelectorAll('.product-card').forEach(card => {
            const show = kat === 'semua' || card.dataset.kategori === kat;
            if (show) {
                card.style.display = 'flex';
                card.style.animation = 'none';
                setTimeout(() => { card.style.animation = `fadeInUp 0.35s ease ${delay}s both`; delay += 0.05; }, 10);
            } else { card.style.display = 'none'; }
        });
    }

    // ===== CART =====
    function changeQty(id, delta) {
        const prev  = cart[id] || 0;
        const stok  = prices[id].stok;          // ← ambil stok dari data produk
        let next    = prev + delta;

        if (next > stok) {
            next = stok;
            // Kasih feedback visual kalau udah mentok
            const qEl = document.getElementById('qty-' + id);
            if (qEl) {
                qEl.style.color = '#EF4444';
                setTimeout(() => qEl.style.color = '#2E2E2E', 600);
            }
        }
        if (next <= 0) { delete cart[id]; next = 0; }
        else cart[id] = next;

        const qtyEl   = document.getElementById('qty-' + id);
        const minusEl = document.getElementById('minus-' + id);
        if (qtyEl) {
            qtyEl.textContent = next;
            qtyEl.classList.remove('bump');
            void qtyEl.offsetWidth;
            qtyEl.classList.add('bump');
            qtyEl.style.display   = next > 0 ? 'inline-block' : 'none';
            minusEl.style.display = next > 0 ? 'flex' : 'none';
        }

        const card = document.getElementById('card-' + id);
        if (card) card.classList.toggle('in-cart', next > 0);
        updateUI();
    }

    function updateUI() {
        const totalItems = Object.values(cart).reduce((a, b) => a + b, 0);
        const totalHarga = Object.keys(cart).reduce((a, id) => a + prices[id].price * cart[id], 0);
        const floatBar = document.getElementById('floating-bar');
        const navBadge = document.getElementById('cart-nav-badge');
        if (totalItems > 0) {
            floatBar.style.display = 'block';
            document.getElementById('float-items').textContent = totalItems + ' item dipilih';
            document.getElementById('float-total').textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');
            navBadge.style.display = 'flex'; navBadge.textContent = totalItems;
        } else {
            floatBar.style.display = 'none';
            navBadge.style.display = 'none';
        }
    }

    function toggleCart() {
        closeAllDrawers('cart-drawer');
        const d = document.getElementById('cart-drawer');
        const isHidden = d.style.display === 'none';
        d.style.display = isHidden ? 'block' : 'none';
        if (isHidden) renderCart();
    }

    function renderCart() {
        const container = document.getElementById('cart-items');
        const keys = Object.keys(cart);
        if (keys.length === 0) {
            container.innerHTML = '<div style="text-align:center;padding:32px 0;"><p style="font-size:14px;color:#9CA3AF;">Keranjang masih kosong.</p></div>';
            document.getElementById('cart-total').textContent = 'Rp 0';
            return;
        }
        let html = '';
        keys.forEach(id => {
            const item = prices[id];
            const subtotal = item.price * cart[id];
            html += `<div class="cart-item">
                <div><p style="font-size:13px;font-weight:600;color:#2E2E2E;margin:0 0 3px;">${item.name}</p><p style="font-size:11px;color:#9CA3AF;margin:0;">x${cart[id]} × Rp ${item.price.toLocaleString('id-ID')}</p></div>
                <p style="font-size:13px;font-weight:700;color:#FF7A30;margin:0;">Rp ${subtotal.toLocaleString('id-ID')}</p>
            </div>`;
        });
        container.innerHTML = html;
        updateCartTotal();
    }

    function showCheckoutForm() {
        if (Object.keys(cart).length === 0) { alert('Keranjang masih kosong!'); return; }
        document.getElementById('checkout-form').style.display = 'block';
        document.getElementById('btn-checkout').style.display = 'none';
        updateCartTotal();
    }

    let isSubmitting = false;

    function submitOrder() {
        if (isSubmitting) return;

        const nama = document.getElementById('nama_pemesan').value.trim();
        if (!nama) { alert('Nama pemesan wajib diisi!'); return; }
        const items = Object.keys(cart).map(id => ({ id: parseInt(id), qty: cart[id] }));

        const redeemInput = document.getElementById('redeem_poin');
        const redeemPoin = redeemInput ? parseInt(redeemInput.value) || 0 : 0;

        isSubmitting = true;
        const btn = document.getElementById('btn-submit-order');
        const btnText = document.getElementById('btn-submit-text');
        const btnSpinner = document.getElementById('btn-submit-spinner');
        btn.disabled = true;
        btn.style.opacity = '0.7';
        btn.style.cursor = 'not-allowed';
        btnText.textContent = 'Mengirim...';
        btnSpinner.style.display = 'inline-block';

        fetch(window.location.origin + "/menu/checkout", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ nama_pemesan: nama, no_meja: noMeja, items, redeem_poin: redeemPoin })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                orderHistory.unshift({
                    id: data.order_id, nama, meja: noMeja,
                    items: Object.keys(cart).map(id => ({ name: prices[id].name, qty: cart[id], subtotal: prices[id].price * cart[id] })),
                    total: Object.keys(cart).reduce((a, id) => a + prices[id].price * cart[id], 0),
                    waktu: new Date().toLocaleString('id-ID')
                });
                localStorage.setItem('orderHistory_meja_' + noMeja, JSON.stringify(orderHistory));
                document.getElementById('cart-drawer').style.display = 'none';

                if (data.poin_didapat > 0) {
                    document.getElementById('success-poin-info').style.display = 'block';
                    document.getElementById('success-poin-dapat').textContent = '+' + data.poin_didapat + ' poin didapat!';
                    document.getElementById('success-poin-total').textContent = 'Total poin kamu: ' + data.poin_total + ' poin';
                    const profilePoin = document.getElementById('profile-poin-display');
                    if (profilePoin) profilePoin.textContent = data.poin_total;
                    const bar = document.getElementById('profile-poin-bar');
                    if (bar) bar.style.width = Math.min((data.poin_total % 10) * 10, 100) + '%';
                    const fraction = document.getElementById('profile-poin-fraction');
                    if (fraction) fraction.textContent = (data.poin_total % 10) + '/10 menuju poin berikutnya';
                }
                if (data.diskon > 0) {
                    document.getElementById('success-diskon-info').style.display = 'block';
                    document.getElementById('success-diskon-val').textContent = 'Hemat Rp ' + data.diskon.toLocaleString('id-ID') + ' dari redeem poin';
                }
                document.getElementById('success-modal').style.display = 'flex';
                startOrderPolling(data.order_id, nama);
                selectedRedeem = 0; redeemActive = false;


            } else {
                alert(data.message || 'Gagal mengirim pesanan.');
            }

            isSubmitting = false;
            btn.disabled = false;
            btn.style.opacity = '1';
            btn.style.cursor = 'pointer';
            btnText.textContent = 'Kirim Pesanan';
            btnSpinner.style.display = 'none';
        })
        .catch(() => {
            isSubmitting = false;
            btn.disabled = false;
            btn.style.opacity = '1';
            btn.style.cursor = 'pointer';
            btnText.textContent = 'Kirim Pesanan';
            btnSpinner.style.display = 'none';
            alert('Gagal mengirim pesanan. Cek koneksi & coba lagi.');
        });
    }

    function toggleHistory() {
        closeAllDrawers('history-drawer');
        const d = document.getElementById('history-drawer');
        const isHidden = d.style.display === 'none';
        d.style.display = isHidden ? 'block' : 'none';
        if (isHidden) renderHistory();
        updateBottomNav('history-drawer');
    }

    function renderHistory() {
        const container = document.getElementById('history-list');
        if (orderHistory.length === 0) {
            container.innerHTML = '<div style="text-align:center;padding:32px 0;"><p style="font-size:14px;color:#9CA3AF;">Belum ada riwayat pesanan.</p></div>';
            return;
        }
        container.innerHTML = orderHistory.map(order => `
            <div class="cart-item" style="flex-direction:column; align-items:stretch; gap:8px;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                    <div><p style="font-size:13px;font-weight:600;color:#2E2E2E;margin:0 0 2px;">${order.nama} — Meja ${order.meja}</p><p style="font-size:11px;color:#9CA3AF;margin:0;">${order.waktu}</p></div>
                    <p style="font-size:13px;font-weight:700;color:#FF7A30;margin:0;">Rp ${order.total.toLocaleString('id-ID')}</p>
                </div>
                ${order.items.map(i => `<p style="font-size:11px;color:#9CA3AF;margin:2px 0;">• ${i.name} x${i.qty}</p>`).join('')}
            </div>
        `).join('');
    }

    function resetOrder() {
        stopAllPolling();
        Object.keys(popupShownFor).forEach(k => delete popupShownFor[k]);
        cart = {}; selectedRedeem = 0; redeemActive = false;
        document.querySelectorAll('[id^="qty-"]').forEach(el => { el.textContent = '0'; el.style.display = 'none'; });
        document.querySelectorAll('[id^="minus-"]').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.product-card').forEach(c => c.classList.remove('in-cart'));
        updateUI();
        document.getElementById('success-modal').style.display = 'none';
        document.getElementById('success-poin-info').style.display = 'none';
        document.getElementById('success-diskon-info').style.display = 'none';
        document.getElementById('checkout-form').style.display = 'none';
        document.getElementById('btn-checkout').style.display = 'block';
        document.getElementById('nama_pemesan').value = '';
        const redeemPanel = document.getElementById('redeem-panel');
        if (redeemPanel) redeemPanel.style.display = 'none';
        const redeemInput = document.getElementById('redeem_poin');
        if (redeemInput) redeemInput.value = 0;
        const submitBtn = document.getElementById('btn-submit-order');
        const submitText = document.getElementById('btn-submit-text');
        const submitSpinner = document.getElementById('btn-submit-spinner');
        if (submitBtn) {
            isSubmitting = false;
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
            submitText.textContent = 'Kirim Pesanan';
            submitSpinner.style.display = 'none';
        }
    }


    // ===== MULTI ORDER POLLING =====
    const activeOrders = {}; // { orderId: { timer, lastStatus, nama } }

    function startOrderPolling(orderId, namaPemesan) {
        if (activeOrders[orderId]) return; // sudah jalan

        // Buat sticky bar
        createOrderBar(orderId, namaPemesan, 'pending');

        activeOrders[orderId] = {
            lastStatus: 'pending',
            nama: namaPemesan,
            timer: setInterval(() => pollOrderStatus(orderId), 4000)
        };
    }

    function stopOrderPolling(orderId) {
        if (activeOrders[orderId]) {
            clearInterval(activeOrders[orderId].timer);
            delete activeOrders[orderId];
        }
    }

    function stopAllPolling() {
        Object.keys(activeOrders).forEach(id => stopOrderPolling(id));
    }

    function pollOrderStatus(orderId) {
        fetch('/menu/order-status?order_id=' + orderId)
            .then(r => r.json())
            .then(data => {
                if (!data.success) return;
                const order = activeOrders[orderId];
                if (!order) return;

                const statusChanged = data.status !== order.lastStatus;

                if (statusChanged) {
                    order.lastStatus = data.status;

                    // Update sticky bar
                    updateOrderBar(orderId, data.status, data.poin_didapat, data.poin_total);

                    // Update popup juga
                    updatePopupStatus(data);

                    // Re-open popup sekali per perubahan status (kecuali pending)
                    if (data.status !== 'pending' && popupShownFor[orderId] !== data.status) {
                        popupShownFor[orderId] = data.status;
                        document.getElementById('success-modal').style.display = 'flex';
                    }

                    // Stop polling kalau final
                    if (data.status === 'selesai' || data.status === 'batal') {
                        setTimeout(() => stopOrderPolling(orderId), 5000);
                    }
                }
            })
            .catch(() => {});
    }

    function updatePopupStatus(data) {
        const iconMap = {
            pending: { icon: 'receipt_long', color: '#FF7A30', bg: 'rgba(255,122,48,0.1)', border: 'rgba(255,122,48,0.25)' },
            proses:  { icon: 'outdoor_grill', color: '#3B82F6', bg: 'rgba(59,130,246,0.1)', border: 'rgba(59,130,246,0.25)' },
            selesai: { icon: 'check_circle',  color: '#16A34A', bg: 'rgba(22,163,74,0.1)',  border: 'rgba(22,163,74,0.25)' },
            batal:   { icon: 'cancel',        color: '#DC2626', bg: 'rgba(220,38,38,0.1)',  border: 'rgba(220,38,38,0.25)' },
        };
        const cfg = iconMap[data.status] || iconMap.pending;

        // Update icon
        const iconWrap = document.getElementById('status-icon-wrap');
        const icon     = document.getElementById('status-icon');
        if (iconWrap) { iconWrap.style.background = cfg.bg; iconWrap.style.borderColor = cfg.border; }
        if (icon)     { icon.textContent = cfg.icon; icon.style.color = cfg.color; }

        // Update label & desc
        const label = document.getElementById('status-label');
        const desc  = document.getElementById('status-desc');
        if (label) label.textContent = data.status_label;
        if (desc)  desc.textContent  = data.status_desc;

        // Update step progress bar
        const proseCircle = document.getElementById('step-proses-circle');
        const proseLabel  = document.getElementById('step-proses-label');
        const selesaiCircle = document.getElementById('step-selesai-circle');
        const selesaiLabel  = document.getElementById('step-selesai-label');
        const line1 = document.getElementById('line-1');
        const line2 = document.getElementById('line-2');

        if (data.status === 'proses' || data.status === 'selesai') {
            if (proseCircle) { proseCircle.style.background = '#3B82F6'; proseCircle.style.color = '#fff'; }
            if (proseLabel)  proseLabel.style.color = '#3B82F6';
            if (line1)       line1.style.background = '#3B82F6';
        }
        if (data.status === 'selesai') {
            if (selesaiCircle) { selesaiCircle.style.background = '#16A34A'; selesaiCircle.style.color = '#fff'; }
            if (selesaiLabel)  selesaiLabel.style.color = '#16A34A';
            if (line2)         line2.style.background = '#16A34A';
        }
        if (data.status === 'batal') {
            if (proseCircle) { proseCircle.style.background = '#DC2626'; proseCircle.style.color = '#fff'; }
            if (proseLabel)  proseLabel.style.color = '#DC2626';
        }

        // Tampilkan poin kalau selesai
        if (data.status === 'selesai' && data.poin_didapat > 0) {
            const poinInfo = document.getElementById('success-poin-info');
            const poinDapat = document.getElementById('success-poin-dapat');
            const poinTotal = document.getElementById('success-poin-total');
            if (poinInfo)  poinInfo.style.display = 'block';
            if (poinDapat) poinDapat.textContent = '+' + data.poin_didapat + ' poin didapat!';
            if (poinTotal) poinTotal.textContent  = 'Total poin kamu: ' + data.poin_total + ' poin';

            const profilePoin = document.getElementById('profile-poin-display');
            if (profilePoin) profilePoin.textContent = data.poin_total;
            const bar = document.getElementById('profile-poin-bar');
            if (bar) bar.style.width = Math.min((data.poin_total % 10) * 10, 100) + '%';
            const fraction = document.getElementById('profile-poin-fraction');
            if (fraction) fraction.textContent = (data.poin_total % 10) + '/10 menuju poin berikutnya';
        }

        // Tampilkan tombol "Pesan Lagi" kalau final
        const btnPesanLagi = document.getElementById('btn-pesan-lagi');
        const pollingHint  = document.getElementById('polling-hint');
        if (data.status === 'selesai' || data.status === 'batal') {
            if (btnPesanLagi) btnPesanLagi.style.display = 'flex';
            if (pollingHint)  pollingHint.style.display  = 'none';
        }
    }

    // ===== STICKY BAR PER ORDER =====
    const statusBarConfig = {
        pending: {
            icon: 'receipt_long', iconColor: '#FF7A30', iconBg: 'rgba(255,122,48,0.1)',
            label: 'Menunggu konfirmasi...'
        },
        proses: {
            icon: 'outdoor_grill', iconColor: '#3B82F6', iconBg: 'rgba(59,130,246,0.1)',
            label: 'Sedang diproses dapur!'
        },
        selesai: {
            icon: 'check_circle', iconColor: '#16A34A', iconBg: 'rgba(22,163,74,0.1)',
            label: 'Pesanan siap disajikan!'
        },
        batal: {
            icon: 'cancel', iconColor: '#DC2626', iconBg: 'rgba(220,38,38,0.1)',
            label: 'Pesanan dibatalkan'
        },
    };

    function createOrderBar(orderId, nama, status) {
        const stack = document.getElementById('order-stack');
        if (!stack || document.getElementById('bar-' + orderId)) return;

        const cfg = statusBarConfig[status] || statusBarConfig.pending;
        const bar = document.createElement('div');
        bar.id = 'bar-' + orderId;
        bar.className = 'order-bar status-' + status;
        bar.innerHTML = `
            <div class="order-bar-icon" id="bar-icon-wrap-${orderId}" style="background:${cfg.iconBg};">
                <span class="msym" id="bar-icon-${orderId}" style="font-size:15px;color:${cfg.iconColor};">${cfg.icon}</span>
            </div>
            <div class="order-bar-text">
                <p style="font-size:11px;font-weight:700;color:#2E2E2E;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    ${nama}
                </p>
                <p id="bar-label-${orderId}" style="font-size:10px;color:#6B7280;margin:0;">${cfg.label}</p>
            </div>
            <button class="order-bar-dismiss" onclick="dismissOrderBar(${orderId})" title="Tutup">
                <span class="msym" style="font-size:16px;">close</span>
            </button>
        `;
        stack.appendChild(bar);
    }

    function updateOrderBar(orderId, status, poinDidapat, poinTotal) {
        const bar = document.getElementById('bar-' + orderId);
        if (!bar) return;

        const cfg = statusBarConfig[status] || statusBarConfig.pending;

        // Update class
        bar.className = 'order-bar status-' + status + ' pulse';
        setTimeout(() => bar.classList.remove('pulse'), 700);

        // Update icon
        const iconWrap = document.getElementById('bar-icon-wrap-' + orderId);
        const icon     = document.getElementById('bar-icon-' + orderId);
        const label    = document.getElementById('bar-label-' + orderId);
        if (iconWrap) iconWrap.style.background = cfg.iconBg;
        if (icon)     { icon.textContent = cfg.icon; icon.style.color = cfg.iconColor; }
        if (label)    label.textContent = cfg.label;

        // Kalau selesai & ada poin → update poin di profil
        if (status === 'selesai' && poinDidapat > 0) {
            const profilePoin = document.getElementById('profile-poin-display');
            if (profilePoin) profilePoin.textContent = poinTotal;
            const bar2 = document.getElementById('profile-poin-bar');
            if (bar2) bar2.style.width = Math.min((poinTotal % 10) * 10, 100) + '%';
            const fraction = document.getElementById('profile-poin-fraction');
            if (fraction) fraction.textContent = (poinTotal % 10) + '/10 menuju poin berikutnya';
            // Tampilkan info poin di label bar
            if (label) label.textContent = '+' + poinDidapat + ' poin didapat!';
        }

        // Auto dismiss bar setelah 10 detik kalau final
        if (status === 'selesai' || status === 'batal') {
            setTimeout(() => dismissOrderBar(orderId), 10000);
        }
    }

    function dismissOrderBar(orderId) {
        const bar = document.getElementById('bar-' + orderId);
        if (bar) {
            bar.style.opacity = '0';
            bar.style.transform = 'translateY(-8px)';
            bar.style.transition = 'all 0.25s ease';
            setTimeout(() => bar.remove(), 250);
        }
        stopOrderPolling(orderId);
    }

    // ===== PRODUCT DETAIL MODAL =====
    let detailProductId = null;
    let detailQty = 1;

    function openProductDetail(id) {
        const p = prices[id];
        if (!p) return;

        detailProductId = id;
        detailQty = cart[id] || 1;

        document.getElementById('detail-nama').textContent = p.name;
        document.getElementById('detail-harga').textContent = 'Rp ' + p.price.toLocaleString('id-ID');
        document.getElementById('detail-kategori').textContent = p.kategori.charAt(0).toUpperCase() + p.kategori.slice(1).replace(/-/g,' ');
        document.getElementById('detail-deskripsi').textContent = p.deskripsi || 'Belum ada deskripsi untuk produk ini.';
        document.getElementById('detail-qty').textContent = detailQty;

        const stokEl = document.getElementById('detail-stok');
        const dotEl  = document.getElementById('detail-stok-dot');
        if (p.stok > 5) {
            stokEl.textContent = 'Stok tersedia (' + p.stok + ')';
            dotEl.style.background = '#22C55E';
        } else if (p.stok > 0) {
            stokEl.textContent = 'Stok terbatas (' + p.stok + ')';
            dotEl.style.background = '#F59E0B';
        } else {
            stokEl.textContent = 'Stok habis';
            dotEl.style.background = '#EF4444';
        }

        const img   = document.getElementById('detail-img');
        const noImg = document.getElementById('detail-no-img');
        if (p.gambar) {
            img.src = p.gambar;
            img.style.display = 'block';
            noImg.style.display = 'none';
        } else {
            img.style.display = 'none';
            noImg.style.display = 'flex';
        }

        document.getElementById('product-detail-modal').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeProductDetail() {
        document.getElementById('product-detail-modal').style.display = 'none';
        document.body.style.overflow = '';
    }

    function detailChangeQty(delta) {
        const p = prices[detailProductId];
        detailQty = Math.max(1, Math.min(detailQty + delta, p.stok));
        document.getElementById('detail-qty').textContent = detailQty;
    }

    function addToCartFromDetail() {
        const p = prices[detailProductId];
        if (!p || p.stok === 0) return;

        const delta = detailQty - (cart[detailProductId] || 0);
        cart[detailProductId] = detailQty;

        const qtyEl   = document.getElementById('qty-' + detailProductId);
        const minusEl = document.getElementById('minus-' + detailProductId);
        if (qtyEl) {
            qtyEl.textContent = detailQty;
            qtyEl.style.display = 'inline-block';
            minusEl.style.display = 'flex';
        }
        const card = document.getElementById('card-' + detailProductId);
        if (card) card.classList.add('in-cart');

        updateUI();
        closeProductDetail();
    }
</script>
</body>
</html>