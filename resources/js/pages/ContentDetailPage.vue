<template> 
  <AppLayout>
    <section class="min-h-[calc(100vh-80px)] bg-slate-950 py-8">
      <div class="max-w-4xl mx-auto px-4 text-slate-100">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-slate-400 mb-6">
          <button
            @click="$router.back()"
            class="px-3 py-1 rounded-full border border-slate-700 hover:bg-slate-800 transition"
          >
            ← กลับ
          </button>
          <span>/</span>
          <span class="truncate max-w-[200px] md:max-w-xs">
            {{ slug }}
          </span>
        </div>

        <!-- Loading / Error -->
        <div v-if="loading" class="text-sm text-slate-400">
          กำลังโหลดคอนเทนต์...
        </div>

        <div
          v-else-if="error"
          class="rounded-2xl bg-red-500/10 border border-red-500/50 px-4 py-3 text-sm text-red-200"
        >
          ไม่สามารถโหลดคอนเทนต์ได้: {{ error }}
        </div>

        <div v-else-if="!content" class="text-sm text-slate-400">
          ไม่พบคอนเทนต์ที่คุณต้องการ
        </div>

        <!-- MAIN CONTENT -->
        <div
          v-else
          class="relative rounded-2xl bg-slate-900/80 border border-slate-800 shadow-xl p-6"
        >
          <!-- 🔒 Overlay ถ้ายังดูเต็มไม่ได้ -->
          <div
            v-if="!canViewFull"
            class="absolute inset-0 z-10 flex flex-col items-center justify-center 
                   rounded-2xl bg-slate-950/75 backdrop-blur-sm border border-amber-500/40
                   text-center px-6"
          >
            <p class="text-sm text-amber-100 mb-2">
              เนื้อหาเต็มสงวนสิทธิ์สำหรับสมาชิก Exclusive เท่านั้น
            </p>

            <p
              class="text-xs text-slate-300 mb-4"
              v-if="membershipStatus === 'pending'"
            >
              ระบบได้รับคำขอสมัครสมาชิกของคุณแล้ว
              กรุณารอผู้ดูแลอนุมัติสถานะเป็น Active
            </p>

            <p
              class="text-xs text-slate-300 mb-4"
              v-else
            >
              ตอนนี้คุณจะเห็นได้เพียงตัวอย่างบางส่วนของเนื้อหานี้
              หากต้องการปลดล็อกทั้งหมด กรุณาเข้าสู่ระบบและสมัครสมาชิก
            </p>

            <div class="flex flex-wrap gap-2 justify-center">
              <RouterLink
                to="/subscription"
                class="inline-flex items-center rounded-full bg-amber-500 px-4 py-1.5
                       text-xs font-semibold text-slate-950 hover:bg-amber-400 transition"
              >
                สมัครสมาชิกตอนนี้
              </RouterLink>


            </div>
          </div>

          <!-- Title -->
          <h1 class="text-2xl md:text-3xl font-semibold leading-snug mb-4">
            {{ content.title }}
          </h1>

          <!-- Thumbnail (Cover Image) Removed to prevent duplication with Body content -->
          <!-- <div v-if="content.thumbnail_url" class="mb-6 rounded-xl overflow-hidden border border-slate-800">
            <img 
              :src="content.thumbnail_url" 
              :alt="content.title"
              class="w-full h-auto object-cover max-h-[500px]"
            />
          </div> -->

          <!-- Meta -->
          <div class="flex flex-wrap items-center gap-2 text-xs text-slate-400 mb-4">
            <span
              class="inline-flex items-center gap-1 rounded-full border border-slate-700 px-2 py-0.5"
            >
              <span
                class="h-1.5 w-1.5 rounded-full"
                :class="isVideo ? 'bg-emerald-400' : 'bg-sky-400'"
              ></span>
              {{ isVideo ? 'วิดีโอ' : 'บทความ' }}
            </span>

            <span v-if="content.category" class="inline-flex items-center gap-1">
              ·
              <span class="text-slate-500">หมวดหมู่:</span>
              <span class="text-slate-200">{{ content.category }}</span>
            </span>

            <span v-if="content.created_at" class="inline-flex items-center gap-1">
              ·
              <span class="text-slate-500">เผยแพร่เมื่อ</span>
              <span class="text-slate-300">
                {{ formatDate(content.created_at) }}
              </span>
            </span>

            <span class="inline-flex items-center gap-1">
              ·
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-3.5 h-3.5 opacity-70">
                <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                <path fill-rule="evenodd" d="M1.38 8.28a.87.87 0 0 1 0-.566 7.003 7.003 0 0 1 13.238.006.87.87 0 0 1 0 .566A7.003 7.003 0 0 1 1.379 8.28ZM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" clip-rule="evenodd" />
              </svg>
              <span class="text-slate-300">{{ content.views || 0 }} ครั้ง</span>
            </span>
          </div>

          <!-- Tags -->
          <div
            v-if="content.tags && content.tags.length"
            class="mb-5 flex flex-wrap gap-2"
          >
            <span
              v-for="tag in content.tags"
              :key="tag"
              class="text-[11px] rounded-full bg-slate-800 px-2 py-0.5 text-slate-200"
            >
              #{{ tag }}
            </span>
          </div>

          <!-- Membership Message / Alert (ยังเก็บไว้ได้ ถ้าอยากให้มีข้อความข้างใต้ด้วย) -->
          <div
            v-if="!canViewFull"
            class="mb-5 rounded-2xl border border-amber-500/40 bg-amber-500/10 px-4 py-3 text-xs text-amber-100"
          >
            <p v-if="membershipStatus === 'visitor'">
              เนื้อหาเต็มสงวนสิทธิ์สำหรับสมาชิก Exclusive เท่านั้น
              คุณจะเห็นเพียง <span class="font-semibold">Teaser / ตัวอย่าง</span> ของคอนเทนต์นี้
              หากต้องการปลดล็อกเนื้อหาเต็ม กรุณาสมัครสมาชิก
            </p>
            <p v-else-if="membershipStatus === 'pending'">
              ระบบได้รับคำขอสมัครสมาชิกของคุณแล้ว กำลังรอผู้ดูแลอนุมัติ
              เมื่อสถานะเป็น <span class="font-semibold">Active</span> แล้ว
              คุณจะสามารถเข้าถึงเนื้อหาเต็มได้อัตโนมัติ
            </p>
            <p v-else>
              คุณยังไม่มีสิทธิ์เข้าถึงเนื้อหาเต็มของคอนเทนต์นี้
            </p>
          </div>

          <!-- VIDEO (ถ้ามี) -->
          <!-- VIDEO (ถ้ามี) -->
          <div
            v-if="canViewFull && content.video_url"
            class="mb-6 rounded-xl overflow-hidden border border-slate-800"
          >
            <div class="aspect-video bg-black relative">
              <!-- Case 1: YouTube -->
              <iframe
                v-if="youtubeId"
                class="w-full h-full"
                :src="`https://www.youtube.com/embed/${youtubeId}`"
                title="YouTube video"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen
              ></iframe>

              <!-- Case 2: Direct Video File -->
              <video
                v-else
                controls
                class="w-full h-full"
                controlsList="nodownload"
              >
                <source :src="content.video_url" />
                Your browser does not support the video tag.
              </video>
            </div>
          </div>


          <!-- BODY / TEASER -->
          <div class="prose prose-invert max-w-none text-sm leading-relaxed">
            <div
              v-if="canViewFull && content.body"
              v-html="content.body"
            ></div>

            <div v-else>
              <p class="mb-3">
                {{ content.teaser || 'เนื้อหานี้สำหรับสมาชิกเท่านั้น' }}
              </p>

              <p class="mt-4 text-xs text-slate-500">
                เนื้อหาส่วนที่เหลือสามารถเข้าถึงได้เมื่อคุณเป็นสมาชิก Exclusive เท่านั้น
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>
<style scoped>
/* -----------------------------------------------------
   BASE MOBILE-FIRST STYLING (Mobile = Default)
----------------------------------------------------- */

