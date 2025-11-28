<template>
  <section class="min-h-[calc(100vh-140px)] flex items-center justify-center">
    <div class="w-full max-w-md px-4">
      <div
        class="rounded-2xl bg-slate-900/80 border border-white/10 shadow-xl px-6 py-10 text-center"
      >
        <!-- Success Icon -->
        <div class="mb-6 flex justify-center">
          <div class="rounded-full bg-emerald-500/10 p-4">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-12 w-12 text-emerald-500"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M5 13l4 4L19 7"
              />
            </svg>
          </div>
        </div>

        <!-- Title -->
        <h1 class="mb-3 text-2xl font-bold text-white">
          ยืนยันอีเมลสำเร็จ
        </h1>

        <!-- Description -->
        <p class="mb-8 text-slate-400">
          บัญชีของคุณได้รับการยืนยันเรียบร้อยแล้ว<br />
          คุณสามารถเข้าสู่ระบบเพื่อใช้งานได้ทันที
        </p>

        <!-- Login Button -->
        <RouterLink
          to="/login"
          class="inline-flex w-full items-center justify-center rounded-xl bg-amber-500 py-3 text-sm font-semibold text-slate-900 hover:bg-amber-400 transition"
        >
          เข้าสู่ระบบ
        </RouterLink>
      </div>
    </div>
  </section>
</template>

<script setup>
import { RouterLink } from 'vue-router'
</script>
