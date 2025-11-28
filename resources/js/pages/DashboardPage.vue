<template>
  <section class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between relative">
      <!-- Background Glow for Header -->
      <div class="absolute -top-20 -left-20 w-64 h-64 bg-emerald-500/20 rounded-full blur-[80px] pointer-events-none"></div>

      <div class="relative">
        <p
          class="inline-flex items-center gap-2 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-3 py-1 text-[11px] uppercase tracking-[0.2em] text-emerald-300 shadow-[0_0_15px_rgba(16,185,129,0.2)] backdrop-blur-sm"
        >
          <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
          </span>
          Member Dashboard
        </p>
        <h1 class="mt-4 text-4xl font-bold text-white tracking-tight">
          ยินดีต้อนรับกลับ,
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-200 via-yellow-400 to-amber-600 drop-shadow-[0_0_10px_rgba(251,191,36,0.3)]">{{ user?.name || 'สมาชิก' }}</span>
        </h1>
        <p class="mt-2 text-sm text-slate-400 max-w-lg">
          เข้าถึงคอนเทนต์สุด Exclusive และอัปเดตความรู้ใหม่ๆ ได้ก่อนใคร
        </p>
      </div>

      <RouterLink
        to="/subscription"
        class="group relative inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-amber-500/10 to-yellow-500/10 px-6 py-3 text-sm font-semibold text-amber-200 transition-all duration-300 hover:from-amber-500/20 hover:to-yellow-500/20 hover:shadow-[0_0_20px_rgba(245,158,11,0.2)] border border-amber-500/30 hover:border-amber-500/50 hover:-translate-y-0.5"
      >
        <span class="relative z-10">จัดการการสมัครสมาชิก</span>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 transition-transform group-hover:translate-x-1">
          <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
        </svg>
      </RouterLink>
    </div>

    <!-- Membership status -->
    <div
      v-if="membershipStatus"
      class="relative overflow-hidden rounded-2xl border border-white/10 bg-white/5 p-1 backdrop-blur-md shadow-2xl group"
    >
      <!-- Active Status Gradient -->
      <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/20 via-transparent to-transparent opacity-50 transition-opacity duration-500 group-hover:opacity-70" v-if="membershipStatus === 'active'"></div>
      <div class="absolute inset-0 bg-gradient-to-r from-amber-500/20 via-transparent to-transparent opacity-50 transition-opacity duration-500 group-hover:opacity-70" v-else-if="membershipStatus === 'pending'"></div>
      
      <!-- Shimmer Effect -->
      <div class="absolute inset-0 -translate-x-full animate-[shimmer_2s_infinite] bg-gradient-to-r from-transparent via-white/5 to-transparent"></div>

      <div class="relative flex items-center justify-between gap-4 rounded-xl bg-slate-950/60 px-6 py-5 border border-white/5">
        <div>
          <p class="text-xs text-slate-400 mb-1 uppercase tracking-wider">สถานะสมาชิกของคุณ</p>
          <div class="flex items-center gap-3">
            <span
              v-if="membershipStatus === 'active'"
              class="flex items-center gap-2 text-emerald-400 font-semibold text-lg"
            >
              <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
              </span>
              Active Member
            </span>
            <span
              v-else-if="membershipStatus === 'pending'"
              class="flex items-center gap-2 text-amber-300 font-semibold text-lg"
            >
              <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
              </span>
              รอการอนุมัติ
            </span>
            <span v-else class="text-slate-300 font-semibold text-lg">
              ยังไม่ได้เป็นสมาชิก Exclusive
            </span>
          </div>
          <p class="text-sm text-slate-500 mt-1">
            {{ membershipStatus === 'active' ? 'คุณสามารถเข้าถึงคอนเทนต์ทั้งหมดได้ไม่จำกัด' : 'สมัครสมาชิกเพื่อปลดล็อกเนื้อหาสุดพิเศษ' }}
          </p>
        </div>
        
        <div v-if="membershipStatus !== 'active'" class="text-right">
          <RouterLink
            to="/subscription"
            class="inline-flex items-center gap-2 text-sm font-bold text-amber-400 hover:text-amber-300 transition-all group-hover:translate-x-1"
          >
            สมัครสมาชิกตอนนี้ 
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
              <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
            </svg>
          </RouterLink>
        </div>
      </div>
    </div>

    <!-- Latest contents -->
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
          <span class="w-1 h-6 bg-gradient-to-b from-amber-400 to-amber-600 rounded-full"></span>
          คอนเทนต์ใหม่ล่าสุด
        </h2>
        <RouterLink
          to="/contents"
          class="text-xs font-medium text-slate-400 hover:text-amber-300 transition-colors"
        >
          ดูทั้งหมด →
        </RouterLink>
      </div>

      <div v-if="loading" class="grid gap-4 md:grid-cols-2">
        <div v-for="i in 2" :key="i" class="h-64 rounded-2xl bg-slate-800/50 animate-pulse"></div>
      </div>

      <div
        v-else-if="contents.length === 0"
        class="text-center py-12 rounded-2xl border border-dashed border-slate-800 bg-slate-900/30"
      >
        <p class="text-slate-500">ยังไม่มีคอนเทนต์ในระบบ</p>
      </div>

      <div class="grid gap-6 md:grid-cols-2" v-else>
        <RouterLink
          v-for="item in contents"
          :key="item.id"
          :to="`/contents/${item.slug}`"
          class="group relative overflow-hidden rounded-2xl border border-white/5 bg-slate-900/40 backdrop-blur-sm transition-all duration-500 hover:-translate-y-2"
        >
          <!-- Hover Glow Effect -->
          <div class="absolute -inset-px bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-600 opacity-0 transition-opacity duration-500 group-hover:opacity-100 blur-sm"></div>
          
          <!-- Card Content Container -->
          <div class="relative h-full bg-slate-950 rounded-[15px] overflow-hidden">
            
            <!-- Thumbnail / Video preview -->
            <div class="relative aspect-video overflow-hidden">
              <img
                :src="getThumbnail(item)"
                alt=""
                class="h-full w-full object-cover transition duration-700 group-hover:scale-110"
              />

              <!-- Overlay gradient -->
              <div
                class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent opacity-80 transition-opacity duration-300 group-hover:opacity-60"
              ></div>

              <!-- Video badge + Play icon -->
              <div class="absolute left-3 top-3 flex items-center gap-2 z-10">
                <span
                  class="text-[10px] uppercase tracking-wider font-bold rounded-full bg-black/70 px-2.5 py-1 text-emerald-300 border border-emerald-500/30 backdrop-blur-md shadow-lg"
                  v-if="item.type === 'video'"
                >
                   VIDEO
                </span>
                <span
                  class="text-[10px] uppercase tracking-wider font-bold rounded-full bg-black/70 px-2.5 py-1 text-slate-200 border border-white/10 backdrop-blur-md shadow-lg"
                  v-else
                >
                  ARTICLE
                </span>
              </div>

              <!-- Play icon กลางรูป ถ้าเป็นวิดีโอ -->
              <div
                v-if="item.type === 'video'"
                class="absolute inset-0 flex items-center justify-center z-10"
              >
                <div
                  class="flex h-14 w-14 items-center justify-center rounded-full bg-white/10 backdrop-blur-md border border-white/20 shadow-[0_0_20px_rgba(0,0,0,0.3)] transition-all duration-300 group-hover:scale-110 group-hover:bg-amber-500 group-hover:border-amber-400 group-hover:shadow-[0_0_30px_rgba(245,158,11,0.5)]"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white ml-1">
                    <path fill-rule="evenodd" d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Title + teaser -->
            <div class="p-5 space-y-2">
              <h3
                class="text-lg font-bold text-white line-clamp-2 transition-colors duration-300 group-hover:text-amber-400"
              >
                {{ item.title }}
              </h3>
              <p class="text-sm text-slate-400 line-clamp-2 leading-relaxed">
                {{ item.teaser || 'เนื้อหาสำหรับสมาชิกเท่านั้น' }}
              </p>
              
              <!-- Read more link (Visual only) -->
              <div class="pt-2 flex items-center text-xs font-medium text-amber-500 opacity-0 -translate-x-2 transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-0">
                อ่านต่อ <span class="ml-1">→</span>
              </div>
            </div>
          </div>
        </RouterLink>
      </div>

    </div>
  </section>
