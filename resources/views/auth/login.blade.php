<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Taichan POS</title>
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
        .card-desc { font-size: 13px; color: rgba(255,255,255,0.3); margin: 0 0 28px; }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 7px; }
        .form-input { width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 11px 14px; font-size: 14px; color: rgba(255,255,255,0.85); font-family: inherit; outline: none; transition: border-color 0.2s, background 0.2s; }
        .form-input:focus { border-color: rgba(194,120,10,0.6); background: rgba(255,255,255,0.07); }
        .form-input::placeholder { color: rgba(255,255,255,0.2); }
        .form-error { font-size: 12px; color: #f87171; margin-top: 6px; }
        .form-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .remember-label { display: flex; align-items: center; gap: 7px; font-size: 13px; color: rgba(255,255,255,0.4); cursor: pointer; }
        .remember-check { width: 15px; height: 15px; accent-color: #c2780a; cursor: pointer; }
        .forgot-link { font-size: 13px; color: rgba(194,120,10,0.8); text-decoration: none; transition: color 0.15s; }
        .forgot-link:hover { color: #e09020; }
        .btn-login { width: 100%; background: #c2780a; color: #fff; border: none; border-radius: 10px; padding: 13px; font-size: 14px; font-weight: 600; font-family: inherit; letter-spacing: -0.01em; cursor: pointer; transition: background 0.15s, transform 0.15s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .btn-login:hover { background: #a8670a; }
        .btn-login:active { transform: scale(0.97); }
        .alert-error { background: rgba(220,38,38,0.1); border: 1px solid rgba(220,38,38,0.2); color: #f87171; border-radius: 10px; padding: 12px 16px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2); color: #4ade80; border-radius: 10px; padding: 12px 16px; font-size: 13px; margin-bottom: 20px; }
        .pass-wrap { position: relative; }
        .pass-toggle { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: rgba(255,255,255,0.3); padding: 0; display: flex; align-items: center; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: rgba(255,255,255,0.15); }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="brand">
            <p class="brand-name">SoChan</p>
            <p class="brand-sub">Es Teh Solo & Sate Taichan</p>
        </div>

        <div class="card">
            <p class="card-title">Masuk ke Admin Panel</p>
            <p class="card-desc">Silakan login untuk melanjutkan</p>

            @if (session('status'))
                <div class="alert-success">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert-error">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12" y2="16"/></svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email"
                           class="form-input"
                           value="{{ old('email') }}"
                           placeholder="admin@example.com"
                           required autofocus autocomplete="username">
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="pass-wrap">
                        <input id="password" type="password" name="password"
                               class="form-input"
                               placeholder="••••••••"
                               required autocomplete="current-password"
                               style="padding-right:42px;">
                        <button type="button" class="pass-toggle" onclick="togglePass()">
                            <svg id="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" class="remember-check">
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Masuk
                </button>
            </form>
        </div>

        <p class="footer">Taichan POS &copy; {{ date('Y') }} — Admin Only</p>
    </div>

    <script>
        function togglePass() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
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