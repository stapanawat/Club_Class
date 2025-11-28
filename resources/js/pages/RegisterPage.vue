<template>
  <section class="min-h-[calc(100vh-140px)] flex items-center">
    <div class="w-full max-w-md mx-auto">
      <div
        class="rounded-2xl bg-slate-900/80 border border-white/10 shadow-xl px-6 py-7"
      >
        <div class="mb-6 text-center">
          <h1 class="text-2xl font-semibold text-white mb-1">สมัครสมาชิก</h1>
          <p class="text-sm text-slate-400">
            สร้างบัญชีเพื่อเข้าถึงคอนเทนต์พิเศษของคุณ
          </p>
        </div>

        <form @submit.prevent="handleRegister" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-slate-200">
              ชื่อ
            </label>
            <input
              v-model="form.name"
              type="text"
              class="mt-1 w-full rounded-xl border border-slate-700/70 bg-slate-900 px-3 py-2 text-sm text-slate-100 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none"
              required
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-200">
              อีเมล
            </label>
            <input
              v-model="form.email"
              type="email"
              class="mt-1 w-full rounded-xl border border-slate-700/70 bg-slate-900 px-3 py-2 text-sm text-slate-100 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none"
              required
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-200">
              รหัสผ่าน
            </label>
            <input
              v-model="form.password"
              type="password"
              class="mt-1 w-full rounded-xl border border-slate-700/70 bg-slate-900 px-3 py-2 text-sm text-slate-100 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none"
              required
            />
          </div>

          <p v-if="errorMessage" class="text-xs text-red-400">
            {{ errorMessage }}
          </p>
          <p v-if="successMessage" class="text-xs text-emerald-400">
            {{ successMessage }}
          </p>

          <button
            type="submit"
            :disabled="loading"
            class="w-full rounded-xl bg-amber-500 py-2.5 text-sm font-semibold text-slate-900 hover:bg-amber-400 disabled:opacity-60 disabled:cursor-not-allowed transition"
          >
            {{ loading ? 'กำลังสมัครสมาชิก...' : 'สมัครสมาชิก' }}
          </button>
        </form>

        <p class="mt-6 text-center text-xs text-slate-400">
          มีบัญชีแล้ว?
          <RouterLink
            to="/login"
            class="font-semibold text-amber-400 hover:text-amber-300"
          >
            เข้าสู่ระบบ
          </RouterLink>
        </p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter, RouterLink } from 'vue-router';
import axios from 'axios';

const router = useRouter();

const form = reactive({
  name: '',
  email: '',
  password: '',
});

const loading = ref(false);
const errorMessage = ref('');
const successMessage = ref('');

const handleRegister = async () => {
  loading.value = true;
  errorMessage.value = '';
  successMessage.value = '';

  try {
    const { data } = await axios.post('/register', form);

    const handleRegister = async () => {
  loading.value = true;
  errorMessage.value = '';
  successMessage.value = '';

  try {
    await axios.post('/register', form);

    successMessage.value =
      'สมัครสมาชิกสำเร็จ! กรุณาตรวจสอบอีเมลของคุณ และกดยืนยันภายใน 30 นาที';

    // ไม่ต้องเก็บ token / ไม่ต้อง redirect ทันที
    // แนะนำพาไปหน้า login หลังจากสักครู่
    setTimeout(() => {
      router.push({ name: 'login' });
    }, 2000);
  } catch (e) {
    errorMessage.value =
      e.response?.data?.message || 'สมัครสมาชิกไม่สำเร็จ กรุณาลองใหม่อีกครั้ง';
  } finally {
    loading.value = false;
  }
};


    successMessage.value = 'สมัครสมาชิกสำเร็จ! กรุณายืนยันอีเมลภายใน 30 นาที';
setTimeout(() => router.push('/register'), 800);

  } catch (e) {
    errorMessage.value =
      e.response?.data?.message || 'สมัครสมาชิกไม่สำเร็จ กรุณาลองใหม่อีกครั้ง';
  } finally {
    loading.value = false;
  }
};
</script>
