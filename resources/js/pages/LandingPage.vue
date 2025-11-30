<template>
  <section class="hero-section">

    <!-- LEFT / HERO TEXT -->
    <div class="hero-text">
      <p class="hero-label">
        ✨ คอนเทนต์พิเศษสำหรับสมาชิกเท่านั้น
      </p>

      <h1 class="hero-title">
        บทความลับ และคลิปวิดีโอเชิงลึก
        <span class="hero-subtitle">
          เปิดให้เข้าถึงเฉพาะสมาชิก Exclusive
        </span>
      </h1>

      <p class="hero-description">
        รวมคอนเทนต์เชิงลึกที่ไม่เผยแพร่สาธารณะ ทั้งบทวิเคราะห์เคสจริง,
        how-to แบบละเอียด และคลิปวิดีโอสอนทีละขั้น
        เพื่อคนที่อยากอัปสกิลแบบจริงจัง
      </p>

      <!-- CTA BUTTONS -->
      <div class="cta-group">
        <RouterLink
          to="/subscription"
          class="cta-primary"
        >
          แพ็คเกจสมาชิก
        </RouterLink>

        <RouterLink
          to="/contents"
          class="cta-secondary"
        >
          ดูคอนเทนต์ตัวอย่าง
        </RouterLink>
      </div>

      <!-- POINTS -->
      <div class="hero-points">
        <div class="point">
          <span class="dot dot-green"></span>
          อัปเดตคอนเทนต์ใหม่ทุกสัปดาห์
        </div>

        <div class="point">
          <span class="dot dot-amber"></span>
          เนื้อหาเน้นเคสจริง ใช้ได้ทันที
        </div>
      </div>
    </div>

    <!-- RIGHT / PREVIEW CARDS -->
    <div class="preview-wrapper">
      <div class="preview-box">

        <p class="preview-heading">
          <span class="dot dot-green"></span>
          ตัวอย่างคอนเทนต์ในแพลตฟอร์ม
        </p>

        <div v-if="loading" class="loading-text">กำลังโหลดคอนเทนต์ตัวอย่าง...</div>

        <div v-else-if="previewContents.length === 0" class="empty-text">
          ยังไม่มีคอนเทนต์ ลองให้ Admin เพิ่มจากระบบหลังบ้าน
        </div>

        <div v-else class="preview-list">
          <article
            v-for="item in previewContents"
            :key="item.id"
            class="preview-card"
          >
            <div class="preview-head">
              <h3 class="preview-title">{{ item.title }}</h3>
              <span class="preview-type">
                {{ item.type === 'video' ? 'Video' : 'Article' }}
              </span>
            </div>

            <p class="preview-teaser">
              {{ item.teaser || 'เนื้อหาสำหรับสมาชิกเท่านั้น' }}
            </p>

            <p class="preview-lock">
              เฉพาะสมาชิก Exclusive เท่านั้น
            </p>
          </article>
        </div>

      </div>
    </div>

  </section>
</template>

<style scoped>
/* -----------------------------------------------------
   ANIMATIONS
----------------------------------------------------- */
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes float {
  0% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
  100% { transform: translateY(0px); }
}

@keyframes pulse-glow {
  0% { transform: scale(1); opacity: 0.5; }
  100% { transform: scale(1.1); opacity: 0.8; }
}

@keyframes shimmer {
  0% { transform: translateX(-100%); }
  100% { transform: translateX(100%); }
}

/* -----------------------------------------------------
   BASE MOBILE-FIRST STYLING
----------------------------------------------------- */

.hero-section {
  display: grid;
  gap: 3rem;
  max-width: 640px;
  margin: 0 auto;
  padding: 4rem 1.5rem;
  position: relative;
  z-index: 10;
  overflow: hidden;
}

/* Background Animation */
.hero-section::before {
  content: '';
  position: absolute;
  top: -20%;
  left: -20%;
  width: 140%;
  height: 140%;
  background: radial-gradient(circle at 50% 50%, rgba(16, 185, 129, 0.1), transparent 60%),
              radial-gradient(circle at 80% 20%, rgba(245, 158, 11, 0.1), transparent 50%);
  filter: blur(100px);
  z-index: -1;
  animation: pulse-glow 8s infinite alternate ease-in-out;
}

