<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin · Exclusive')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite('resources/css/app.css')

    {{-- Alpine.js ใช้ควบคุม sidebar mobile --}}
    <script src="https://unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-slate-950 text-slate-100">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">

        {{-- 🔥 Global Loading Overlay --}}
        <div id="global-loading" class="fixed inset-0 z-50 hidden flex flex-col items-center justify-start pt-16
               bg-slate-950/70 backdrop-blur-sm">
            <div class="w-full">
                <div class="mx-auto h-0.5 max-w-5xl overflow-hidden bg-slate-800/70">
                    <div class="h-full w-1/3 bg-amber-400 animate-[loading-slide_1.2s_ease-in-out_infinite]"></div>
                </div>
            </div>
            <div class="mt-6 flex flex-col items-center gap-2">
                <div class="h-7 w-7 rounded-full border-2 border-slate-500 border-t-transparent animate-spin"></div>
                <p class="text-xs text-slate-300">
                    กำลังประมวลผล กรุณารอสักครู่...
                </p>
            </div>
        </div>

        {{-- Sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-950/95 border-r border-slate-800
               transform transition-transform duration-200
               -translate-x-full md:translate-x-0
               flex flex-col md:static" :class="{ 'translate-x-0': sidebarOpen }">
            {{-- ปุ่มปิด (เฉพาะ mobile) --}}
            <button type="button" class="absolute right-3 top-3 md:hidden inline-flex items-center justify-center
                   h-8 w-8 rounded-full border border-slate-700 text-slate-200 text-sm" @click="sidebarOpen = false">
                ✕
            </button>

            <div class="px-5 pt-10 pb-4 border-b border-slate-800 md:pt-4">
                <div class="inline-flex items-center gap-2 rounded-full border border-amber-500/40
                       bg-amber-500/10 px-3 py-1">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                    <span class="text-[11px] uppercase tracking-[0.18em] text-amber-300">
                        Admin Panel
                    </span>
                </div>
                <h1 class="mt-3 text-lg font-semibold">Admin</h1>
                <p class="text-xs text-slate-500">จัดการคอนเทนต์ & สมาชิก</p>
            </div>

            <nav class="flex-1 px-3 py-4 text-sm space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center justify-between rounded-xl px-3 py-2 hover:bg-slate-800/80
                      {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800/80 text-amber-300' : 'text-slate-300' }}">
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.contents.index') }}"
                    class="block rounded-xl px-3 py-2 hover:bg-slate-800/80
                      {{ request()->routeIs('admin.contents.*') ? 'bg-slate-800/80 text-amber-300' : 'text-slate-300' }}">
                    คอนเทนต์ทั้งหมด
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="block rounded-xl px-3 py-2 hover:bg-slate-800/80
                      {{ request()->routeIs('admin.categories.*') ? 'bg-slate-800/80 text-amber-300' : 'text-slate-300' }}">
                    หมวดหมู่ (Categories)
                </a>


                <a href="{{ route('admin.members.index') }}"
                    class="block rounded-xl px-3 py-2 hover:bg-slate-800/80
                      {{ request()->routeIs('admin.members.*') ? 'bg-slate-800/80 text-amber-300' : 'text-slate-300' }}">
                    สมาชิก / Pending
                </a>

                <a href="{{ route('admin.payments.index') }}"
                    class="block rounded-xl px-3 py-2 hover:bg-slate-800/80
                      {{ request()->routeIs('admin.payments.*') ? 'bg-slate-800/80 text-amber-300' : 'text-slate-300' }}">
                    การชำระเงิน
                </a>
            </nav>

            <form method="POST" action="{{ route('admin.logout') }}" class="px-3 py-4 border-t border-slate-800">
                @csrf
                <button type="submit"
                    class="w-full inline-flex justify-center items-center rounded-lg border border-red-500/60 px-3 py-2 text-red-300 hover:bg-red-500/10">
                    ออกจากระบบ
                </button>
            </form>
        </aside>

        {{-- Backdrop ตอน sidebar เปิดบน mobile --}}
        <div class="fixed inset-0 z-30 bg-black/50 md:hidden" x-show="sidebarOpen" x-transition.opacity
            @click="sidebarOpen = false"></div>

        {{-- Main area --}}
        <div class="flex-1 flex flex-col min-h-screen">
            {{-- Top bar --}}
            <header class="border-b border-slate-800 bg-slate-950/70 backdrop-blur
                   px-4 py-3 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-semibold">
                        @yield('page-title', 'Dashboard')
                    </h2>
                    <p class="text-xs text-slate-500">
                        @yield('page-subtitle')
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden md:block text-xs text-slate-400">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </div>

                    {{-- ปุ่มเปิด sidebar บน mobile --}}
                    <button type="button" class="md:hidden inline-flex items-center justify-center
                           rounded-lg border border-slate-700 px-2 py-1 text-xs text-slate-200"
                        @click="sidebarOpen = true">
                        ☰
                    </button>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 px-4 py-6 md:px-6 md:py-8">
                @if(session('status'))
                    <div class="mb-4 rounded-xl border border-emerald-500/40
                                           bg-emerald-500/10 px-4 py-3 text-sm text-emerald-100">
                        {{ session('status') }}
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="border-t border-slate-800 py-3 text-center text-[11px] text-slate-500">
                © {{ date('Y') }} Exclusive Content Platform · Admin Panel
            </footer>
        </div>
    </div>

    {{-- Global loading script กันกดซ้ำ / โชว์ overlay --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loadingEl = document.getElementById('global-loading');
            let isLoading = false;

            function showLoading() {
                if (isLoading) return;
                isLoading = true;
                if (loadingEl) {
                    loadingEl.classList.remove('hidden');
                }
            }

            // 🔹 ดักทุก form submit
            document.querySelectorAll('form').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    if (isLoading) {
                        // กัน user กดซ้ำตอนกำลังโหลด
                        e.preventDefault();
                        return;
                    }
                    showLoading();

                    // disable ปุ่ม submit ในฟอร์มนั้น ๆ
                    form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(function (btn) {
                        btn.disabled = true;
                        btn.classList.add('opacity-60', 'cursor-not-allowed');
                    });
                });
            });

            // 🔹 ดักคลิกทุกลิงก์ (เปลี่ยนหน้า)
            const origin = window.location.origin;

            document.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function (e) {
                    // ถ้ากำลังโหลดแล้ว → กันกดซ้ำ
                    if (isLoading) {
                        e.preventDefault();
                        return;
                    }

                    const href = link.getAttribute('href');

                    // เคสที่ไม่ต้องโชว์โหลด
                    if (!href) return;
                    if (link.target === '_blank') return;
                    if (link.hasAttribute('download')) return;
                    if (link.dataset.noLoading === 'true') return;
                    if (href.startsWith('#')) return;
                    if (href.startsWith('javascript:')) return;

                    // ลิงก์ไป external domain ไม่ต้องโชว์
                    const url = new URL(href, origin);
                    if (url.origin !== origin) return;

                    // ลิงก์ภายในเว็บ → โชว์โหลด
                    showLoading();
                    // ไม่ต้อง preventDefault ปล่อยให้ browser เปลี่ยนหน้าได้ตามปกติ
                });
            });
        });
    </script>

    {{-- keyframes สำหรับแถบโหลดด้านบน --}}
    <style>
        @keyframes loading-slide {
            0% {
                transform: translateX(-100%);
            }

            50% {
                transform: translateX(20%);
            }

            100% {
                transform: translateX(120%);
            }
        }
    </style>

    @stack('scripts')
</body>

</html>