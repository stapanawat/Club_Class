<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8" />
    <title>ยืนยันอีเมล</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #020617;
            color: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            background: #020617;
            border-radius: 1rem;
            padding: 2rem 2.5rem;
            border: 1px solid rgba(148, 163, 184, 0.4);
            box-shadow: 0 25px 40px rgba(15, 23, 42, 0.9);
            max-width: 480px;
            width: 100%;
            text-align: center;
        }
        h1 {
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
        }
        p {
            font-size: 0.9rem;
            color: #9ca3af;
        }
        a.btn {
            display: inline-block;
            margin-top: 1.5rem;
            padding: 0.5rem 1.25rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            background: #f59e0b;
            color: #0f172a;
        }
    </style>
</head>
<body>
<div class="card">
    @if($status === 'success')
        <h1>ยืนยันอีเมลสำเร็จ 🎉</h1>
    @elseif($status === 'expired')
        <h1>ลิงก์หมดอายุ ⏰</h1>
    @else
        <h1>ไม่สามารถยืนยันได้ ❌</h1>
    @endif

    <p>{{ $message }}</p>

    <a href="{{ url('/login') }}" class="btn">ไปหน้าเข้าสู่ระบบ</a>
</div>
</body>
</html>