.hero-section {
  display: grid;
  gap: 2.5rem;
  max-width: 640px;
  margin: 0 auto;
  padding: 2.5rem 1rem;
  /* ช่วยให้ดูเต็มจอมากขึ้น */
  min-height: 100vh;
  align-items: center;
}

.hero-text {
  text-align: center;
}

.hero-label {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.25rem 0.75rem;
  font-size: 11px;
  border-radius: 9999px;
  background: rgba(245, 158, 11, 0.1);
  color: #fbbf24;
  border: 1px solid rgba(245, 158, 11, 0.3);
}

.hero-title {
  margin-top: 1rem;
  font-size: 1.75rem;
  font-weight: 600;
  color: #f1f5f9;
}

.hero-subtitle {
  display: block;
  margin-top: 0.25rem;
  color: #fbbf24;
}

.hero-description {
  margin-top: 0.75rem;
  font-size: 14px;
  color: #94a3b8;
}

.cta-group {
  margin-top: 1rem;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.cta-primary,
.cta-secondary {
  width: 100%;
  padding: 0.75rem 1.25rem;
  font-size: 14px;
  border-radius: 9999px;
  font-weight: 600;
  text-align: center;
  transition: 0.2s;
}

.cta-primary {
  background: #fbbf24;
  color: #0f172a;
}

.cta-secondary {
  color: #e2e8f0;
  border: 1px solid #334155;
}

.hero-points {
  margin-top: 1rem;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  font-size: 12px;
  color: #94a3b8;
}

.point {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  justify-content: center;
}

.dot {
  width: 6px;
  height: 6px;
  border-radius: 9999px;
}

.dot-green {
  background: #10b981;
}

.dot-amber {
  background: #fbbf24;
}

/* Preview section */
.preview-wrapper {
  width: 100%;
}

.preview-box {
  background: rgba(15, 23, 42, 0.7);
  border: 1px solid #334155;
  padding: 1.25rem;
  border-radius: 1rem;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.25);
}

