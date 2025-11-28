<template>
  <section class="relative space-y-8">
    <!-- Background Effects -->
    <div class="absolute inset-0 pointer-events-none -z-10">
      <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-amber-500/10 blur-[120px]"></div>
      <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-emerald-500/10 blur-[120px]"></div>
      <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-overlay"></div>
    </div>

    <!-- Header -->
    <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between relative z-10">
      <div>
        <div class="inline-flex items-center gap-2 rounded-full border border-amber-500/30 bg-amber-500/10 px-3 py-1 mb-4 backdrop-blur-sm">
          <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
          </span>
          <span class="text-[11px] uppercase tracking-[0.2em] text-amber-300 font-bold">Premium Access</span>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-white via-slate-200 to-slate-400 drop-shadow-sm">
          เลือกแพ็กเกจสมาชิก Exclusive
        </h1>
        <p class="mt-2 text-base text-slate-400 max-w-xl">
          ปลดล็อกศักยภาพของคุณด้วยคอนเทนต์ระดับพรีเมียม บทความเชิงลึก และวิดีโอคุณภาพสูงที่คัดสรรมาเพื่อคุณโดยเฉพาะ
        </p>
      </div>

      <RouterLink
        to="/dashboard"
        class="group inline-flex items-center justify-center gap-2 rounded-full border border-slate-700/50 bg-slate-900/50 px-5 py-2.5 text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800 hover:border-slate-600 transition-all duration-300 backdrop-blur-md"
      >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 transition-transform group-hover:-translate-x-1">
          <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
        </svg>
        กลับสู่ Dashboard
      </RouterLink>
    </div>

    <!-- Membership status -->
    <div
      class="relative overflow-hidden rounded-2xl border border-white/5 bg-slate-900/40 backdrop-blur-xl p-6 md:p-8 transition-all duration-500 hover:border-white/10 group"
    >
      <div class="absolute inset-0 bg-gradient-to-r from-slate-800/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
      
      <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
          <div class="p-3 rounded-xl bg-slate-950/50 border border-white/10 shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-slate-400">
              <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
            </svg>
          </div>
          <div>
            <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">สถานะสมาชิกปัจจุบัน</p>
            <div class="text-lg font-medium">
              <span v-if="status === 'active'" class="inline-flex items-center gap-2 text-emerald-400 drop-shadow-[0_0_10px_rgba(52,211,153,0.3)]">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
                Active Member — คุณเป็นสมาชิกอยู่แล้ว
              </span>

              <span v-else-if="status === 'pending'" class="inline-flex items-center gap-2 text-amber-300 drop-shadow-[0_0_10px_rgba(252,211,77,0.3)]">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 animate-pulse">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                </svg>
                รอการอนุมัติจากผู้ดูแลระบบ
              </span>

              <span v-else class="inline-flex items-center gap-2 text-slate-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-slate-500">
                  <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                </svg>
                ยังไม่ได้เป็นสมาชิก Exclusive
              </span>
            </div>
          </div>
        </div>

        <div v-if="status !== 'active'" class="text-right text-sm text-slate-400 max-w-xs">
          สมัครสมาชิกวันนี้เพื่อเข้าถึงคลังความรู้ระดับพรีเมียมที่หาไม่ได้จากที่อื่น
        </div>
      </div>
    </div>

    <!-- Packages -->
    <div class="space-y-6">
      <div class="flex items-center justify-between border-b border-white/5 pb-4">
        <h2 class="text-xl font-semibold text-white flex items-center gap-2">
          <span class="w-1 h-6 bg-amber-500 rounded-full"></span>
          แพ็กเกจสมาชิกทั้งหมด
        </h2>
        <p class="text-sm text-slate-400 hidden sm:block">
          เลือกแพ็กเกจที่เหมาะกับสไตล์การเรียนรู้ของคุณ
        </p>
      </div>

      <div class="grid gap-6 md:grid-cols-3 lg:grid-cols-4">
        <div
          v-for="plan in plans"
          :key="plan.id"
          :class="[
            'group relative flex flex-col rounded-3xl p-6 transition-all duration-500',
            plan.highlight
              ? 'bg-gradient-to-b from-slate-900/90 to-slate-950/90 border border-amber-500/50 shadow-[0_0_30px_rgba(245,158,11,0.15)] hover:shadow-[0_0_50px_rgba(245,158,11,0.25)] hover:border-amber-400 hover:-translate-y-1'
              : 'bg-slate-900/40 border border-white/5 hover:bg-slate-900/60 hover:border-white/10 hover:shadow-xl hover:-translate-y-1'
          ]"
        >
          <!-- Highlight Glow -->
          <div v-if="plan.highlight" class="absolute inset-0 rounded-3xl bg-gradient-to-b from-amber-500/5 to-transparent pointer-events-none"></div>

          <!-- Badge -->
          <div class="flex items-center justify-between mb-4 relative z-10">
            <p class="text-sm font-bold tracking-wide" :class="plan.highlight ? 'text-amber-200' : 'text-slate-300'">
              {{ plan.label }}
            </p>
            <span
              v-if="plan.highlight"
              class="rounded-full bg-gradient-to-r from-amber-500 to-yellow-500 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-900 shadow-lg shadow-amber-500/20"
            >
              แนะนำ
            </span>
          </div>

          <!-- Price -->
          <div class="mb-6 relative z-10">
            <div class="flex items-baseline gap-1">
              <span class="text-3xl font-bold" :class="plan.highlight ? 'text-white' : 'text-slate-200'">฿{{ plan.price }}</span>
              <span class="text-sm text-slate-500">/ {{ plan.period }}</span>
            </div>
            <p class="mt-2 text-xs text-slate-400 leading-relaxed min-h-[2.5em]">
              {{ plan.subtitle }}
            </p>
          </div>

          <!-- Divider -->
          <div class="h-px w-full bg-gradient-to-r from-transparent via-white/10 to-transparent mb-6"></div>

          <!-- Features -->
          <ul class="space-y-3 text-sm text-slate-300 flex-1 relative z-10 mb-8">
            <li
              v-for="feature in plan.features"
              :key="feature"
              class="flex items-start gap-3"
            >
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
              </svg>
              <span class="text-slate-400 group-hover:text-slate-200 transition-colors">{{ feature }}</span>
            </li>
          </ul>

          <!-- CTA -->
          <div class="relative z-10 mt-auto">
            <RouterLink
              v-if="status === 'active'"
              to="/dashboard"
              class="flex items-center justify-center w-full py-3 rounded-xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 text-xs font-semibold transition-all hover:bg-emerald-500/20"
            >
              คุณเป็นสมาชิกอยู่แล้ว
            </RouterLink>

            <button
              v-else
              @click="selectPlan(plan)"
              class="relative w-full overflow-hidden rounded-xl py-3 text-sm font-bold transition-all duration-300 shadow-lg group/btn"
              :class="plan.highlight
                ? 'bg-gradient-to-r from-amber-500 to-yellow-500 text-slate-900 hover:shadow-amber-500/40 hover:scale-[1.02]'
                : 'bg-slate-800 text-slate-200 hover:bg-slate-700 hover:text-white border border-white/5 hover:border-white/20'"
            >
              <span class="relative z-10 flex items-center justify-center gap-2">
                เลือกแพ็กเกจ {{ plan.label }}
                <svg v-if="plan.highlight" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 transition-transform group-hover/btn:translate-x-1">
                  <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                </svg>
              </span>
              <!-- Shine Effect for Highlight Button -->
              <div v-if="plan.highlight" class="absolute inset-0 -translate-x-full group-hover/btn:animate-[shimmer_1s_infinite] bg-gradient-to-r from-transparent via-white/30 to-transparent z-0"></div>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();