.hero-text {
  text-align: center;
  position: relative;
}

/* Staggered Entrance Animations */
.hero-label { animation: fadeInUp 0.8s ease-out backwards; animation-delay: 0.1s; }
.hero-title { animation: fadeInUp 0.8s ease-out backwards; animation-delay: 0.2s; }
.hero-description { animation: fadeInUp 0.8s ease-out backwards; animation-delay: 0.3s; }
.cta-group { animation: fadeInUp 0.8s ease-out backwards; animation-delay: 0.4s; }
.hero-points { animation: fadeInUp 0.8s ease-out backwards; animation-delay: 0.5s; }

.hero-label {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.35rem 1rem;
  font-size: 12px;
  border-radius: 9999px;
  background: rgba(245, 158, 11, 0.05);
  color: #fbbf24;
  border: 1px solid rgba(245, 158, 11, 0.2);
  backdrop-filter: blur(4px);
  box-shadow: 0 0 15px rgba(245, 158, 11, 0.05);
  text-transform: uppercase;
  letter-spacing: 0.05em;
  font-weight: 600;
}

.hero-title {
  margin-top: 1.5rem;
  font-size: 2.5rem;
  font-weight: 800;
  color: #f1f5f9;
  line-height: 1.1;
  letter-spacing: -0.02em;
}

