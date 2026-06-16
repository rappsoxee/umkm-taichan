<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register — Taichan POS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0f0a07;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            letter-spacing: -0.01em;
            padding: 24px;
        }
        .wrap { width: 100%; max-width: 420px; position: relative; z-index: 1; }
        .brand { text-align: center; margin-bottom: 32px; }
        .brand-name { font-family: 'Playfair Display', serif; font-size: 28px; color: #fff; margin: 0 0 4px; }
        .brand-sub { font-size: 13px; color: rgba(255,255,255,0.3); margin: 0; }
        .card { background: #150d08; border: 1px solid rgba(255,255,255,0.07); border-radius: 16px; padding: 32px; }
        .card-title { font-size: 16px; font-weight: 600; color: rgba(255,255,255,0.85); margin: 0 0 6px; }
        .card-desc { font-size: 13px; color: rgba(255,255,255,0.3); margin: 0 0 28px; }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 7px; }
        .form-input { width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 11px 14px; font-size: 14px; color: rgba(255,255,255,0.85); font-family: inherit; outline: none; transition: border-color 0.2s, background 0.2s; }
        .form-input:focus { border-color: rgba(194,120,10,0.6); background: rgba(255,255,255,0.07); }
        .form-input::placeholder { color: rgba(255,255,255,0.2); }
        .form-error { font-size: 12px; color: #f87171; margin-top: 6px; }
        .btn-submit { width: 100%; background: #c2780a; color: #fff; border: none; border-radius: 10px; padding: 13px; font-size: 14px; font-weight: 600; font-family: inherit; letter-spacing: -0.01em; cursor: pointer; transition: background 0.15s, transform 0.15s; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 8px; }
        .btn-submit:hover { background: #a8670a; }
        .btn-submit:active { transform: scale(0.97); }
        .login-link { text-align: center; margin-top: 20px; font-size: 13px; color: rgba(255,255,255,0.3); }
        .login-link a { color: rgba(194,120,10,0.8); text-decoration: none; }
        .login-link a:hover { color: #e09020; }
        .footer { text-align: center; margin-top: 16px; font-size: 12px; color: rgba(255,255,255,0.15); }
        body::before { content: ''; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-image: radial-gradient(circle, rgba(194,120,10,0.06) 1px, transparent 1px); background-size: 32px 32px; pointer-events: none; z-index: 0; }
        .pass-wrap { position: relative; }
        .pass-toggle { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: rgba(255,255,255,0.3); padding: 0; display: flex; align-items: center; transition: color 0.15s; }
        .pass-toggle:hover { color: rgba(255,255,255,0.6); }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="brand">
            <p class="brand-name">Taichan POS</p>
            <p class="brand-sub">Sate Taichan & Es Teh Solo</p>
        </div>

        <div class="card">
            <p class="card-title">Buat Akun Admin</p>
            <p class="card-desc">Daftarkan akun untuk mengakses panel admin</p>

            @if ($errors->any())
                <div style="background:rgba(220,38,38,0.1); border:1px solid rgba(220,38,38,0.2); color:#f87171; border-radius:10px; padding:12px 16px; font-size:13px; margin-bottom:20px; display:flex; align-items:center; gap:8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12" y2="16"/></svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Nama</label>
                    <input id="name" type="text" name="name"
                           class="form-input"
                           value="{{ old('name') }}"
                           placeholder="Nama lengkap"
                           required autofocus autocomplete="name">
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email"
                           class="form-input"
                           value="{{ old('email') }}"
                           placeholder="admin@example.com"
                           required autocomplete="username">
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="pass-wrap">
                        <input id="password" type="password" name="password"
                               class="form-input"
                               placeholder="Min. 8 karakter"
                               required autocomplete="new-password"
                               style="padding-right:42px;">
                        <button type="button" class="pass-toggle" onclick="togglePass('password', 'eye1')">
                            <svg id="eye1" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div class="pass-wrap">
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               class="form-input"
                               placeholder="Ulangi password"
                               required autocomplete="new-password"
                               style="padding-right:42px;">
                        <button type="button" class="pass-toggle" onclick="togglePass('password_confirmation', 'eye2')">
                            <svg id="eye2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    Buat Akun
                </button>
            </form>
        </div>

        <p class="login-link">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </p>
        <p class="footer">Taichan POS &copy; {{ date('Y') }} — Admin Only</p>
    </div>

    <script>
        function togglePass(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }
    </script>
</body>
</html>