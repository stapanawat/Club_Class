<template>
  <div class="text-center text-white pt-20">
    <p>กำลังเข้าสู่ระบบผ่าน Social...</p>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();
const url = new URL(window.location.href);
const token = url.searchParams.get('token');

if (token) {
  localStorage.setItem('auth_token', token);
  window.dispatchEvent(new Event('auth-changed'));
  router.push('/dashboard');
} else {
  router.push('/login');
}
</script>
