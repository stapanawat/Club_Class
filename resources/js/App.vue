<template>
  <div
    class="min-h-screen bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-slate-100"
    :class="mobileMenuOpen ? 'overflow-hidden' : ''"
  >
    <!-- Global Loading Overlay -->
    <transition name="fade">
      <div
        v-if="globalLoading"
        class="fixed inset-0 z-[9999] flex flex-col items-center justify-start pt-16 bg-slate-950/60 backdrop-blur-sm"
      >
        <!-- Top thin bar -->
        <div class="w-full">
          <div class="mx-auto h-0.5 max-w-6xl overflow-hidden bg-slate-800/70">
            <div class="loading-bar h-full w-1/3 bg-amber-400"></div>
          </div>
        </div>
        <!-- Spinner + text -->
        <div class="mt-6 flex flex-col items-center gap-2">
          <div
            class="h-7 w-7 rounded-full border-2 border-slate-500 border-t-transparent animate-spin"
          ></div>
          <p class="text-xs text-slate-300">
            กำลังโหลดข้อมูล กรุณารอสักครู่...
          </p>
        </div>
      </div>
    </transition>

    <!-- Navbar -->
    <header
      class="sticky top-0 z-30 border-b border-white/5 bg-slate-950/70 backdrop-blur"
      :class="globalLoading ? 'pointer-events-none opacity-70' : ''"
    >
      <div
        class="layout-header-inner mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-2 sm:px-4 sm:py-3 lg:px-0 lg:py-4"
      >
        <!-- Logo -->
        <RouterLink to="/" class="flex items-center gap-2 flex-shrink-0">
          <div
            class="inline-flex h-9 items-center rounded-2xl bg-amber-500/10 px-4 ring-1 ring-amber-500/40"
          >
                <img
      :src="playButton"
      alt="play"
      class="h-6 w-6 opacity-90 group-hover:scale-110 group-hover:opacity-100 transition"
    />
          </div>

          <div class="flex flex-col leading-tight hidden sm:flex">
            <span class="text-sm font-semibold">Club Class</span>
            <span class="text-[11px] text-slate-400">
              Premium Content Platform
            </span>
          </div>
        </RouterLink>

        <!-- Mobile Menu Button -->
        <button
          @click="mobileMenuOpen = !mobileMenuOpen"
          class="md:hidden text-slate-300 hover:text-amber-400 transition"
          :disabled="globalLoading"
        >
          <svg
            v-if="!mobileMenuOpen"
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            />
          </svg>
          <svg
            v-else
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>

          <!-- Desktop Nav (เริ่มที่ md ขึ้นไป) -->
        <nav class="hidden md:flex items-center gap-3 text-sm">
          <RouterLink
            to="/"
            class="text-sm transition-colors"
            :class="
              isActive('/')
                ? 'text-amber-400 font-semibold'
                : 'text-slate-300 hover:text-amber-400'
            "
          >
            หน้าแรก
          </RouterLink>

          <RouterLink
            to="/contents"
            class="text-sm transition-colors"
            :class="
              isActive('/contents')
                ? 'text-amber-400 font-semibold'
                : 'text-slate-300 hover:text-amber-400'
            "
          >
            คอนเทนต์
          </RouterLink>

          <!-- Subscription CTA (Desktop) -->
          

          <RouterLink
            v-if="isLoggedIn"
            to="/dashboard"
            class="text-sm transition-colors"
            :class="
              isActive('/dashboard')
                ? 'text-amber-400 font-semibold'
                : 'text-slate-300 hover:text-amber-400'
            "
          >
            Dashboard
          </RouterLink>
          <RouterLink
            to="/subscription"
            class="relative group overflow-hidden rounded-full bg-gradient-to-r from-amber-500 to-yellow-500 px-4 py-1.5 text-xs font-bold text-slate-900 shadow-[0_0_15px_rgba(245,158,11,0.4)] transition-all duration-300 hover:scale-105 hover:shadow-[0_0_25px_rgba(245,158,11,0.6)] hover:from-amber-400 hover:to-yellow-400"
          >
            <span class="relative z-10 flex items-center gap-1">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
              </svg>
              สมัครแพ็คเกจ
            </span>
            <!-- Shine Effect -->
            <div class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1s_infinite] bg-gradient-to-r from-transparent via-white/30 to-transparent z-0"></div>
          </RouterLink>

          <!-- ถ้ายังไม่ login -->
          <template v-if="!isLoggedIn">
            <div class="h-4 w-px bg-slate-700 mx-1"></div>
            <RouterLink
              to="/login"
              class="text-slate-300 hover:text-white transition text-xs"
              :class="isActive('/login') ? 'text-amber-300' : ''"
            >
              เข้าสู่ระบบ
            </RouterLink>
          </template>

          <!-- ถ้า login -->
          <template v-else>
            <div class="h-4 w-px bg-slate-700 mx-1"></div>
            <span class="text-xs text-slate-400">
              <span class="text-slate-100">{{ userName || 'สมาชิก' }}</span>
            </span>
            <button
              @click="handleLogout"
              class="text-slate-400 hover:text-white transition text-xs"
              :disabled="globalLoading"
            >
              ออก
            </button>
          </template>
        </nav>
      </div>
    </header>

    <!-- Blur background overlay (เฉพาะ mobile ตอนเปิดเมนู) -->
    <transition name="fade">
      <div
        v-if="mobileMenuOpen"
  class="fixed inset-0 z-30 bg-slate-900/40 backdrop-blur-xl sm:hidden"
      ></div>
    </transition>

    <!-- Mobile Fullscreen Overlay Menu -->
    <transition name="slide-fade">
      <div
        v-if="mobileMenuOpen"
  class="fixed inset-0 z-40 bg-slate-950/95 backdrop-blur-sm md:hidden"
      >
        <div class="flex h-full flex-col">
          <!-- Top bar ใน overlay -->
          <div
            class="flex items-center justify-between px-4 py-4 border-b border-slate-800/70"
          >
        <RouterLink to="/" class="flex items-center gap-2 flex-shrink-0">
          <div
            class="inline-flex h-9 items-center rounded-2xl bg-amber-500/10 px-4 ring-1 ring-amber-500/40"
          >
                <img
      :src="playButton"
      alt="play"
      class="h-6 w-6 opacity-90 group-hover:scale-110 group-hover:opacity-100 transition"
    />
          </div>

          <div class="flex flex-col leading-tight">
            <span class="text-sm font-semibold">Club Class</span>
            <span class="text-[11px] text-slate-400">
              Premium Content Platform
            </span>
          </div>
        </RouterLink>


            <button
              @click="mobileMenuOpen = false"
              class="text-slate-400 hover:text-amber-400 transition"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>

          <!-- เมนูหลัก -->
          <nav class="flex-1 px-6 py-8 space-y-4 text-lg overflow-y-auto">
            <RouterLink
              to="/"
              @click="mobileMenuOpen = false"
              class="group relative block rounded-2xl px-5 py-4 border border-white/10 text-slate-400 font-medium transition-all duration-300 overflow-hidden hover:border-amber-500 hover:shadow-[0_0_20px_rgba(245,158,11,0.3)]"
              :class="isActive('/') ? '!text-amber-300 bg-gradient-to-r from-amber-500/10 to-transparent border-amber-500 shadow-[0_0_15px_rgba(245,158,11,0.2)]' : ''"
            >
              <!-- Hover Gradient & Shine -->
              <div class="absolute inset-0 bg-gradient-to-r from-amber-600/20 via-amber-900/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
              <div class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/5 to-transparent z-0"></div>
              
              <span class="relative z-10 group-hover:text-amber-200 transition-colors">หน้าแรก</span>
            </RouterLink>

            <RouterLink
              to="/contents"
              @click="mobileMenuOpen = false"
              class="group relative block rounded-2xl px-5 py-4 border border-white/10 text-slate-400 font-medium transition-all duration-300 overflow-hidden hover:border-amber-500 hover:shadow-[0_0_20px_rgba(245,158,11,0.3)]"
              :class="isActive('/contents') ? '!text-amber-300 bg-gradient-to-r from-amber-500/10 to-transparent border-amber-500 shadow-[0_0_15px_rgba(245,158,11,0.2)]' : ''"
            >
              <div class="absolute inset-0 bg-gradient-to-r from-amber-600/20 via-amber-900/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
              <div class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/5 to-transparent z-0"></div>
              
              <span class="relative z-10 group-hover:text-amber-200 transition-colors">คอนเทนต์</span>
            </RouterLink>

            <!-- Subscription CTA (Mobile) -->


            <RouterLink
              v-if="isLoggedIn"
              to="/dashboard"
              @click="mobileMenuOpen = false"
              class="group relative block rounded-2xl px-5 py-4 border border-white/10 text-slate-400 font-medium transition-all duration-300 overflow-hidden hover:border-amber-500 hover:shadow-[0_0_20px_rgba(245,158,11,0.3)]"
              :class="isActive('/dashboard') ? '!text-amber-300 bg-gradient-to-r from-amber-500/10 to-transparent border-amber-500 shadow-[0_0_15px_rgba(245,158,11,0.2)]' : ''"
            >
              <div class="absolute inset-0 bg-gradient-to-r from-amber-600/20 via-amber-900/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
              <div class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/5 to-transparent z-0"></div>
              
              <span class="relative z-10 group-hover:text-amber-200 transition-colors">Dashboard</span>
            </RouterLink>
            <RouterLink
              to="/subscription"
              @click="mobileMenuOpen = false"
              class="group relative block rounded-2xl px-5 py-4 ] text-amber-300 font-bold transition-all duration-300 overflow-hidden "
              :class="isActive('/subscription') ? 'bg-amber-500/30 border-amber-400 shadow-[0_0_20px_rgba(245,158,11,0.3)]' : ''"
            >
              <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
              <div class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/10 to-transparent z-0"></div>
              
              <span class="relative z-10 flex items-center gap-3">
                <div class="p-1.5 rounded-full bg-amber-500 text-slate-900 shadow-lg shadow-amber-500/50">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
                  </svg>
                </div>
                <span class="group-hover:text-amber-200 transition-colors">สมัครแพ็คเกจ</span>
              </span>
            </RouterLink>
            <!-- ยังไม่ login -->
            <template v-if="!isLoggedIn">
              <RouterLink
                to="/login"
                @click="mobileMenuOpen = false"
                class="group relative block rounded-full px-5 py-3 border border-slate-600 text-sm text-slate-300 font-medium text-center transition-all duration-300 overflow-hidden hover:border-amber-500 hover:text-amber-300 hover:shadow-[0_0_15px_rgba(245,158,11,0.2)]"
                :class="isActive('/login') ? 'border-amber-400 text-amber-300 bg-slate-900' : ''"
              >
                <span class="relative z-10">เข้าสู่ระบบ</span>
              </RouterLink>
            </template>

            <!-- login แล้ว -->
            <template v-else>
              <button
                @click="() => { handleLogout(); mobileMenuOpen = false; }"
                class="group relative w-full rounded-full px-5 py-3 border border-slate-600 text-sm text-slate-300 font-medium text-center transition-all duration-300 overflow-hidden hover:border-red-500 hover:text-red-300 hover:bg-red-500/10 hover:shadow-[0_0_15px_rgba(239,68,68,0.3)]"
                :disabled="globalLoading"
              >
                <span class="relative z-10">ออกจากระบบ</span>
              </button>
            </template>
          </nav>
        </div>
      </div>
    </transition>

    <!-- Main -->
    <main class="layout-main mx-auto max-w-6xl px-4 py-6 sm:px-4 sm:py-8 lg:px-0">
      <RouterView />
    </main>

    <!-- Footer -->
    <footer
      class="border-t border-slate-800/80 py-4 text-center text-xs text-slate-500"
    >
      © {{ new Date().getFullYear() }} Exclusive Content Platform · Made for
      Internship Demo
    </footer>
  </div>
