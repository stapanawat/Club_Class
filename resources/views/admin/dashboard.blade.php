@extends('admin.layout')

@section('title', 'Admin Dashboard · Exclusive')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'ภาพรวมระบบ Exclusive Content')

@section('content')
    <div class="space-y-8">

        {{-- HEADER + SUMMARY STRIP --}}
        <section
            class="rounded-2xl bg-gradient-to-r from-slate-900 via-slate-900 to-slate-950 border border-slate-800 px-4 py-4 md:px-6 md:py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p
                    class="inline-flex items-center gap-2 rounded-full border border-amber-500/40 bg-amber-500/10 px-3 py-1 text-[11px] uppercase tracking-[0.18em] text-amber-300">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                    Realtime Overview
                </p>
                <h2 class="mt-3 text-lg md:text-xl font-semibold text-slate-50">
                    ภาพรวมระบบ Exclusive Content วันนี้
                </h2>
                <p class="mt-1 text-xs md:text-sm text-slate-400">
                    ดูจำนวนคอนเทนต์, สมาชิก, คำขอใหม่ และยอดชำระเงินแบบสรุปในหน้าเดียว
                </p>
            </div>

            <div class="grid grid-cols-2 gap-3 md:flex md:flex-col md:items-end text-xs text-slate-300">
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    สมาชิกใหม่วันนี้:
                    <span class="font-semibold text-emerald-300">
                        {{ $newMembersToday ?? 0 }}
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                    ยอดชำระเงินวันนี้:
                    <span class="font-semibold text-amber-300">
                        ฿{{ number_format($paymentsToday ?? 0, 2) }}
                    </span>
                </div>
            </div>
        </section>

        {{-- SUMMARY CARDS --}}
        <section class="grid gap-4 md:grid-cols-4">
            {{-- Content count --}}
            <article class="rounded-2xl bg-slate-950/80 border border-slate-800 px-4 py-4 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] text-slate-400 uppercase tracking-[0.16em]">
                        Content
                    </p>
                    <span class="rounded-full bg-slate-900 px-2 py-0.5 text-[10px] text-slate-400">
                        ทั้งหมด
                    </span>
                </div>
                <p class="mt-2 text-3xl font-semibold text-slate-50">
                    {{ $contentCount ?? 0 }}
                </p>
                <p class="mt-1 text-[11px] text-slate-500">
                    รวมบทความ + วิดีโอทั้งหมดในระบบ
                </p>
            </article>

            {{-- Active members --}}
            <article
                class="rounded-2xl bg-gradient-to-br from-emerald-500/15 via-slate-950 to-slate-950 border border-emerald-500/40 px-4 py-4 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] text-slate-300 uppercase tracking-[0.16em]">
                        Active Members
                    </p>
                    <span class="rounded-full bg-emerald-500/10 px-2 py-0.5 text-[10px] text-emerald-200">
                        online
                    </span>
                </div>
                <p class="mt-2 text-3xl font-semibold text-emerald-300">
                    {{ $activeMembers ?? 0 }}
                </p>
                <p class="mt-1 text-[11px] text-emerald-100/80">
                    สมาชิกที่มีสิทธิ์ดูคอนเทนต์ทั้งหมด
                </p>
            </article>

            {{-- Pending members --}}
            <article
                class="rounded-2xl bg-gradient-to-br from-amber-500/12 via-slate-950 to-slate-950 border border-amber-500/40 px-4 py-4 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] text-slate-300 uppercase tracking-[0.16em]">
                        Pending Requests
                    </p>
                    <span class="rounded-full bg-amber-500/10 px-2 py-0.5 text-[10px] text-amber-200">
                        รออนุมัติ
                    </span>
                </div>
                <p class="mt-2 text-3xl font-semibold text-amber-300">
                    {{ $pendingMembers ?? 0 }}
                </p>
                <p class="mt-1 text-[11px] text-amber-100/80">
                    แนะนำให้ตรวจสอบและอนุมัติ/ปฏิเสธ
                </p>
            </article>

            {{-- Today quick stats --}}
            <article class="rounded-2xl bg-slate-950/80 border border-slate-800 px-4 py-4 flex flex-col gap-3">
                <p class="text-[11px] text-slate-400 uppercase tracking-[0.16em]">
                    Today Snapshot
                </p>
                <div class="flex items-center justify-between text-xs">
                    <div>
                        <p class="text-slate-400">สมาชิกใหม่</p>
                        <p class="mt-0.5 text-lg font-semibold text-slate-50">
                            {{ $newMembersToday ?? 0 }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-slate-400">ยอดชำระเงิน</p>
                        <p class="mt-0.5 text-lg font-semibold text-emerald-300">
                            ฿{{ number_format($paymentsToday ?? 0, 2) }}
                        </p>
                    </div>
                </div>
                <p class="mt-auto text-[11px] text-slate-500">
                    ข้อมูลอัปเดตจากระบบ Payment แบบเรียลไทม์
                </p>
            </article>
        </section>

        {{-- CONTENT + MEMBERS LIST --}}
        <section class="grid gap-6 lg:grid-cols-[1.3fr,1fr]">
            {{-- Latest contents --}}
            <article class="rounded-2xl bg-slate-950/80 border border-slate-800 p-4 md:p-5">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-100">
                            คอนเทนต์ล่าสุด
                        </h3>
                        <p class="text-[11px] text-slate-500">
                            5 รายการที่ถูกสร้างหรืออัปเดตล่าสุด
                        </p>
                    </div>
                    <a href="{{ route('admin.contents.index') }}" class="text-xs text-amber-300 hover:text-amber-200">
                        ดูทั้งหมด →
                    </a>
                </div>

                <div class="divide-y divide-slate-800 text-sm">
                    @forelse($latestContents ?? [] as $content)
                        <div class="py-3 flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <p class="font-medium text-slate-100 truncate">
                                    {{ optional($content)->title }}
                                </p>
                                <div class="mt-1 flex flex-wrap items-center gap-2 text-[11px] text-slate-500">
                                    <span
                                        class="inline-flex items-center rounded-full bg-slate-900 px-2 py-0.5 text-[10px] uppercase tracking-[0.12em]">
                                        {{ optional($content)->type === 'video' ? 'Video' : 'Article' }}
                                    </span>
                                    <span>
                                        · {{ optional($content->category)->name ?? 'ไม่ระบุหมวดหมู่' }}
                                    </span>
                                </div>
                            </div>
                            <span class="text-[11px] text-slate-500 whitespace-nowrap">
                                {{ optional($content)->created_at?->diffForHumans() }}
                            </span>
                        </div>
                    @empty
                        <p class="py-4 text-sm text-slate-500">
                            ยังไม่มีคอนเทนต์ในระบบ
                        </p>
                    @endforelse
                </div>
            </article>

            {{-- Latest members --}}
            <article class="rounded-2xl bg-slate-950/80 border border-slate-800 p-4 md:p-5">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-100">
                            สมาชิกที่เพิ่งสมัคร
                        </h3>
                        <p class="text-[11px] text-slate-500">
                            5 ผู้ใช้ล่าสุดในระบบ
                        </p>
                    </div>
                    <a href="{{ route('admin.members.index') }}" class="text-xs text-amber-300 hover:text-amber-200">
                        จัดการสมาชิก →
                    </a>
                </div>

                <div class="divide-y divide-slate-800 text-sm">
                    @forelse($latestMembers ?? [] as $member)
                        <div class="py-3 flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <p class="font-medium text-slate-100 truncate">
                                    {{ $member->name ?? '-' }}
                                </p>
                                <p class="text-[11px] text-slate-500 truncate mt-0.5">
                                    {{ $member->email }}
                                </p>
                            </div>
                            <span class="text-[11px] text-slate-500 whitespace-nowrap">
                                {{ $member->created_at?->diffForHumans() }}
                            </span>
                        </div>
                    @empty
                        <p class="py-4 text-sm text-slate-500">
                            ยังไม่มีสมาชิกในระบบ
                        </p>
                    @endforelse
                </div>
            </article>
        </section>

        {{-- LATEST PAYMENTS --}}
        <section class="rounded-2xl bg-slate-950/80 border border-slate-800 p-4 md:p-5">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h3 class="text-sm font-semibold text-slate-100">
                        การชำระเงินล่าสุด
                    </h3>
                    <p class="text-[11px] text-slate-500">
                        แสดง 5 รายการจ่ายเงินล่าสุดจากระบบ
                    </p>
                </div>
                <a href="{{ route('admin.payments.index') }}" class="text-xs text-amber-300 hover:text-amber-200">
                    ไปหน้าจัดการ Payment →
                </a>
            </div>

            {{-- Desktop table --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full text-xs text-slate-200">
                    <thead>
                        <tr class="border-b border-slate-800 text-[11px] text-slate-400 uppercase">
                            <th class="py-2 text-left">ผู้ชำระ</th>
                            <th class="py-2 text-left">อีเมล</th>
                            <th class="py-2 text-right">ยอดเงิน</th>
                            <th class="py-2 text-left">สถานะ</th>
                            <th class="py-2 text-right">เวลา</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestPayments ?? [] as $payment)
                            <tr class="border-b border-slate-800/60">
                                <td class="py-2 pr-2">
                                    {{ optional($payment->user)->name ?? '-' }}
                                </td>
                                <td class="py-2 pr-2 text-slate-400">
                                    {{ optional($payment->user)->email ?? '-' }}
                                </td>
                                <td class="py-2 pl-2 text-right">
                                    ฿{{ number_format($payment->amount ?? 0, 2) }}
                                </td>
                                <td class="py-2 pr-2">
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px]
                                        @if($payment->status === 'approved')
                                            bg-emerald-500/10 text-emerald-300 border border-emerald-500/40
                                        @elseif($payment->status === 'pending')
                                            bg-amber-500/10 text-amber-300 border border-amber-500/40
                                        @else
                                            bg-rose-500/10 text-rose-300 border border-rose-500/40
                                        @endif">
                                        {{ $payment->status ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-2 text-right text-slate-400">
                                    {{ $payment->created_at?->format('d/m H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-slate-500">
                                    ยังไม่มีข้อมูลการชำระเงิน
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile cards --}}
            <div class="md:hidden space-y-3">
                @forelse($latestPayments ?? [] as $payment)
                    <div class="rounded-xl bg-slate-900 border border-slate-800 p-4">
                        <p class="font-medium text-slate-100">
                            {{ optional($payment->user)->name ?? '-' }}
                        </p>
                        <p class="text-[11px] text-slate-500">
                            {{ optional($payment->user)->email ?? '-' }}
                        </p>

                        <div class="mt-2 grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <p class="text-slate-500">ยอดเงิน</p>
                                <p class="font-mono text-slate-100">
                                    ฿{{ number_format($payment->amount ?? 0, 2) }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-slate-500">สถานะ</p>
                                <p class="mt-0.5">
                                    <span class="@if($payment->status === 'approved') text-emerald-300
                                     @elseif($payment->status === 'pending') text-amber-300
                                                     @else text-rose-300 @endif font-semibold">
                                        {{ $payment->status ?? '-' }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <p class="mt-2 text-[11px] text-slate-500">
                            {{ $payment->created_at?->format('d/m/Y H:i') }}
                        </p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">
                        ยังไม่มีข้อมูลการชำระเงิน
                    </p>
                @endforelse
            </div>
        </section>

    </div>
@endsection