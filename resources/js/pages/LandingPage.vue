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
   BASE MOBILE-FIRST STYLING (Mobile = Default)
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
  background: radial-gradient(circle at 50% 50%, rgba(16, 185, 129, 0.15), transparent 60%),
              radial-gradient(circle at 80% 20%, rgba(245, 158, 11, 0.15), transparent 50%);
  filter: blur(80px);
  z-index: -1;
  animation: pulse-glow 10s infinite alternate;
}

@keyframes pulse-glow {
  0% { transform: scale(1); opacity: 0.8; }
  100% { transform: scale(1.1); opacity: 1; }
}

.hero-text {
  text-align: center;
  position: relative;
}

.hero-label {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.35rem 1rem;
  font-size: 12px;
  border-radius: 9999px;
  background: rgba(245, 158, 11, 0.1);
  color: #fbbf24;
  border: 1px solid rgba(245, 158, 11, 0.3);
  backdrop-filter: blur(4px);
  box-shadow: 0 0 15px rgba(245, 158, 11, 0.1);
  text-transform: uppercase;
  letter-spacing: 0.05em;
  font-weight: 600;
}

.hero-title {
  margin-top: 1.5rem;
  font-size: 2.25rem;
  font-weight: 700;
  color: #f1f5f9;
  line-height: 1.2;
  letter-spacing: -0.02em;
}

.hero-subtitle {
  display: block;
  margin-top: 0.5rem;
  background: linear-gradient(to right, #fde68a, #fbbf24, #d97706);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  filter: drop-shadow(0 0 10px rgba(245, 158, 11, 0.3));
}

.hero-description {
  margin-top: 1.25rem;
  font-size: 16px;
  color: #94a3b8;
  line-height: 1.6;
  max-width: 480px;
  margin-left: auto;
  margin-right: auto;
}

.cta-group {
  margin-top: 2rem;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.cta-primary {
  width: 100%;
  padding: 0.875rem 1.5rem;
  font-size: 15px;
  border-radius: 9999px;
  font-weight: 600;
  text-align: center;
  background: linear-gradient(135deg, #fbbf24, #d97706);
  color: #0f172a;
  box-shadow: 0 4px 20px rgba(245, 158, 11, 0.4);
  transition: all 0.3s ease;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.cta-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(245, 158, 11, 0.6);
  background: linear-gradient(135deg, #fcd34d, #b45309);
}

.cta-secondary {
  width: 100%;
  padding: 0.875rem 1.5rem;
  font-size: 15px;
  border-radius: 9999px;
  font-weight: 600;
  text-align: center;
  color: #e2e8f0;
  border: 1px solid rgba(255, 255, 255, 0.1);
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(4px);
  transition: all 0.3s ease;
}

.cta-secondary:hover {
  background: rgba(255, 255, 255, 0.1);
  border-color: rgba(255, 255, 255, 0.2);
  color: #fff;
}

.hero-points {
  margin-top: 2rem;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  font-size: 13px;
  color: #cbd5e1;
}

.point {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  justify-content: center;
}

.dot {
  width: 8px;
  height: 8px;
  border-radius: 9999px;
  box-shadow: 0 0 8px currentColor;
}

.dot-green {
  background: #10b981;
  color: rgba(16, 185, 129, 0.5);
}

.dot-amber {
  background: #fbbf24;
  color: rgba(251, 191, 36, 0.5);
}

/* Preview section */
.preview-wrapper {
  width: 100%;
  position: relative;
}

.preview-wrapper::before {
  content: '';
  position: absolute;
  inset: -1px;
  background: linear-gradient(to bottom right, rgba(255,255,255,0.1), transparent);
  border-radius: 1.1rem;
  z-index: -1;
  mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
  -webkit-mask-composite: xor;
  mask-composite: exclude;
}

.preview-box {
  background: rgba(15, 23, 42, 0.6);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.05);
  padding: 1.5rem;
  border-radius: 1rem;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
  position: relative;
  overflow: hidden;
}

.preview-heading {
  font-size: 12px;
  text-transform: uppercase;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  color: #94a3b8;
  letter-spacing: 0.15em;
  font-weight: 600;
  margin-bottom: 1.5rem;
  border-bottom: 1px solid rgba(255,255,255,0.05);
  padding-bottom: 1rem;
}

.preview-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.preview-card {
  background: rgba(30, 41, 59, 0.4);
  border: 1px solid rgba(255, 255, 255, 0.05);
  padding: 1rem 1.25rem;
  border-radius: 0.75rem;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.preview-card::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(to right, transparent, rgba(255,255,255,0.05), transparent);
  transform: translateX(-100%);
  transition: transform 0.5s;
}

.preview-card:hover {
  transform: translateY(-2px);
  background: rgba(30, 41, 59, 0.6);
  border-color: rgba(245, 158, 11, 0.3);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.preview-card:hover::after {
  transform: translateX(100%);
}

.preview-title {
  font-size: 15px;
  color: #f1f5f9;
  font-weight: 600;
  line-height: 1.4;
}

.preview-type {
  font-size: 10px;
  background: rgba(15, 23, 42, 0.5);
  padding: 3px 8px;
  border-radius: 9999px;
  color: #cbd5e1;
  border: 1px solid rgba(255,255,255,0.1);
  text-transform: uppercase;
  letter-spacing: 0.05em;
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
  line-height: 1.5;
}

.preview-lock {
  font-size: 11px;
  margin-top: 0.75rem;
  color: #fbbf24;
  display: flex;
  align-items: center;
  gap: 0.25rem;
}

.preview-lock::before {
  content: '🔒';
  font-size: 10px;
}

/* -----------------------------------------------------
   DESKTOP VERSION (>= 768px)
----------------------------------------------------- */
@media (min-width: 768px) {
  .hero-section {
    max-width: 1280px;
    grid-template-columns: 1.2fr 1fr;
    padding: 6rem 2rem;
    align-items: center;
    gap: 4rem;
  }

  .hero-text {
    text-align: left;
  }
  
  .hero-description {
    margin-left: 0;
    margin-right: 0;
    font-size: 18px;
  }
  
  .hero-title {
    font-size: 3.5rem;
  }

  .cta-group {
    flex-direction: row;
    justify-content: flex-start;
  }

  .cta-primary,
  .cta-secondary {
    width: auto;
    min-width: 160px;
  }

  .hero-points {
    flex-direction: row;
    justify-content: flex-start;
    gap: 2rem;
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