</template>

<script setup>
import playButton from '@/assets/play-button.png';

import { RouterView, RouterLink, useRouter, useRoute } from 'vue-router';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const mobileMenuOpen = ref(false);
const router = useRouter();
const route = useRoute();

// global auth / token
const TOKEN_KEY = 'auth_token';

const isLoggedIn = ref(false);
const userName = ref(null);

// 🔥 Global loading state สำหรับทั้งแอป
const globalLoading = ref(false);
const pendingRequests = ref(0);

// helper เช็คว่า path นี้คือหน้าไหน (เอาไว้ไฮไลต์เมนู)
const isActive = (path) => {
  if (path === '/') {
    return route.path === '/';
  }
  return route.path.startsWith(path);
};

// ตั้ง axios interceptor แค่ครั้งเดียว (กัน HMR สมัครซ้ำ)
if (!window.__AXIOS_GLOBAL_INTERCEPTOR_SET__) {
  window.__AXIOS_GLOBAL_INTERCEPTOR_SET__ = true;

  axios.interceptors.request.use(
    (config) => {
      pendingRequests.value++;
      globalLoading.value = true;
      return config;
    },
    (error) => {
      return Promise.reject(error);
    },
  );

  axios.interceptors.response.use(
    (response) => {
      pendingRequests.value = Math.max(0, pendingRequests.value - 1);
      if (pendingRequests.value === 0) {
        globalLoading.value = false;
      }
      return response;
    },
    (error) => {
      pendingRequests.value = Math.max(0, pendingRequests.value - 1);
      if (pendingRequests.value === 0) {
        globalLoading.value = false;
      }
      return Promise.reject(error);
    },
  );
}