</template>

<script setup>

import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();

const TOKEN_KEY = 'auth_token';

const user = ref(null);
const membershipStatus = ref(null);
const contents = ref([]);
const loading = ref(true);
const getThumbnail = (item) => {
  // ถ้ามี field thumbnail_url จาก backend ก็ใช้ตรงๆ
  if (item.thumbnail_url) {
    return item.thumbnail_url;
  }

  // ถ้าเป็น YouTube video และมี video_url → ดึง thumbnail ของ YouTube
  if (item.type === 'video' && item.video_url) {
    // รองรับทั้ง https://www.youtube.com/watch?v=xxxx และ https://youtu.be/xxxx
    try {
      const url = new URL(item.video_url);
      let videoId = '';

      if (url.hostname.includes('youtu.be')) {
        videoId = url.pathname.replace('/', '');
      } else {
        videoId = url.searchParams.get('v');
      }

      if (videoId) {
        return `https://i.ytimg.com/vi/${videoId}/hqdefault.jpg`;
      }
    } catch (e) {
      console.warn('Invalid video_url format:', item.video_url);
    }
  }

  // fallback เป็นภาพ default (เตรียมไฟล์รูปนี้ไว้ใน public หรือ asset ของคุณ)
  return '/images/content-placeholder.jpg';
};

