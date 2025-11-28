<template>
  <section class="min-h-[calc(100vh-140px)] flex items-center">
    <div class="w-full max-w-md mx-auto px-4">
      <div
        class="rounded-2xl bg-slate-900/80 border border-white/10 shadow-xl px-6 py-7"
      >
        <!-- หัวข้อ -->
        <div class="mb-6 text-center">
          <h1 class="text-2xl font-semibold text-white mb-1">เข้าสู่ระบบ</h1>
          <p class="text-sm text-slate-400">
            เข้าสู่ระบบเพื่อเข้าถึงคอนเทนต์ Exclusive ของคุณ
          </p>
        </div>

        <!-- ฟอร์มล็อกอินปกติ -->
        <form @submit.prevent="handleLogin" class="space-y-4">
          <!-- อีเมล -->
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

          <!-- รหัสผ่าน -->
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

          <!-- error login -->
          <p v-if="errorMessage" class="text-xs text-red-400">
            {{ errorMessage }}
          </p>

          <!-- ข้อความจากการยืนยันอีเมล -->
          <p v-if="verifyMessage" class="mb-2 text-xs text-emerald-400">
            {{ verifyMessage }}
          </p>

          <!-- ปุ่ม login แบบมี spinner -->
          <button
            type="submit"
            :disabled="loading || googleLoading || lineLoading"
            class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 py-2.5 text-sm font-semibold text-slate-900 hover:bg-amber-400 disabled:opacity-60 disabled:cursor-not-allowed transition"
          >
            <svg
              v-if="loading"
              class="h-4 w-4 animate-spin"
              viewBox="0 0 24 24"
            >
              <circle
                class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"
                fill="none"
              />
              <path
                class="opacity-75"
                fill="currentColor"
                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
              />
            </svg>

            <span>
              {{ loading ? 'กำลังเข้าสู่ระบบ...' : 'เข้าสู่ระบบ' }}
            </span>
          </button>
        </form>

        <!-- Social Login -->
        <div class="mt-5 space-y-3">
          <p
            class="text-center text-[11px] uppercase tracking-[0.2em] text-slate-500"
          >
            หรือเข้าสู่ระบบด้วย
          </p>

          <div class="grid grid-cols-2 gap-2 text-xs">
            <!-- Google -->
            <button
              type="button"
              @click="loginGoogle"
              :disabled="loading || googleLoading || lineLoading"
              class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-700 bg-slate-900 px-3 py-2 hover:bg-slate-800 disabled:opacity-60 disabled:cursor-not-allowed transition"
            >
              <svg
                v-if="googleLoading"
                class="h-4 w-4 animate-spin"
                viewBox="0 0 24 24"
              >
                <circle
                  class="opacity-25"
                  cx="12"
                  cy="12"
                  r="10"
                  stroke="currentColor"
                  stroke-width="4"
                  fill="none"
                />
                <path
                  class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                />
              </svg>
              <span class="text-slate-100">
                {{ googleLoading ? 'กำลังเชื่อมต่อ...' : 'Google' }}
              </span>
            </button>

            <!-- LINE -->
            <button
              type="button"
              @click="loginLine"
              :disabled="loading || googleLoading || lineLoading"
              class="inline-flex items-center justify-center gap-2 rounded-xl border border-green-500/70 bg-green-500 px-3 py-2 text-xs font-semibold text-white hover:bg-green-400 disabled:opacity-60 disabled:cursor-not-allowed transition"
            >
              <svg
                v-if="lineLoading"
                class="h-4 w-4 animate-spin"
                viewBox="0 0 24 24"
              >
                <circle
                  class="opacity-25"
                  cx="12"
                  cy="12"
                  r="10"
                  stroke="currentColor"
                  stroke-width="4"
                  fill="none"
                />
                <path
                  class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                />
              </svg>
              <span>
                {{ lineLoading ? 'กำลังเชื่อมต่อ...' : 'Login with LINE' }}
              </span>
            </button>
          </div>
        </div>

        <!-- link สมัครสมาชิก -->
        <p class="mt-6 text-center text-xs text-slate-400">
          ยังไม่มีบัญชี?
          <RouterLink
            to="/register"
            class="font-semibold text-amber-400 hover:text-amber-300"
          >
            สมัครสมาชิก
          </RouterLink>
        </p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { reactive, ref, computed } from 'vue'
