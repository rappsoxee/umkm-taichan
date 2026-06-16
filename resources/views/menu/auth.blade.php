<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taichan — Meja {{ $noMeja }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; overflow: hidden; }
        body { font-family: 'Inter', sans-serif; background: #FAF7F2; color: #2E2E2E; letter-spacing: -0.01em; }
        .font-display { font-family: 'Playfair Display', serif; }

        /* ===================== SPLASH ===================== */
        #splash {
            position: fixed; inset: 0; z-index: 100;
            background: #FAF7F2;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            transition: opacity 0.5s ease, transform 0.5s ease;
            cursor: pointer;
        }
        #splash.hide {
            opacity: 0;
            transform: translateY(-20px);
            pointer-events: none;
        }

        .splash-bg {
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 50% 0%, rgba(107,142,90,0.10) 0%, transparent 70%),
                radial-gradient(ellipse 60% 40% at 80% 100%, rgba(255,122,48,0.08) 0%, transparent 60%);
        }

        .splash-grain {
            position: absolute; inset: 0; opacity: 0.025;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
        }

        .splash-content { position: relative; text-align: center; padding: 0 32px; }

        @keyframes flameUp {
            0%   { transform: scaleY(1) translateY(0); }
            50%  { transform: scaleY(1.08) translateY(-4px); }
            100% { transform: scaleY(1) translateY(0); }
        }
        @keyframes glowPulse {
            0%, 100% { filter: drop-shadow(0 0 20px rgba(255,122,48,0.25)); }
            50%       { filter: drop-shadow(0 0 40px rgba(255,122,48,0.4)); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes lineGrow {
            from { width: 0; }
            to   { width: 48px; }
        }
        @keyframes badgePop {
            0%   { transform: scale(0.5); opacity: 0; }
            70%  { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
        @keyframes ringShrink {
            from { stroke-dashoffset: 0; }
            to   { stroke-dashoffset: 100.5; }
        }

        .splash-icon {
            animation: glowPulse 3s ease-in-out infinite, flameUp 4s ease-in-out infinite;
            margin-bottom: 28px;
        }
        .splash-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(38px, 10vw, 56px);
            font-weight: 700;
            color: #2E2E2E;
            line-height: 1.05;
            letter-spacing: -0.02em;
            animation: fadeInUp 0.8s ease 0.3s both;
        }
        .splash-title em {
            font-style: italic;
            color: #FF7A30;
        }
        .splash-line {
            width: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(107,142,90,0.5), transparent);
            margin: 16px auto;
            animation: lineGrow 0.6s ease 0.9s both;
        }
        .splash-sub {
            font-size: 13px;
            color: #6B7280;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            animation: fadeInUp 0.8s ease 1s both;
        }
        .splash-meja {
            display: inline-flex; align-items: center; gap: 8px;
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 50px;
            padding: 8px 20px;
            margin-top: 28px;
            font-size: 13px; font-weight: 500;
            color: #6B7280;
            animation: badgePop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 1.2s both;
        }
        .splash-meja span { color: #6B8E5A; font-weight: 700; }
        .splash-cta {
            margin-top: 48px;
            animation: fadeIn 0.6s ease 1.8s both;
            position: relative;
            z-index: 2;
        }
        .btn-pill {
            border: none; border-radius: 50px; font-family: inherit;
            letter-spacing: -0.01em; cursor: pointer;
            transition: transform 0.15s ease, background 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-pill:active { transform: scale(0.94); }

        .splash-btn {
            background: #6B8E5A; color: #FFFFFF;
            padding: 14px 36px;
            font-size: 15px; font-weight: 600;
            box-shadow: 0 4px 24px rgba(107,142,90,0.3);
            display: inline-flex; align-items: center; gap: 8px;
        }
        .splash-btn:hover { background: #5A7A4A; box-shadow: 0 6px 32px rgba(107,142,90,0.4); }

        /* Skip ring progress */
        .splash-skip-wrap {
            display: flex; flex-direction: column; align-items: center;
            margin-top: 18px;
        }
        .skip-ring { transform: rotate(-90deg); }
        .skip-ring circle {
            fill: none; stroke-width: 2;
        }
        .skip-ring .ring-bg { stroke: #E5E7EB; }
        .skip-ring .ring-fg {
            stroke: #FF7A30;
            stroke-dasharray: 100.5;
            stroke-dashoffset: 0;
            animation: ringShrink 6s linear forwards;
        }
        .splash-skip {
            margin-top: 8px;
            font-size: 11px;
            color: #9CA3AF;
            letter-spacing: 0.05em;
        }

        /* ===================== MAIN PAGE ===================== */
        #main-page {
            position: fixed; inset: 0;
            background: #FAF7F2;
            display: flex; flex-direction: column;
            overflow-y: auto;
            opacity: 0; pointer-events: none;
            transition: opacity 0.5s ease;
        }
        #main-page.show {
            opacity: 1; pointer-events: all;
        }

        .page-bg {
            position: fixed; inset: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 70% 50% at 50% 0%, rgba(107,142,90,0.06) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 100% 100%, rgba(255,122,48,0.05) 0%, transparent 50%);
        }

        .page-inner {
            position: relative;
            max-width: 420px;
            width: 100%;
            margin: 0 auto;
            padding: 28px 16px 48px;
            min-height: 100%;
            display: flex; flex-direction: column;
        }

        /* Header */
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px;
            animation: fadeInUp 0.5s ease both;
        }
        .header-brand {
            font-family: 'Playfair Display', serif;
            font-size: 18px; font-weight: 700;
            color: #2E2E2E;
        }
        .header-brand em { font-style: italic; color: #FF7A30; }
        .header-meja {
            font-size: 11px; color: #6B7280;
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 50px; padding: 6px 14px;
            font-weight: 600;
        }

        /* Form Card */
        .form-card {
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 18px;
            padding: 24px 20px;
            animation: fadeInUp 0.5s ease 0.1s both;
            position: relative;
        }

        .form-title {
            font-size: 22px; font-weight: 600;
            color: #2E2E2E; margin-bottom: 4px;
            font-family: 'Playfair Display', serif;
        }
        .form-subtitle {
            font-size: 12px; color: #6B7280;
            margin-bottom: 22px; line-height: 1.6;
        }

        /* Input */
        .input-group { margin-bottom: 14px; }
        .input-label {
            display: block; font-size: 10px; font-weight: 600;
            color: #6B7280; text-transform: uppercase;
            letter-spacing: 0.1em; margin-bottom: 7px;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 13px; top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            pointer-events: none;
            display: flex;
        }
        .input-field {
            width: 100%;
            background: #FAF7F2;
            border: 1px solid #E5E7EB;
            border-radius: 11px;
            padding: 12px 14px 12px 40px;
            font-size: 14px;
            color: #2E2E2E;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s, background 0.2s;
        }
        .input-field:focus {
            border-color: #6B8E5A;
            background: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(107,142,90,0.1);
        }
        .input-field::placeholder { color: #9CA3AF; }

        /* Buttons */
        .btn-primary {
            width: 100%; background: #6B8E5A; color: #FFFFFF;
            padding: 13px; font-size: 14px; font-weight: 600;
            box-shadow: 0 4px 16px rgba(107,142,90,0.25);
            display: flex; align-items: center; justify-content: center; gap: 6px;
        }
        .btn-primary:hover { background: #5A7A4A; box-shadow: 0 6px 20px rgba(107,142,90,0.35); }

        .btn-outline {
            width: 100%;
            background: #FAF7F2;
            color: #6B7280;
            border: 1px solid #E5E7EB;
            padding: 13px; font-size: 14px; font-weight: 500;
            display: flex; align-items: center; justify-content: center; gap: 6px;
        }
        .btn-outline:hover {
            background: #F1EFE8;
            color: #2E2E2E;
        }

        /* Divider */
        .divider {
            display: flex; align-items: center; gap: 12px;
            margin: 16px 0;
        }
        .divider-line { flex: 1; height: 1px; background: #E5E7EB; }
        .divider-text { font-size: 11px; color: #9CA3AF; }

        /* Error */
        .error-box {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.25);
            color: #DC2626; border-radius: 10px;
            padding: 11px 14px; font-size: 12px;
            margin-bottom: 16px;
            display: flex; align-items: center; gap: 8px;
        }

        /* Switch form link */
        .switch-link {
            text-align: center; margin-top: 16px;
            font-size: 12px; color: #6B7280;
            animation: fadeIn 0.5s ease 0.3s both;
        }
        .switch-link a {
            color: #FF7A30; text-decoration: none; font-weight: 600;
            transition: color 0.15s;
        }
        .switch-link a:hover { color: #E8631C; }

        /* Poin info */
        .poin-info {
            margin-top: 18px;
            background: rgba(255,122,48,0.06);
            border: 1px solid rgba(255,122,48,0.18);
            border-radius: 14px; padding: 16px 16px;
            animation: fadeIn 0.5s ease 0.4s both;
        }
        .poin-info-title {
            font-size: 11px; font-weight: 600;
            color: #E8631C; text-transform: uppercase; letter-spacing: 0.1em;
            margin-bottom: 12px;
            display: flex; align-items: center; gap: 6px;
        }
        .poin-step { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 10px; }
        .poin-step:last-child { margin-bottom: 0; }
        .poin-step-num {
            width: 20px; height: 20px; border-radius: 50%;
            background: rgba(255,122,48,0.12); border: 1px solid rgba(255,122,48,0.3);
            color: #E8631C; font-size: 10px; font-weight: 700;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
            font-family: 'Inter', sans-serif;
        }
        .poin-step-text { font-size: 11.5px; color: #6B7280; line-height: 1.6; padding-top: 1px; }
        .poin-step-text b { color: #2E2E2E; font-weight: 600; }

        /* Form slide animation */
        .form-section {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        .form-section.hidden {
            opacity: 0; transform: translateX(20px);
            pointer-events: none; position: absolute;
            top: 0; left: 0; right: 0;
        }
        .form-section.visible {
            opacity: 1; transform: translateX(0);
        }
    </style>
</head>
<body>

{{-- ===================== SPLASH ===================== --}}
<div id="splash" onclick="showMain()">
    <div class="splash-bg"></div>
    <div class="splash-grain"></div>

    <div class="splash-content">
        {{-- Icon --}}
        <div class="splash-icon">
            <svg width="72" height="72" viewBox="0 0 72 72" fill="none">
                <path d="M36 8 C36 8 44 20 44 30 C44 38 38 42 36 42 C34 42 28 38 28 30 C28 20 36 8 36 8Z"
                      fill="url(#flame1)" opacity="0.9"/>
                <path d="M36 16 C36 16 40 24 40 30 C40 35 38 38 36 38 C34 38 32 35 32 30 C32 24 36 16 36 16Z"
                      fill="url(#flame2)" opacity="0.8"/>
                <rect x="34" y="40" width="4" height="22" rx="2" fill="rgba(255,122,48,0.5)"/>
                <circle cx="36" cy="28" r="14" fill="url(#glow)" opacity="0.25"/>
                <defs>
                    <radialGradient id="glow" cx="50%" cy="50%">
                        <stop offset="0%" stop-color="#FF7A30"/>
                        <stop offset="100%" stop-color="transparent"/>
                    </radialGradient>
                    <linearGradient id="flame1" x1="36" y1="8" x2="36" y2="42" gradientUnits="userSpaceOnUse">
                        <stop offset="0%" stop-color="#FFE8D6"/>
                        <stop offset="40%" stop-color="#FF7A30"/>
                        <stop offset="100%" stop-color="#B8541C"/>
                    </linearGradient>
                    <linearGradient id="flame2" x1="36" y1="16" x2="36" y2="38" gradientUnits="userSpaceOnUse">
                        <stop offset="0%" stop-color="#FFFFFF"/>
                        <stop offset="60%" stop-color="#FFC299"/>
                        <stop offset="100%" stop-color="#FF7A30"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>

        {{-- Title --}}
        <h1 class="splash-title">
            Sate <em>Taichan</em><br>&amp; Es Teh Solo
        </h1>
        <div class="splash-line"></div>
        <p class="splash-sub">Authentic · Fresh · Delicious</p>

        {{-- Meja badge --}}
        <div class="splash-meja">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Meja <span>{{ $noMeja }}</span>
        </div>

        {{-- CTA --}}
        <div class="splash-cta">
            <button class="splash-btn btn-pill" onclick="event.stopPropagation(); showMain()">
                Mulai Pesan
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </button>

            {{-- Skip indicator dengan ring progress --}}
            <div class="splash-skip-wrap">
                <svg class="skip-ring" width="20" height="20" viewBox="0 0 36 36">
                    <circle class="ring-bg" cx="18" cy="18" r="16"></circle>
                    <circle class="ring-fg" cx="18" cy="18" r="16"></circle>
                </svg>
                <span class="splash-skip">tap di mana saja untuk lanjut</span>
            </div>
        </div>
    </div>
</div>

{{-- ===================== MAIN PAGE ===================== --}}
<div id="main-page">
    <div class="page-bg"></div>
    <div class="page-inner">

        {{-- Header --}}
        <div class="page-header">
            <div class="header-brand">Sate <em>Taichan</em></div>
            <div class="header-meja">Meja {{ $noMeja }}</div>
        </div>

        {{-- Error --}}
        @if($errors->any())
        <div class="error-box" style="margin-bottom:16px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12" y2="16"/></svg>
            {{ $errors->first() }}
        </div>
        @endif

        {{-- Form Card --}}
        <div class="form-card">

            {{-- LOGIN FORM --}}
            <div id="section-login" class="form-section visible">
                <p class="form-title">Selamat datang!</p>
                <p class="form-subtitle">Masuk untuk kumpulkan poin & nikmati diskon spesial</p>

                <form method="POST" action="/menu/auth/login">
                    @csrf
                    <input type="hidden" name="meja" value="{{ $noMeja }}">

                    <div class="input-group">
                        <label class="input-label">Nama</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </span>
                            <input type="text" name="nama" class="input-field" placeholder="Nama kamu" value="{{ old('nama') }}" required>
                        </div>
                    </div>

                    <div class="input-group" style="margin-bottom:20px;">
                        <label class="input-label">No. Telepon</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 10a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.6a16 16 0 0 0 6 6l.92-.92a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </span>
                            <input type="text" name="no_telepon" class="input-field" placeholder="08xxxxxxxxxx" value="{{ old('no_telepon') }}" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary btn-pill">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                        Masuk
                    </button>
                </form>

                <div class="divider">
                    <div class="divider-line"></div>
                    <span class="divider-text">atau</span>
                    <div class="divider-line"></div>
                </div>

                <form method="POST" action="/menu/auth/guest">
                    @csrf
                    <input type="hidden" name="meja" value="{{ $noMeja }}">
                    <button type="submit" class="btn-outline btn-pill">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Lanjut sebagai Tamu
                    </button>
                </form>
            </div>

            {{-- REGISTER FORM --}}
            <div id="section-register" class="form-section hidden">
                <p class="form-title">Buat akun baru</p>
                <p class="form-subtitle">Daftar gratis & langsung kumpulkan poin dari pesanan pertama</p>

                <form method="POST" action="/menu/auth/register">
                    @csrf
                    <input type="hidden" name="meja" value="{{ $noMeja }}">

                    <div class="input-group">
                        <label class="input-label">Nama</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </span>
                            <input type="text" name="nama" class="input-field" placeholder="Nama lengkap" value="{{ old('nama') }}" required>
                        </div>
                    </div>

                    <div class="input-group" style="margin-bottom:20px;">
                        <label class="input-label">No. Telepon</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 10a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.6a16 16 0 0 0 6 6l.92-.92a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </span>
                            <input type="text" name="no_telepon" class="input-field" placeholder="08xxxxxxxxxx" value="{{ old('no_telepon') }}" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary btn-pill">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                        Daftar & Masuk
                    </button>
                </form>
            </div>

        </div>

        {{-- Switch link --}}
        <div class="switch-link" id="switch-to-register">
            Belum punya akun? <a href="#" onclick="switchForm('register'); return false;">Daftar sekarang</a>
        </div>
        <div class="switch-link" id="switch-to-login" style="display:none;">
            Sudah punya akun? <a href="#" onclick="switchForm('login'); return false;">Masuk di sini</a>
        </div>

        {{-- Poin info --}}
        <div class="poin-info">
            <div class="poin-info-title">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Program Poin Reward
            </div>
            <div class="poin-step">
                <div class="poin-step-num">1</div>
                <p class="poin-step-text"><b>Daftar atau login</b> pakai nama & nomor HP. Gratis, tanpa ribet.</p>
            </div>
            <div class="poin-step">
                <div class="poin-step-num">2</div>
                <p class="poin-step-text"><b>Kumpulkan poin tiap order</b> — Rp 15.000 = 1 poin, Rp 35.000 = 2 poin, dst.</p>
            </div>
            <div class="poin-step">
                <div class="poin-step-num">3</div>
                <p class="poin-step-text"><b>Tukar jadi diskon</b> — 10 poin = diskon Rp 15.000. Bisa langsung dipakai saat checkout.</p>
            </div>
        </div>

    </div>
</div>

<script>
    const hasError = {{ $errors->any() ? 'true' : 'false' }};
    const hasRegisterError = {{ $errors->has('no_telepon') ? 'true' : 'false' }};

    if (hasError) {
        document.getElementById('splash').style.display = 'none';
        document.getElementById('main-page').classList.add('show');
        if (hasRegisterError) switchForm('register');
    } else {
        setTimeout(showMain, 6000);
    }

    function showMain() {
        const splash = document.getElementById('splash');
        const main   = document.getElementById('main-page');
        splash.classList.add('hide');
        setTimeout(() => {
            splash.style.display = 'none';
            main.classList.add('show');
        }, 500);
    }

    function switchForm(to) {
        const login    = document.getElementById('section-login');
        const register = document.getElementById('section-register');
        const toLogin  = document.getElementById('switch-to-login');
        const toReg    = document.getElementById('switch-to-register');

        if (to === 'register') {
            login.classList.remove('visible'); login.classList.add('hidden');
            register.classList.remove('hidden'); register.classList.add('visible');
            toLogin.style.display = 'block';
            toReg.style.display = 'none';
        } else {
            register.classList.remove('visible'); register.classList.add('hidden');
            login.classList.remove('hidden'); login.classList.add('visible');
            toLogin.style.display = 'none';
            toReg.style.display = 'block';
        }
    }
</script>
</body>
</html>