const fetchDashboard = async () => {
  loading.value = true;

  const token = localStorage.getItem(TOKEN_KEY);

  // ถ้าไม่มี token เลย ให้เด้งไปหน้า login
  if (!token) {
    loading.value = false;
    router.push('/login');
    return;
  }

  const authHeaders = {
    Authorization: `Bearer ${token}`,
  };

  try {
    const [meRes, contentRes] = await Promise.all([
      // ถ้า endpoint คุณคือ /api/me ให้เปลี่ยนตรงนี้
      axios.get('/me', { headers: authHeaders }),
      axios.get('/contents', { params: { page: 1 } }),
      // ถ้า /contents เป็น API ที่ต้อง auth ด้วย ก็ใส่ { headers: authHeaders } ด้วยได้
      // axios.get('/contents', { params: { page: 1 }, headers: authHeaders }),
    ]);

    // ---- จัดการข้อมูล user จาก /me ----
    // รองรับทั้งกรณี:
    // { id, name, membership_status, ... }
    // หรือ { user: { ... } }
    const me = meRes.data?.user ?? meRes.data ?? null;
    user.value = me;

    membershipStatus.value =
      me?.membership_status ??
      me?.membershipStatus ??
      null;

    // ---- จัดการ contents จาก /contents ----
    // รองรับหลายโครง: { contents: { data: [...] } } หรือ { data: [...] }
    const rawContents =
      contentRes.data?.contents?.data ??
      contentRes.data?.data ??
      contentRes.data?.contents ??
      [];

    contents.value = Array.isArray(rawContents)
      ? rawContents.slice(0, 4)
      : [];

  } catch (e) {
    console.error('Dashboard load error:', e);
    // ถ้าเจอ 401 แสดงว่า token ใช้ไม่ได้แล้ว → เคลียร์แล้วให้กลับไป login
    if (e.response?.status === 401) {
      localStorage.removeItem(TOKEN_KEY);
      router.push('/login');
    }
  } finally {
    loading.value = false;
  }
};

onMounted(fetchDashboard);
</script>