const TOKEN_KEY = "auth_token";

const status = ref(null);
const loading = ref(true);

// หลายๆ แพ็กเกจ
const plans = [
  {
    id: "basic-monthly",
    label: "Basic รายเดือน",
    price: 99,
    period: "เดือน",
    subtitle: "เหมาะสำหรับทดลองใช้ หรือเน้นอ่านเป็นช่วงๆ",
    highlight: false,
    features: [
      "เข้าถึงคอนเทนต์บทความทั้งหมด",
      "ดูวิดีโอแบบ Full HD",
      "อัปเดตคอนเทนต์ใหม่ทุกสัปดาห์",
    ],
  },
  {
    id: "plus-quarter",
    label: "Plus 3 เดือน",
    price: 259,
    period: "3 เดือน",
    subtitle: "คุ้มกว่ารายเดือน เหมาะกับคนติดตามต่อเนื่อง",
    highlight: true,
    features: [
      "ทุกสิทธิ์ของ Basic",
      "ส่วนลดเฉลี่ยต่อเดือนถูกลง",
      "สิทธิ์เข้าร่วมไลฟ์/เวิร์กช็อปพิเศษ (ถ้ามี)",
    ],
  },
  {
    id: "pro-yearly",
    label: "Pro รายปี",
    price: 899,
    period: "ปี",
    subtitle: "สายจริงจัง อยากติดตามยาวๆ ทั้งปี",
    highlight: false,
    features: [
      "ทุกสิทธิ์ของ Plus",
      "ล็อกเรทราคาตลอดทั้งปี",
      "สิทธิ์เข้าถึงคอนเทนต์พิเศษสำหรับ Pro",
    ],
  },
  {
    id: "supporter",
    label: "Supporter",
    price: 149,
    period: "เดือน",
    subtitle: "สนับสนุนครีเอเตอร์ พร้อมสิทธิ์พิเศษเล็กน้อย",
    highlight: false,
    features: [
      "แสดง Badge Supporter ในโปรไฟล์ (อนาคต)",
      "สิทธิ์โหวตหัวข้อคอนเทนต์ถัดไป",
      "เข้าถึงคอนเทนต์บางส่วนก่อนใคร",
    ],
  },
];

onMounted(async () => {
  const token = localStorage.getItem(TOKEN_KEY);
  if (!token) {
    loading.value = false;
    return;
  }

  try {
    const res = await axios.get("/me", {
      headers: { Authorization: `Bearer ${token}` },
    });

    const me = res.data?.user ?? res.data;
    status.value = me?.membership_status ?? null;
  } finally {
    loading.value = false;
  }
});

// ★ ฟังก์ชันกดเลือกแพ็กเกจ → ตั้ง pending ทันที
const selectPlan = async (plan) => {
  const token = localStorage.getItem(TOKEN_KEY);

  if (!token) {
    router.push("/login");
    return;
  }

  try {
    const res = await axios.post(
      "/subscription/start",
      { plan_id: plan.id },
      { headers: { Authorization: `Bearer ${token}` } }
    );

    alert("ส่งคำขอสำเร็จ! รอแอดมินอนุมัติ");
    router.push("/dashboard");

  } catch (err) {
    console.error(err);
    alert("เกิดข้อผิดพลาด กรุณาลองใหม่");
  }
};
</script>
