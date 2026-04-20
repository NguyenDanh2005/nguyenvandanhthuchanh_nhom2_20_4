<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard – {{ auth()->user()->name }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f3f4f6;
            min-height: 100vh;
        }

        /* Navbar */
        nav {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }
        nav .brand { color: #fff; font-size: 20px; font-weight: 700; }
        nav .nav-right { display: flex; align-items: center; gap: 16px; }
        nav .nav-right span { color: rgba(255,255,255,0.85); font-size: 14px; }

        .btn-logout {
            background: rgba(255,255,255,0.2);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.4);
            padding: 8px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-logout:hover { background: rgba(255,255,255,0.35); }

        /* Main */
        main { max-width: 800px; margin: 40px auto; padding: 0 20px; }

        .welcome-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 24px;
        }
        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid rgba(255,255,255,0.6);
            object-fit: cover;
            flex-shrink: 0;
        }
        .avatar-placeholder {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            flex-shrink: 0;
        }
        .welcome-text h2 { font-size: 24px; margin-bottom: 6px; }
        .welcome-text p { font-size: 14px; opacity: 0.85; }

        /* Info cards */
        .cards { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
        @media (max-width: 600px) { .cards { grid-template-columns: 1fr; } }

        .card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .card-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #9ca3af;
            margin-bottom: 8px;
        }
        .card-value {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }
        .card-icon { font-size: 28px; margin-bottom: 12px; }

        /* Provider badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        .badge-google { background: #e8f0fe; color: #1a73e8; }
        .badge-facebook { background: #e7f0fd; color: #1877f2; }

        /* Student info highlight */
        .student-card {
            background: linear-gradient(135deg, #f0f4ff, #e8f5e9);
            border: 2px solid #c7d2fe;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
        }
        .student-card h3 {
            font-size: 16px;
            color: #4f46e5;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .student-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e7ff;
            font-size: 15px;
        }
        .student-row:last-child { border-bottom: none; }
        .student-row .label { color: #6b7280; }
        .student-row .value { font-weight: 600; color: #1f2937; }
    </style>
</head>
<body>

<nav>
    <span class="brand">🎓 Social Login Demo</span>
    <div class="nav-right">
        <span>Xin chào, {{ auth()->user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">Đăng xuất</button>
        </form>
    </div>
</nav>

<main>
    {{-- Banner chào mừng --}}
    <div class="welcome-banner">
        @if(auth()->user()->avatar)
            <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="avatar">
        @else
            <div class="avatar-placeholder">👤</div>
        @endif
        <div class="welcome-text">
            <h2>Chào mừng, {{ auth()->user()->name }}! 👋</h2>
            <p>Bạn đã đăng nhập thành công qua
                @if(auth()->user()->provider === 'google') Google
                @elseif(auth()->user()->provider === 'facebook') Facebook
                @else hệ thống
                @endif
            </p>
        </div>
    </div>

    {{-- Thông tin tài khoản --}}
    <div class="cards">
        <div class="card">
            <div class="card-icon">👤</div>
            <div class="card-label">Tên hiển thị</div>
            <div class="card-value">{{ auth()->user()->name }}</div>
        </div>
        <div class="card">
            <div class="card-icon">📧</div>
            <div class="card-label">Email</div>
            <div class="card-value" style="font-size:14px; word-break:break-all;">{{ auth()->user()->email }}</div>
        </div>
        <div class="card">
            <div class="card-icon">🔗</div>
            <div class="card-label">Đăng nhập qua</div>
            <div class="card-value">
                @if(auth()->user()->provider === 'google')
                    <span class="badge badge-google">🔵 Google</span>
                @elseif(auth()->user()->provider === 'facebook')
                    <span class="badge badge-facebook">🔷 Facebook</span>
                @else
                    <span>—</span>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-icon">🆔</div>
            <div class="card-label">Mã sinh viên (DB)</div>
            <div class="card-value">{{ auth()->user()->student_id ?? 'Chưa cập nhật' }}</div>
        </div>
    </div>
</main>

</body>
</html>
