<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 48px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            text-align: center;
        }
        .logo { font-size: 48px; margin-bottom: 12px; }
        h1 { font-size: 26px; color: #1a1a2e; margin-bottom: 8px; }
        p.subtitle { color: #666; font-size: 14px; margin-bottom: 32px; }

        .alert-error {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fca5a5;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            padding: 14px 20px;
            border-radius: 10px;
            border: none;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.15s, box-shadow 0.15s;
            margin-bottom: 14px;
        }
        .btn-social:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.15); }

        .btn-google { background: #fff; color: #3c4043; border: 2px solid #dadce0; }
        .btn-google:hover { background: #f8f9fa; }

        .btn-facebook { background: #1877f2; color: #fff; }
        .btn-facebook:hover { background: #166fe5; }

        .btn-social svg { width: 22px; height: 22px; flex-shrink: 0; }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 8px 0 20px;
            color: #aaa;
            font-size: 13px;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .info-box {
            margin-top: 28px;
            padding: 14px;
            background: #f0f4ff;
            border-radius: 8px;
            font-size: 13px;
            color: #4b5563;
            line-height: 1.6;
        }
        .info-box strong { color: #4f46e5; }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">🔐</div>
    <h1>Chào mừng trở lại</h1>
    <p class="subtitle">Đăng nhập bằng tài khoản mạng xã hội</p>

    @if(session('error'))
        <div class="alert-error">⚠️ {{ session('error') }}</div>
    @endif

    {{-- Đăng nhập Google --}}
    <a href="{{ route('social.redirect', 'google') }}" class="btn-social btn-google">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
        </svg>
        Đăng nhập với Google
    </a>

    <div class="divider">hoặc</div>

    {{-- Đăng nhập Facebook --}}
    <a href="{{ route('social.redirect', 'facebook') }}" class="btn-social btn-facebook">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#fff">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
        </svg>
        Đăng nhập với Facebook
    </a>

</div>
</body>
</html>
