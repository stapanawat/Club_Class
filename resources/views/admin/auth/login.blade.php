<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Admin Login · Club Class</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite('resources/css/app.css')
</head>

<body class="bg-slate-950 text-slate-100 flex items-center justify-center min-h-screen px-4">

    {{-- BG Glow สวย ๆ --}}
    <div class="fixed inset-0 pointer-events-none">
        <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-[500px] h-[500px] 
                    bg-amber-500/10 blur-[120px] rounded-full"></div>
    </div>

    {{-- Login Box --}}
    <div class="relative w-full max-w-md rounded-2xl bg-slate-900/70 border border-slate-800
                shadow-xl shadow-black/40 backdrop-blur-xl p-8">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 mb-3 rounded-full border 
                        border-amber-500/40 bg-amber-500/10 px-3 py-1
                        text-[11px] uppercase tracking-[0.2em] text-amber-300">
                ADMIN LOGIN
            </div>

            <h1 class="text-2xl font-bold text-white"> Admin</h1>
            <p class="mt-1 text-sm text-slate-400">
                เข้าสู่ระบบเพื่อจัดการคอนเทนต์และสมาชิก
            </p>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-slate-200">อีเมล</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm
                           text-slate-100 placeholder-slate-500 focus:border-amber-500 focus:ring-1
                           focus:ring-amber-500 transition outline-none" placeholder="example@domain.com">
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-slate-200">รหัสผ่าน</label>
                <input type="password" name="password" required class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm
                           text-slate-100 placeholder-slate-500 focus:border-amber-500 focus:ring-1
                           focus:ring-amber-500 transition outline-none" placeholder="••••••••">
            </div>

            {{-- Error --}}
            @if($errors->any())
                <div class="text-xs text-red-400 font-medium">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Submit Button --}}
            <button type="submit" id="login-btn" class="w-full rounded-xl bg-gradient-to-r from-amber-400 to-amber-500
                       text-slate-900 py-2.5 text-sm font-semibold shadow-lg
                       hover:from-amber-300 hover:to-amber-400 transition active:scale-[0.98]
                       flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">

                {{-- Spinner --}}
                <svg id="login-spinner" class="hidden animate-spin h-5 w-5 text-slate-900"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>

                <span id="login-text">เข้าสู่ระบบผู้ดูแล</span>
            </button>
        </form>

        <script>
            document.querySelector('form').addEventListener('submit', function (e) {
                const btn = document.getElementById('login-btn');
                const spinner = document.getElementById('login-spinner');
                const text = document.getElementById('login-text');

                if (btn && spinner && text) {
                    btn.disabled = true;
                    spinner.classList.remove('hidden');
                    text.textContent = 'กำลังเข้าสู่ระบบ...';
                }
            });
        </script>

        {{-- Footer --}}
        <p class="mt-6 text-center text-xs text-slate-500">
            © {{ date('Y') }} Exclusive Platform — Admin Panel
        </p>
    </div>

</body>

</html>