.preview-heading {
  font-size: 11px;
  text-transform: uppercase;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #64748b;
  letter-spacing: 0.15em;
}

.preview-list {
  margin-top: 1rem;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.preview-card {
  background: #0f172a;
  border: 1px solid #334155;
  padding: 0.75rem 1rem;
  border-radius: 0.75rem;
}

.preview-title {
  font-size: 14px;
  color: #f1f5f9;
  font-weight: 600;
}

.preview-type {
  font-size: 10px;
  background: #1e293b;
  padding: 2px 6px;
  border-radius: 9999px;
  color: #cbd5e1;
}

.preview-teaser {
  font-size: 12px;
  margin-top: 0.25rem;
  color: #94a3b8;
}

.preview-lock {
  font-size: 11px;
  margin-top: 0.5rem;
  color: #fbbf24;
}

/* -----------------------------------------------------
   💡 มือถือแนวนอน (กว้างแต่เตี้ย) → บังคับใช้ layout มือถือ
----------------------------------------------------- */
@media (orientation: landscape) and (max-width: 1023px) {
  .hero-section {
    grid-template-columns: 1fr;
    max-width: 800px;
    padding: 1.5rem 1rem;
    gap: 1.5rem;
  }

  .hero-title {
    font-size: 1.4rem;
  }

  .hero-description {
    font-size: 13px;
  }

  .preview-box {
    padding: 1rem;
  }
}

/* -----------------------------------------------------
   DESKTOP VERSION (>= 1024px) 
   ⬅️ เปลี่ยนจาก 768px → 1024px
----------------------------------------------------- */
@media (min-width: 1024px) {
  .hero-section {
    max-width: 1280px;
    grid-template-columns: 1.35fr 1fr;
    padding: 4rem 1rem;
  }

  .hero-text {
    text-align: left;
  }

  .cta-group {
    flex-direction: row;
    justify-content: flex-start;
  }

  .cta-primary,
  .cta-secondary {
    width: auto;
  }

  .hero-points {
    flex-direction: row;
    justify-content: flex-start;
  }
}
</style>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();

const slug = route.params.slug;

const loading = ref(true);
const error = ref(null);
const membershipStatus = ref(null);
const canViewFull = ref(false);
const content = ref(null);

// วิดีโอ? (กันกรณี type เป็น Video / VIDEO ฯลฯ)
const isVideo = computed(() => {
  return (content.value?.type || '').toString().toLowerCase() === 'video';
});

// ดึง YouTube ID จากหลายรูปแบบลิงก์
const youtubeId = computed(() => {
  const raw = content.value?.video_url;
  if (!raw) return null;

  const url = raw.trim();

  // watch?v=xxxx
  const matchWatch = url.match(/v=([^&]+)/);
  if (matchWatch) return matchWatch[1];

  // youtu.be/xxxx
  const matchShort = url.match(/youtu\.be\/([^?]+)/);
  if (matchShort) return matchShort[1];

  // /embed/xxxx
  const matchEmbed = url.match(/embed\/([^?]+)/);
  if (matchEmbed) return matchEmbed[1];

  // /shorts/xxxx
  const matchShorts = url.match(/shorts\/([^?]+)/);
  if (matchShorts) return matchShorts[1];

  // ถ้าใส่มาเป็น id ล้วน ๆ เช่น "dQw4w9WgXcQ"
  if (/^[a-zA-Z0-9_-]{6,}$/.test(url)) {
    return url;
  }

  return null;
});

const formatDate = (isoString) => {
  if (!isoString) return '';
  const d = new Date(isoString);
  return d.toLocaleDateString('th-TH', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
};

// key ของ token ให้ตรงกับที่ใช้ใน login / social login
const TOKEN_KEY = 'auth_token';

const fetchContentDetail = async () => {
  loading.value = true;
  error.value = null;

  try {
    const token = localStorage.getItem(TOKEN_KEY);
    const headers = {};

    // ถ้ามี token ให้แนบไปด้วย (จะได้รู้ว่า user คนไหน / membership_status อะไร)
    if (token) {
      headers.Authorization = `Bearer ${token}`;
    }

    const { data } = await axios.get(`/contents/${slug}`, {
      headers,
    });

    membershipStatus.value = data.membership_status ?? 'visitor'; // visitor / pending / active
    canViewFull.value = !!data.can_view_full;
    content.value = data.content;
  } catch (err) {
    console.error(err);
    error.value =
      err.response?.data?.message || err.message || 'เกิดข้อผิดพลาด';
  } finally {
    loading.value = false;
  }
};

onMounted(fetchContentDetail);
</script>
