@extends('admin.layout')

@section('title', 'จัดการคำขอสมาชิก')
@section('page-title', 'จัดการคำขอสมาชิก')
@section('page-subtitle', 'อนุมัติหรือปฏิเสธคำขอสมัครสมาชิก Exclusive')

@section('content')

    {{-- Flash message --}}
    @if(session('status'))
        <div class="mb-4 rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-100">
            {{ session('status') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-100">
            {{ session('error') }}
        </div>
    @endif


    {{-- ======================================
        PENDING — DESKTOP TABLE
    ======================================= --}}
    <div class="hidden md:block mb-8 rounded-2xl bg-slate-900/80 border border-slate-800 p-4">
        <h2 class="text-sm font-semibold text-slate-100 mb-3">
            คำขอสมาชิกที่รออนุมัติ
        </h2>

        @if($pendingPayments->isEmpty())
            <p class="text-sm text-slate-500">ยังไม่มีคำขอใหม่</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs">
                    <thead>
                        <tr class="border-b border-slate-800 text-slate-400">
                            <th class="px-3 py-2 text-left">ผู้ใช้</th>
                            <th class="px-3 py-2 text-left">แพ็กเกจ</th>
                            <th class="px-3 py-2 text-right">จำนวนเงิน</th>
                            <th class="px-3 py-2 text-left">ช่องทาง</th>
                            <th class="px-3 py-2 text-left">วันที่ขอ</th>
                            <th class="px-3 py-2 text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">

                        @foreach($pendingPayments as $payment)
                            <tr>
                                <td class="px-3 py-2">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-slate-100">{{ $payment->user->name ?? '-' }}</span>
                                        <span class="text-slate-500">{{ $payment->user->email ?? '' }}</span>
                                    </div>
                                </td>

                                <td class="px-3 py-2 text-slate-300">
                                    {{ $payment->reference ?? '-' }}
                                </td>

                                <td class="px-3 py-2 text-right font-mono text-slate-100">
                                    {{ number_format($payment->amount, 2) }}
                                </td>

                                <td class="px-3 py-2 text-xs text-slate-400">
                                    {{ $payment->channel ?? '-' }}
                                </td>

                                <td class="px-3 py-2 text-xs text-slate-400">
                                    {{ $payment->created_at?->format('d/m/Y H:i') }}
                                </td>

                                <td class="px-3 py-2 text-right">
                                    <div class="inline-flex gap-2">
                                        {{-- Approve --}}
                                        <form method="POST" action="{{ route('admin.payments.approve', $payment) }}"
                                              onsubmit="return confirm('ยืนยันการอนุมัติสมาชิกคนนี้ใช่ไหม?');">
                                            @csrf
                                            <button class="rounded-full bg-emerald-500/90 text-slate-900 px-3 py-1 text-xs font-semibold hover:bg-emerald-400">
                                                อนุมัติ
                                            </button>
                                        </form>

                                        {{-- Reject --}}
                                        <form method="POST" action="{{ route('admin.payments.reject', $payment) }}"
                                              onsubmit="return confirm('ต้องการปฏิเสธคำขอนี้ใช่ไหม?');">
                                            @csrf
                                            <input type="hidden" name="reason" value="Rejected by admin">
                                            <button class="rounded-full border border-red-500/70 text-red-200 px-3 py-1 text-xs hover:bg-red-500/10">
                                                ปฏิเสธ
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        @endif
    </div>


    {{-- ======================================
        PENDING — MOBILE CARD
    ======================================= --}}
    <div class="md:hidden space-y-3 mb-8">

        <h2 class="text-sm font-semibold text-slate-100">คำขอสมาชิกที่รออนุมัติ</h2>

        @forelse($pendingPayments as $payment)
            <div class="rounded-xl bg-slate-900/90 border border-slate-800 p-4 space-y-2">

                <div class="font-semibold text-slate-100">
                    {{ $payment->user->name ?? '-' }}
                </div>

                <div class="text-xs text-slate-400">
                    {{ $payment->user->email ?? '-' }}
                </div>

                <div class="text-xs text-slate-300">
                    <span class="text-slate-500">แพ็กเกจ:</span>
                    {{ $payment->reference ?? '-' }}
                </div>

                <div class="text-xs text-slate-300">
                    <span class="text-slate-500">ช่องทาง:</span>
                    {{ $payment->channel ?? '-' }}
                </div>

                <div class="text-xs text-slate-300">
                    <span class="text-slate-500">วันที่:</span>
                    {{ $payment->created_at?->format('d/m/Y H:i') }}
                </div>

                <div class="text-xs font-mono text-slate-100">
                    ฿ {{ number_format($payment->amount, 2) }}
                </div>

                <div class="flex gap-2 pt-2">
                    {{-- Approve --}}
                    <form class="flex-1"
                          method="POST"
                          action="{{ route('admin.payments.approve', $payment) }}"
                          onsubmit="return confirm('ยืนยันการอนุมัติสมาชิกคนนี้ใช่ไหม?');">
                        @csrf
                        <button class="w-full rounded-lg bg-emerald-500/90 text-slate-900 py-2 text-xs font-semibold hover:bg-emerald-400">
                            อนุมัติ
                        </button>
                    </form>

                    {{-- Reject --}}
                    <form class="flex-1"
                          method="POST"
                          action="{{ route('admin.payments.reject', $payment) }}"
                          onsubmit="return confirm('ต้องการปฏิเสธคำขอนี้ใช่ไหม?');">
                        @csrf
                        <input type="hidden" name="reason" value="Rejected by admin">
                        <button class="w-full rounded-lg border border-red-500/70 text-red-200 py-2 text-xs hover:bg-red-500/10">
                            ปฏิเสธ
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <p class="text-sm text-slate-500">ยังไม่มีคำขอใหม่</p>
        @endforelse
    </div>


    {{-- ======================================
        RECENT — Desktop/Mobile ใช้เหมือนเดิม
    ======================================= --}}
    <div class="rounded-2xl bg-slate-900/80 border border-slate-800 p-4">
        <h2 class="text-sm font-semibold text-slate-100 mb-3">
            ประวัติการจัดการล่าสุด
        </h2>

        @if($recentPayments->isEmpty())
            <p class="text-sm text-slate-500">ยังไม่มีประวัติการจัดการ</p>
        @else
            <div class="space-y-2 text-xs">

                @foreach($recentPayments as $payment)
                    <div class="flex items-center justify-between rounded-xl bg-slate-900 border border-slate-800 px-3 py-2">

                        <div>
                            <p class="text-slate-100">
                                {{ $payment->user->name ?? '-' }}
                                <span class="text-slate-500">
                                    ({{ $payment->reference ?? '-' }})
                                </span>
                            </p>

                            <p class="text-[11px] text-slate-500">
                                สถานะ:
                                @if($payment->status === 'approved')
                                    <span class="text-emerald-300">อนุมัติ</span>
                                @elseif($payment->status === 'rejected')
                                    <span class="text-red-300">ปฏิเสธ</span>
                                @else
                                    <span class="text-slate-300">{{ $payment->status }}</span>
                                @endif
                                · {{ $payment->updated_at?->diffForHumans() }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="font-mono text-slate-100">
                                {{ number_format($payment->amount, 2) }}
                            </p>
                            <p class="text-[11px] text-slate-500">
                                {{ $payment->channel ?? '-' }}
                            </p>
                        </div>

                    </div>
                @endforeach

            </div>
        @endif
    </div>

@endsection
