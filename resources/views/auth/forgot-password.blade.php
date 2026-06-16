<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password — Taichan POS</title>
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
        .card { background: #150d08; border: 1px solid rgba(255,255,255,0.07); border-radius: 16px; padding: 32px; }
        .card-title { font-size: 16px; font-weight: 600; color: rgba(255,255,255,0.85); margin: 0 0 6px; }
        .card-desc { font-size: 13px; color: rgba(255,255,255,0.35); margin: 0 0 24px; line-height: 1.6; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 7px; }
        .form-input { width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 11px 14px; font-size: 14px; color: rgba(255,255,255,0.85); font-family: inherit; outline: none; transition: border-color 0.2s; }
        .form-input:focus { border-color: rgba(194,120,10,0.6); }
        .form-input::placeholder { color: rgba(255,255,255,0.2); }
        .form-error { font-size: 12px; color: #f87171; margin-top: 6px; }
        .btn-submit { width: 100%; background: #c2780a; color: #fff; border: none; border-radius: 10px; padding: 13px; font-size: 14px; font-weight: 600; font-family: inherit; cursor: pointer; transition: background 0.15s, transform 0.15s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .btn-submit:hover { background: #a8670a; }
        .btn-submit:active { transform: scale(0.97); }
        .alert-success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2); color: #4ade80; border-radius: 10px; padding: 12px 16px; font-size: 13px; margin-bottom: 20px; line-height: 1.5; }
        .back-link { text-align: center; margin-top: 20px; font-size: 13px; color: rgba(255,255,255,0.3); }
        .back-link a { color: rgba(194,120,10,0.8); text-decoration: none; }
        .back-link a:hover { color: #e09020; }
        .footer { text-align: center; margin-top: 16px; font-size: 12px; color: rgba(255,255,255,0.15); }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="brand">
            <p class="brand-name">Taichan POS</p>
            <p class="brand-sub">Sate Taichan & Es Teh Solo</p>
        </div>
        <div class="card">
            <p class="card-title">Lupa Password?</p>
            <p class="card-desc">Masukkan email kamu dan kami akan kirimkan link untuk reset password.</p>

            @if (session('status'))
                <div class="alert-success">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div style="background:rgba(220,38,38,0.1);border:1px solid rgba(220,38,38,0.2);color:#f87171;border-radius:10px;padding:12px 16px;font-size:13px;margin-bottom:20px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email"
                           class="form-input"
                           value="{{ old('email') }}"
                           placeholder="admin@example.com"
                           required autofocus>
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn-submit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    Kirim Link Reset
                </button>
            </form>
        </div>
        <p class="back-link"><a href="{{ route('login') }}">← Kembali ke Login</a></p>
        <p class="footer">Taichan POS &copy; {{ date('Y') }} — Admin Only</p>
    </div>
</body>
</html>