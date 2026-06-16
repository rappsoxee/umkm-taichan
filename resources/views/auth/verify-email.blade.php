<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email — Taichan POS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #0f0a07; min-height: 100vh; display: flex; align-items: center; justify-content: center; letter-spacing: -0.01em; padding: 24px; }
        body::before { content: ''; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-image: radial-gradient(circle, rgba(194,120,10,0.06) 1px, transparent 1px); background-size: 32px 32px; pointer-events: none; z-index: 0; }
        .wrap { width: 100%; max-width: 420px; position: relative; z-index: 1; }
        .brand { text-align: center; margin-bottom: 32px; }
        .brand-name { font-family: 'Playfair Display', serif; font-size: 28px; color: #fff; margin: 0 0 4px; }
        .brand-sub { font-size: 13px; color: rgba(255,255,255,0.3); margin: 0; }
        .card { background: #150d08; border: 1px solid rgba(255,255,255,0.07); border-radius: 16px; padding: 32px; text-align: center; }
        .icon-wrap { width: 64px; height: 64px; background: rgba(194,120,10,0.1); border: 1px solid rgba(194,120,10,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
        .card-title { font-size: 16px; font-weight: 600; color: rgba(255,255,255,0.85); margin: 0 0 10px; }
        .card-desc { font-size: 13px; color: rgba(255,255,255,0.35); margin: 0 0 24px; line-height: 1.6; }
        .alert-success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2); color: #4ade80; border-radius: 10px; padding: 12px 16px; font-size: 13px; margin-bottom: 20px; line-height: 1.5; }
        .btn-submit { width: 100%; background: #c2780a; color: #fff; border: none; border-radius: 10px; padding: 13px; font-size: 14px; font-weight: 600; font-family: inherit; cursor: pointer; transition: background 0.15s, transform 0.15s; display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 12px; }
        .btn-submit:hover { background: #a8670a; }
        .btn-submit:active { transform: scale(0.97); }
        .btn-logout { width: 100%; background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.4); border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 11px; font-size: 13px; font-family: inherit; cursor: pointer; transition: all 0.15s; }
        .btn-logout:hover { background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.6); }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: rgba(255,255,255,0.15); }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="brand">
            <p class="brand-name">Taichan POS</p>
            <p class="brand-sub">Sate Taichan & Es Teh Solo</p>
        </div>
        <div class="card">
            <div class="icon-wrap">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#c2780a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </div>
            <p class="card-title">Verifikasi Email Kamu</p>
            <p class="card-desc">Kami sudah mengirim link verifikasi ke email kamu. Cek inbox dan klik link tersebut untuk melanjutkan.</p>

            @if (session('status') == 'verification-link-sent')
                <div class="alert-success">Link verifikasi baru sudah dikirim ke email kamu.</div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-submit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Keluar</button>
            </form>
        </div>
        <p class="footer">Taichan POS &copy; {{ date('Y') }} — Admin Only</p>
    </div>
</body>
</html>