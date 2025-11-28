<template>
  <section class="space-y-8">
    <header class="relative">
      <div class="absolute -top-10 -left-10 w-40 h-40 bg-amber-500/10 rounded-full blur-[60px] pointer-events-none"></div>
      <h1 class="text-3xl font-bold text-white mb-2 tracking-tight">
        สำรวจคอนเทนต์ทั้งหมด
      </h1>
      <p class="text-sm text-slate-400 max-w-2xl">
        ค้นหาบทความและวิดีโอทั้งหมดจากระบบของเรา บางรายการเปิดให้อ่านฟรี
        บางรายการสงวนสิทธิ์สมาชิกเท่านั้น
      </p>
    </header>

    <!-- Filter / search -->
    <div class="space-y-4 bg-slate-900/40 p-6 rounded-2xl border border-white/5 backdrop-blur-sm">
      
      <!-- Top Row: Search & Type Toggle -->
      <div class="flex flex-col md:flex-row gap-4 justify-between">
        <!-- Search -->
        <div class="flex-1 w-full md:max-w-md relative group">
          <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-slate-500 group-focus-within:text-amber-400 transition-colors">
              <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
            </svg>
          </div>
          <input
            v-model="search"
            type="text"
            placeholder="ค้นหาโดยชื่อ, เนื้อหา หรือแท็ก..."
            class="w-full rounded-xl border border-slate-700/50 bg-slate-950/50 pl-10 pr-4 py-2.5 text-sm text-slate-100 placeholder:text-slate-500 focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/50 outline-none transition-all hover:bg-slate-950/80"
            @input="debouncedSearch"
          />
        </div>

        <!-- Type Filter Buttons -->
        <div class="flex flex-wrap gap-2 text-xs">
          <button
            @click="setTypeFilter('all')"
            :class="filterBtnClass('all')"
          >
            ทั้งหมด
          </button>
          <button
            @click="setTypeFilter('article')"
            :class="filterBtnClass('article')"
          >
            บทความ
          </button>
          <button
            @click="setTypeFilter('video')"
            :class="filterBtnClass('video')"
          >
            วิดีโอ
          </button>
        </div>
      </div>

      <!-- Bottom Row: Dropdowns (Category, Tag, Sort) -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        
        <!-- Category Filter -->
        <div class="relative">
          <select
            v-model="categoryId"
            @change="handleFilterChange"
            class="w-full appearance-none rounded-xl border border-slate-700/50 bg-slate-950/50 px-4 py-2.5 text-sm text-slate-300 focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/50 outline-none cursor-pointer hover:bg-slate-950/80"
          >
            <option value="">ทุกหมวดหมู่</option>
            <option v-for="cat in categories" :key="cat.id" :value="cat.id">
              {{ cat.name }}
            </option>
          </select>
          <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-500">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
          </div>
        </div>

        <!-- Tag Filter -->
        <div class="relative">
          <select
            v-model="tagId"
            @change="handleFilterChange"
            class="w-full appearance-none rounded-xl border border-slate-700/50 bg-slate-950/50 px-4 py-2.5 text-sm text-slate-300 focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/50 outline-none cursor-pointer hover:bg-slate-950/80"
          >
            <option value="">ทุกแท็ก</option>
            <option v-for="tag in tags" :key="tag.id" :value="tag.id">
              #{{ tag.name }}
            </option>
          </select>
          <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-500">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
          </div>
        </div>

        <!-- Sort Filter -->
        <div class="relative">
          <select
            v-model="sort"
            @change="handleFilterChange"
            class="w-full appearance-none rounded-xl border border-slate-700/50 bg-slate-950/50 px-4 py-2.5 text-sm text-slate-300 focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/50 outline-none cursor-pointer hover:bg-slate-950/80"
          >
            <option value="newest">ใหม่ล่าสุด</option>
            <option value="oldest">เก่าที่สุด</option>
          </select>
          <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-500">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
          </div>
        </div>
        
        <!-- Reset Button (Show only if filters are active) -->
        <button 
            v-if="isFiltering"
            @click="resetFilters"
            class="flex items-center justify-center gap-2 rounded-xl border border-slate-700/50 bg-slate-800/50 px-4 py-2.5 text-sm text-slate-400 hover:text-white hover:bg-slate-700 transition-colors"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
            </svg>
            ล้างตัวกรอง
        </button>

      </div>
    </div>

    <!-- Membership info: โชว์เฉพาะ visitor / pending -->
    <div
      v-if="membershipStatus === 'visitor' || membershipStatus === 'pending'"
      class="rounded-2xl border border-amber-500/20 bg-gradient-to-r from-amber-500/10 to-transparent px-6 py-4 text-sm text-amber-100 flex items-start gap-3"
    >
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-amber-400 shrink-0 mt-0.5">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
      </svg>
      <div>
        <p v-if="membershipStatus === 'visitor'">
          <span class="font-bold text-amber-400">คุณยังไม่ได้เป็นสมาชิก Exclusive</span> —
          คุณจะเห็นเพียงตัวอย่างเนื้อหา (Teaser) เท่านั้น
        </p>
        <p v-else>
          <span class="font-bold text-amber-400">รอการอนุมัติ</span> —
          ระบบได้รับคำขอสมัครสมาชิกแล้ว กำลังรอผู้ดูแลอนุมัติ
        </p>
      </div>
    </div>

    <!-- List -->
    <div v-if="loading" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
       <div v-for="i in 6" :key="i" class="h-72 rounded-2xl bg-slate-800/50 animate-pulse"></div>
    </div>

    <div v-else-if="contents.length === 0" class="text-center py-16 rounded-2xl border border-dashed border-slate-800 bg-slate-900/30">
      <p class="text-slate-500 text-lg">ไม่พบคอนเทนต์ที่ตรงกับคำค้นหา</p>
      <button @click="resetFilters" class="mt-4 text-amber-400 hover:text-amber-300 text-sm font-medium">
        ล้างตัวกรองทั้งหมด
      </button>
    </div>

    <div v-else class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
      <RouterLink
        v-for="item in contents"
        :key="item.id"
        :to="{ name: 'content.detail', params: { slug: item.slug } }"
        class="group relative overflow-hidden rounded-2xl border border-white/5 bg-slate-900/40 backdrop-blur-sm transition-all duration-500 hover:-translate-y-2"
      >
        <!-- Hover Glow Effect -->
        <div class="absolute -inset-px bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-600 opacity-0 transition-opacity duration-500 group-hover:opacity-100 blur-sm"></div>
        
        <!-- Card Content -->
        <div class="relative h-full bg-slate-950 rounded-[15px] overflow-hidden flex flex-col">
          
          <!-- Thumbnail -->
          <div class="relative aspect-video overflow-hidden">
            <img
              :src="getThumbnail(item)"
              alt=""
              loading="lazy"
              class="h-full w-full object-cover transition duration-700 group-hover:scale-110"
            />
            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent opacity-80 transition-opacity duration-300 group-hover:opacity-60"></div>
            
            <!-- Badge -->
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

            <!-- Play Icon -->
            <div
              v-if="item.type === 'video'"
              class="absolute inset-0 flex items-center justify-center z-10"
            >
              <div
                class="flex h-12 w-12 items-center justify-center rounded-full bg-white/10 backdrop-blur-md border border-white/20 shadow-lg transition-all duration-300 group-hover:scale-110 group-hover:bg-amber-500 group-hover:border-amber-400"
              >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white ml-0.5">
                  <path fill-rule="evenodd" d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Content -->
          <div class="p-5 flex flex-col flex-1">
            <h2 class="text-lg font-bold text-white line-clamp-2 mb-2 transition-colors duration-300 group-hover:text-amber-400">
              {{ item.title }}
            </h2>
            <p class="text-sm text-slate-400 line-clamp-3 leading-relaxed mb-4 flex-1">
              {{ item.teaser || 'เนื้อหาสำหรับสมาชิกเท่านั้น' }}
            </p>
            
            <div class="flex items-center justify-between mt-auto pt-4 border-t border-white/5">
              <span class="flex items-center gap-1 text-xs text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-3.5 h-3.5 opacity-70">
                  <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                  <path fill-rule="evenodd" d="M1.38 8.28a.87.87 0 0 1 0-.566 7.003 7.003 0 0 1 13.238.006.87.87 0 0 1 0 .566A7.003 7.003 0 0 1 1.379 8.28ZM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" clip-rule="evenodd" />
                </svg>
                {{ item.views || 0 }}
              </span>
              <span class="text-xs text-slate-500">
                {{ new Date(item.created_at).toLocaleDateString('th-TH') }}
              </span>
              <span class="text-xs font-medium text-amber-500 opacity-0 -translate-x-2 transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-0 hidden">
                อ่านต่อ →
              </span>
            </div>
          </div>
        </div>
      </RouterLink>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { RouterLink } from 'vue-router';
