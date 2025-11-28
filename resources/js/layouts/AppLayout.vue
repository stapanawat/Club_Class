<template>
  <div class="min-h-screen bg-[#020617] text-slate-100 selection:bg-amber-500/30 selection:text-amber-200 overflow-x-hidden relative">
    
    <!-- Background Effects -->
    <div class="fixed inset-0 z-0 pointer-events-none">
      <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-emerald-900/20 blur-[120px]"></div>
      <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-amber-900/20 blur-[120px]"></div>
      <div class="absolute top-[20%] left-[50%] -translate-x-1/2 w-[60%] h-[60%] rounded-full bg-slate-900/50 blur-[100px]"></div>
      <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150 mix-blend-overlay"></div>
    </div>

    <!-- Navbar -->
    <header
      class="sticky top-0 z-50 border-b border-white/5 bg-slate-950/70 backdrop-blur-xl supports-[backdrop-filter]:bg-slate-950/40"
    >
      <div
        class="mx-auto flex items-center justify-between w-full max-w-6xl px-4 py-4 sm:px-6"
      >
        <div class="flex items-center gap-2">
          
          <h1 class="text-lg font-bold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-white via-slate-200 to-slate-400">
            Exclusive Video
          </h1>
        </div>

        <!-- Desktop Actions -->
        <div class="hidden md:flex items-center gap-4">
          <slot name="header-actions"></slot>
        </div>

        <!-- Mobile Menu Button -->
        <button
          @click="isMobileMenuOpen = !isMobileMenuOpen"
          class="md:hidden relative z-50 p-2 text-slate-400 hover:text-white transition-colors"
        >
          <div class="w-6 h-5 flex flex-col justify-between">
            <span :class="['w-full h-0.5 bg-current rounded-full transition-all duration-300', isMobileMenuOpen ? 'rotate-45 translate-y-2' : '']"></span>
            <span :class="['w-full h-0.5 bg-current rounded-full transition-all duration-300', isMobileMenuOpen ? 'opacity-0' : '']"></span>
            <span :class="['w-full h-0.5 bg-current rounded-full transition-all duration-300', isMobileMenuOpen ? '-rotate-45 -translate-y-2.5' : '']"></span>
          </div>
        </button>
      </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <Transition
      enter-active-class="transition duration-500 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-300 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="isMobileMenuOpen"
        class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-md md:hidden"
        @click="isMobileMenuOpen = false"
      >
        <!-- Ambient Glow in Overlay -->
        <div class="absolute inset-0 bg-gradient-to-tr from-emerald-900/20 via-transparent to-amber-900/20 opacity-50"></div>
      </div>
    </Transition>

    <!-- Mobile Menu Drawer -->
    <Transition
      enter-active-class="transition duration-500 cubic-bezier(0.16, 1, 0.3, 1)"
      enter-from-class="translate-x-full"
      enter-to-class="translate-x-0"
      leave-active-class="transition duration-300 ease-in"
      leave-from-class="translate-x-0"
      leave-to-class="translate-x-full"
    >
      <div
        v-if="isMobileMenuOpen"
        class="fixed inset-y-0 right-0 z-50 w-72 bg-[#020617] border-l border-white/10 shadow-[-10px_0_30px_rgba(0,0,0,0.5)] md:hidden flex flex-col overflow-hidden"
      >
        <!-- Drawer Background Effects -->
        <div class="absolute inset-0 pointer-events-none">
          <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/10 rounded-full blur-[80px]"></div>
          <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-[80px]"></div>
          <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10 mix-blend-overlay"></div>
        </div>

        <div class="relative z-10 p-6 pt-24 flex flex-col gap-6 h-full">
          <!-- Mobile Menu Items -->
           <div class="flex flex-col gap-3">
             <RouterLink
               to="/"
               class="group relative px-5 py-4 rounded-2xl text-slate-400 transition-all duration-300 overflow-hidden border border-white/5 hover:border-amber-500/50 hover:shadow-[0_0_20px_rgba(245,158,11,0.15)]"
               active-class="!text-amber-300 bg-gradient-to-r from-amber-500/10 to-transparent border-amber-500/30 shadow-[0_0_15px_rgba(245,158,11,0.1)]"
               @click="isMobileMenuOpen = false"
             >
               <!-- Hover Gradient Background -->
               <div class="absolute inset-0 bg-gradient-to-r from-amber-600/20 via-amber-900/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
               
               <!-- Shine Effect -->
               <div class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/5 to-transparent z-0"></div>

               <div class="relative z-10 flex items-center gap-4">
                 <div class="p-2 rounded-lg bg-slate-950/50 border border-white/10 group-hover:border-amber-500/50 group-hover:bg-amber-500/10 transition-all duration-300 group-hover:scale-110 group-hover:shadow-[0_0_10px_rgba(245,158,11,0.2)]">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 transition-colors group-hover:text-amber-300">
                     <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
                   </svg>
                 </div>
                 <span class="font-medium tracking-wide group-hover:text-amber-200 transition-colors">หน้าแรก</span>
               </div>
             </RouterLink>
             
             <RouterLink
               to="/contents"
               class="group relative px-5 py-4 rounded-2xl text-slate-400 transition-all duration-300 overflow-hidden border border-white/5 hover:border-amber-500/50 hover:shadow-[0_0_20px_rgba(245,158,11,0.15)]"
               active-class="!text-amber-300 bg-gradient-to-r from-amber-500/10 to-transparent border-amber-500/30 shadow-[0_0_15px_rgba(245,158,11,0.1)]"
               @click="isMobileMenuOpen = false"
             >
               <div class="absolute inset-0 bg-gradient-to-r from-amber-600/20 via-amber-900/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
               <div class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/5 to-transparent z-0"></div>

               <div class="relative z-10 flex items-center gap-4">
                 <div class="p-2 rounded-lg bg-slate-950/50 border border-white/10 group-hover:border-amber-500/50 group-hover:bg-amber-500/10 transition-all duration-300 group-hover:scale-110 group-hover:shadow-[0_0_10px_rgba(245,158,11,0.2)]">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 transition-colors group-hover:text-amber-300">
                     <path d="M6.5 3c-1.051 0-2.093.04-3.125.117A1.49 1.49 0 002 4.607V10.5h9V4.606c0-.83-.59-1.544-1.375-1.49A22.456 22.456 0 016.5 3zM2 12v2.393c0 .83.59 1.544 1.375 1.491 1.032.077 2.074.117 3.125.117 1.051 0 2.093-.04 3.125-.117A1.49 1.49 0 0011 14.393V12H2z" />
                     <path d="M17.5 3c-1.051 0-2.093.04-3.125.117A1.49 1.49 0 0013 4.607V10.5h9V4.606c0-.83-.59-1.544-1.375-1.49A22.456 22.456 0 0117.5 3zM13 12v2.393c0 .83.59 1.544 1.375 1.491 1.032.077 2.074.117 3.125.117 1.051 0 2.093-.04 3.125-.117A1.49 1.49 0 0022 14.393V12h-9z" />
                   </svg>
                 </div>
                 <span class="font-medium tracking-wide group-hover:text-amber-200 transition-colors">คอนเทนต์ทั้งหมด</span>
               </div>
             </RouterLink>

             <RouterLink
               to="/subscription"
               class="group relative px-5 py-4 rounded-2xl text-slate-400 transition-all duration-300 overflow-hidden border border-white/5 hover:border-amber-500/50 hover:shadow-[0_0_20px_rgba(245,158,11,0.15)]"
               active-class="!text-amber-300 bg-gradient-to-r from-amber-500/10 to-transparent border-amber-500/30 shadow-[0_0_15px_rgba(245,158,11,0.1)]"
               @click="isMobileMenuOpen = false"
             >
               <div class="absolute inset-0 bg-gradient-to-r from-amber-600/20 via-amber-900/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
               <div class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/5 to-transparent z-0"></div>

               <div class="relative z-10 flex items-center gap-4">
                 <div class="p-2 rounded-lg bg-slate-950/50 border border-white/10 group-hover:border-amber-500/50 group-hover:bg-amber-500/10 transition-all duration-300 group-hover:scale-110 group-hover:shadow-[0_0_10px_rgba(245,158,11,0.2)]">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 transition-colors group-hover:text-amber-300">
                     <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                   </svg>
                 </div>
                 <span class="font-medium tracking-wide group-hover:text-amber-200 transition-colors">สมัครสมาชิก</span>
               </div>
             </RouterLink>
           </div>

           <!-- Slot for extra actions in mobile -->
           <div class="mt-auto border-t border-white/10 pt-6">
              <slot name="header-actions"></slot>
           </div>
        </div>
      </div>
    </Transition>

    <!-- Content -->
    <main class="relative z-10 w-full mx-auto max-w-6xl px-4 py-8 sm:px-6 sm:py-10">
      <slot></slot>
    </main>

  </div>
</template>

<script setup>
import { ref } from 'vue';
import { RouterLink } from 'vue-router';

const isMobileMenuOpen = ref(false);
</script>