.hero-subtitle {
  display: block;
  margin-top: 0.5rem;
  background: linear-gradient(135deg, #fde68a 0%, #fbbf24 50%, #d97706 100%);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  filter: drop-shadow(0 0 20px rgba(245, 158, 11, 0.2));
}

.hero-description {
  margin-top: 1.5rem;
  font-size: 16px;
  color: #94a3b8;
  line-height: 1.7;
  max-width: 480px;
  margin-left: auto;
  margin-right: auto;
}

.cta-group {
  margin-top: 2.5rem;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.cta-primary {
  position: relative;
  width: 100%;
  padding: 1rem 1.5rem;
  font-size: 16px;
  border-radius: 1rem;
  font-weight: 700;
  text-align: center;
  background: linear-gradient(135deg, #fbbf24, #d97706);
  color: #0f172a;
  box-shadow: 0 4px 20px rgba(245, 158, 11, 0.3), inset 0 1px 0 rgba(255,255,255,0.3);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border: 1px solid rgba(255, 255, 255, 0.1);
  overflow: hidden;
}

.cta-primary::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
  transition: 0.5s;
}

.cta-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(245, 158, 11, 0.5), inset 0 1px 0 rgba(255,255,255,0.4);
}

.cta-primary:hover::before {
  left: 100%;
}

.cta-secondary {
  width: 100%;
  padding: 1rem 1.5rem;
  font-size: 16px;
  border-radius: 1rem;
  font-weight: 600;
  text-align: center;
  color: #e2e8f0;
  border: 1px solid rgba(255, 255, 255, 0.1);
  background: rgba(255, 255, 255, 0.03);
  backdrop-filter: blur(10px);
  transition: all 0.3s ease;
}

.cta-secondary:hover {
  background: rgba(255, 255, 255, 0.08);
  border-color: rgba(255, 255, 255, 0.2);
  color: #fff;
  transform: translateY(-2px);
}

.hero-points {
  margin-top: 2.5rem;
  display: flex;
  flex-direction: column;
  gap: 1rem;
  font-size: 14px;
  color: #cbd5e1;
}

.point {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  justify-content: center;
  background: rgba(255, 255, 255, 0.03);
  padding: 0.5rem 1rem;
  border-radius: 9999px;
  border: 1px solid rgba(255, 255, 255, 0.05);
}

.dot {
  width: 8px;
  height: 8px;
  border-radius: 9999px;
  box-shadow: 0 0 10px currentColor;
}

.dot-green { background: #10b981; color: rgba(16, 185, 129, 0.6); }
.dot-amber { background: #fbbf24; color: rgba(251, 191, 36, 0.6); }

/* Preview section */
.preview-wrapper {
  width: 100%;
  position: relative;
  animation: fadeInUp 1s ease-out backwards;
  animation-delay: 0.6s;
}

.preview-box {
  background: rgba(15, 23, 42, 0.4);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.08);
  padding: 2rem;
  border-radius: 1.5rem;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
  position: relative;
  overflow: hidden;
  animation: float 6s ease-in-out infinite;
}

/* Glowing border effect */
.preview-box::before {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: 1.5rem;
  padding: 1px;
  background: linear-gradient(to bottom right, rgba(255,255,255,0.15), transparent 60%);
  -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
  mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
  -webkit-mask-composite: xor;
  mask-composite: exclude;
  pointer-events: none;
}

.preview-heading {
  font-size: 11px;
  text-transform: uppercase;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  color: #94a3b8;
  letter-spacing: 0.2em;
  font-weight: 700;
  margin-bottom: 1.5rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid rgba(255,255,255,0.05);
}

.preview-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.preview-card {
  background: rgba(30, 41, 59, 0.3);
  border: 1px solid rgba(255, 255, 255, 0.03);
  padding: 1.25rem;
  border-radius: 1rem;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
}

.preview-card:hover {
  transform: translateY(-4px) scale(1.02);
  background: rgba(30, 41, 59, 0.6);
  border-color: rgba(245, 158, 11, 0.2);
  box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
}

.preview-title {
  font-size: 16px;
  color: #f1f5f9;
  font-weight: 600;
  line-height: 1.4;
  margin-bottom: 0.25rem;
}

.preview-type {
  font-size: 9px;
  background: rgba(255, 255, 255, 0.05);
  padding: 4px 8px;
  border-radius: 9999px;
  color: #cbd5e1;
  border: 1px solid rgba(255,255,255,0.05);
  text-transform: uppercase;
  letter-spacing: 0.05em;
  font-weight: 700;
}

.preview-head {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 1rem;
}

.preview-teaser {
  font-size: 13px;
  margin-top: 0.5rem;
  color: #94a3b8;
  line-height: 1.6;
}

.preview-lock {
  font-size: 11px;
  margin-top: 0.75rem;
  color: #fbbf24;
  display: flex;
  align-items: center;
  gap: 0.35rem;
  font-weight: 500;
  opacity: 0.8;
}

/* -----------------------------------------------------
   DESKTOP VERSION (>= 1024px)
----------------------------------------------------- */
@media (min-width: 1024px) {
  .hero-section {
    max-width: 1280px;
    grid-template-columns: 1.1fr 0.9fr;
    padding: 8rem 2rem;
    align-items: center;
    gap: 6rem;
    overflow: visible; /* Allow glow to spread */
  }

  .hero-text {
    text-align: left;
  }
  
  .hero-title {
    font-size: 4.5rem;
    line-height: 1.05;
  }
  
  .hero-description {
    margin-left: 0;
    margin-right: 0;
    font-size: 18px;
    max-width: 540px;
  }

  .cta-group {
    flex-direction: row;
    justify-content: flex-start;
  }

  .cta-primary,
  .cta-secondary {
    width: auto;
    min-width: 180px;
  }

  .hero-points {
    flex-direction: row;
    justify-content: flex-start;
    gap: 2rem;
  }
  
  .point {
    background: transparent;
    padding: 0;
    border: none;
  }
  
  /* Desktop-specific adjustments for preview box */
  .preview-box {
    transform: perspective(1000px) rotateY(-5deg);
    transition: transform 0.5s ease;
  }
  
  .preview-wrapper:hover .preview-box {
    transform: perspective(1000px) rotateY(0deg) scale(1.02);
    animation-play-state: paused;
  }
}
</style>


<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const loading = ref(true);
const previewContents = ref([]);

onMounted(async () => {
  try {
    const { data } = await axios.get('/contents', {
      params: { page: 1 },
    });
    previewContents.value = (data.contents?.data || []).slice(0, 3);
  } catch (error) {
    console.error(error);
  } finally {
    loading.value = false;
  }
});
</script>