import axios from 'axios';

const loading = ref(true);
const contents = ref([]);
const membershipStatus = ref(null);

// Filters
const search = ref('');
const typeFilter = ref('all');
const categoryId = ref('');
const tagId = ref('');
const sort = ref('newest');
const page = ref(1);

// Data for dropdowns
const categories = ref([]);
const tags = ref([]);

const isFiltering = computed(() => {
    return search.value || typeFilter.value !== 'all' || categoryId.value || tagId.value || sort.value !== 'newest';
});

const filterBtnClass = (type) =>
  [
    'px-4 py-1.5 rounded-full border text-xs font-medium transition-all duration-300',
    typeFilter.value === type
      ? 'bg-amber-500 text-slate-900 border-amber-500 shadow-[0_0_15px_rgba(245,158,11,0.3)]'
      : 'border-slate-700/50 text-slate-400 hover:bg-slate-800 hover:text-slate-200',
  ].join(' ');

const setTypeFilter = (type) => {
  typeFilter.value = type;
  handleFilterChange();
};

const handleFilterChange = () => {
  page.value = 1; // ค้นหาใหม่ กลับหน้าแรก
  fetchContents();
};

// Debounce function
const debounce = (fn, delay) => {
  let timeout;
  return (...args) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => fn(...args), delay);
  };
};