import { useRouter, useRoute, RouterLink } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const route = useRoute()

const form = reactive({
  name: '',
  email: '',
  password: '',
})

const loading = ref(false)
const googleLoading = ref(false)
const lineLoading = ref(false)

const errorMessage = ref('')
const successMessage = ref('')

// ✅ ข้อความหลัง verify email จาก query ?verify=...
// ใช้ SweetAlert2 แทนข้อความธรรมดา
import Swal from 'sweetalert2'
import { onMounted } from 'vue'

onMounted(() => {
  const v = route.query.verify
  if (!v) return

  if (v === 'success') {
    Swal.fire({
      icon: 'success',
      title: 'ยืนยันอีเมลสำเร็จ',
      text: 'บัญชีของคุณได้รับการยืนยันแล้ว กรุณาเข้าสู่ระบบ',
      confirmButtonText: 'ตกลง',
      confirmButtonColor: '#f59e0b', // amber-500
      background: '#0f172a', // slate-900
      color: '#fff'
    })
  } else if (v === 'expired') {
    Swal.fire({
      icon: 'error',
      title: 'ลิงก์หมดอายุ',
      text: 'ลิงก์ยืนยันหมดอายุ กรุณาสมัครสมาชิกใหม่อีกครั้ง',
      confirmButtonText: 'ตกลง',
      confirmButtonColor: '#f59e0b',
      background: '#0f172a',
      color: '#fff'
    })
  } else if (v === 'invalid') {
    Swal.fire({
      icon: 'error',
      title: 'ลิงก์ไม่ถูกต้อง',
      text: 'ไม่สามารถยืนยันได้ ลิงก์ไม่ถูกต้อง หรือถูกใช้ไปแล้ว',
      confirmButtonText: 'ตกลง',
      confirmButtonColor: '#f59e0b',
      background: '#0f172a',
      color: '#fff'
    })
  }
})

const verifyMessage = computed(() => {
  // เก็บไว้เป็น fallback หรือลบออกก็ได้ แต่ user อยากได้ alert ดังนั้นส่วนนี้อาจจะไม่จำเป็นต้องแสดงผลใน template แล้ว
  // แต่ถ้าจะเก็บไว้ก็ไม่เสียหาย
  const v = route.query.verify
  if (!v) return ''
  // ... (logic เดิม)
  return ''
})

const handleLogin = async () => {
  loading.value = true
  errorMessage.value = ''

  try {
    const { data } = await axios.post('/login', {
      email: form.email,
      password: form.password,
    })

    if (data.token) {
      localStorage.setItem('auth_token', data.token)
      axios.defaults.headers.common['Authorization'] = `Bearer ${data.token}`
      window.dispatchEvent(new Event('auth-changed'))
    }

    await router.push({ name: 'dashboard' })
  } catch (e) {
    errorMessage.value =
      e.response?.data?.message || 'เข้าสู่ระบบไม่สำเร็จ กรุณาลองใหม่อีกครั้ง'
  } finally {
    loading.value = false
  }
}

// ✅ Social Login
const loginGoogle = () => {
  googleLoading.value = true
  errorMessage.value = ''
  // หน้าเพจกำลังจะเปลี่ยน แต่จะเห็น spinner แวบหนึ่งก่อน redirect
  window.location.href = '/login/google'
}

const loginLine = () => {
  lineLoading.value = true
  errorMessage.value = ''
  window.location.href = '/login/line'
}
</script>
