<template>
  <div class="min-h-[60vh] flex items-center justify-center text-slate-100">
    <p class="text-sm text-slate-300">กำลังเข้าสู่ระบบผ่านโซเชียล...</p>
  </div>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

const TOKEN_KEY = 'auth_token';

const token = route.query.token;
const redirect = route.query.redirect || '/dashboard';

if (token) {
  // เก็บ token เหมือน login ปกติ
  localStorage.setItem(TOKEN_KEY, token);
  // แจ้ง AppLayout ให้ sync state
  window.dispatchEvent(new Event('auth-changed'));
}

// redirect ไปหน้าที่ต้องการ
router.replace(redirect);
</script>