const debouncedSearch = debounce(() => {
  handleFilterChange();
}, 500);

const resetFilters = () => {
  search.value = '';
  typeFilter.value = 'all';
  categoryId.value = '';
  tagId.value = '';
  sort.value = 'newest';
  page.value = 1;
  fetchContents();
};

const getThumbnail = (item) => {
  if (item.thumbnail_url) {
    return item.thumbnail_url;
  }
  if (item.type === 'video' && item.video_url) {
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
  return '/images/content-placeholder.jpg';
};

const fetchFilters = async () => {
    try {
        const [catRes, tagRes] = await Promise.all([
            axios.get('/categories'),
            axios.get('/tags')
        ]);
        categories.value = catRes.data;
        tags.value = tagRes.data;
    } catch (e) {
        console.error('Error fetching filters:', e);
    }
};

const fetchContents = async () => {
  loading.value = true;
  try {
    const { data } = await axios.get('/contents', {
      params: {
        search: search.value || undefined,
        type: typeFilter.value,
        category_id: categoryId.value || undefined,
        tag_id: tagId.value || undefined,
        sort: sort.value,
        page: page.value,
        per_page: 9,
      },
    });

    console.log('contents api response', data);

    membershipStatus.value = data.membership_status ?? 'visitor';
    contents.value = data.contents?.data || [];

  } catch (e) {
    console.error('fetchContents error', e);
    contents.value = [];
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
    fetchFilters();
    fetchContents();
});
</script>