const syncAuthState = async () => {
  const token = localStorage.getItem(TOKEN_KEY);
  isLoggedIn.value = !!token;

  if (!token) {
    userName.value = null;
    return;
  }

  try {
    const res = await axios.get('/me', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    userName.value = res.data?.name || res.data?.user?.name || null;
  } catch (e) {
    console.warn('load current user failed (แต่ถือว่า login อยู่)', e);
  }
};

const handleLogout = async () => {
  // กันกดรัว ๆ ตอนมี request อื่นอยู่
  if (globalLoading.value) return;

  const token = localStorage.getItem(TOKEN_KEY);

  try {
    await axios.post(
      '/api/logout',
      {},
      {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      },
    );
  } catch (e) {
    console.warn('logout error (ignored)', e);
  }

  localStorage.removeItem(TOKEN_KEY);
  isLoggedIn.value = false;
  userName.value = null;
  router.push('/');
};

onMounted(() => {
  syncAuthState();

  // ถ้า login page แก้ token ใน localStorage เราจะ sync ตาม
  window.addEventListener('storage', (e) => {
    if (e.key === TOKEN_KEY) {
      syncAuthState();
    }
  });

  // event เผื่อยิงเอง จากหน้า login หลัง login สำเร็จ
  window.addEventListener('auth-changed', syncAuthState);
});
</script>

<style scoped>
/* fade transition (ใช้ทั้ง loading + blur overlay) */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.25s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* แถบโหลดด้านบน */
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

.loading-bar {
  animation: loading-slide 1.2s ease-in-out infinite;
}

/* overlay menu transition */
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: opacity 0.2s ease, transform 0.2s ease;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
  opacity: 0;
  transform: translateY(-4px);
}

/* ปรับ layout สำหรับมือถือแนวนอน (จอเตี้ย) ให้ header/main บางลง */
@media (orientation: landscape) and (max-width: 1023px) {
  .layout-header-inner {
    padding-top: 0.35rem;
    padding-bottom: 0.35rem;
  }

  .layout-main {
    padding-top: 0.75rem;
    padding-bottom: 1.25rem;
  }
}
</style>
