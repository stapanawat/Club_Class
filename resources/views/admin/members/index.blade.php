@extends('admin.layout')

@section('title', 'จัดการสมาชิก · Exclusive')
@section('page-title', 'จัดการสมาชิก')
@section('page-subtitle', 'ดูสถานะสมาชิก อนุมัติ / ปฏิเสธคำขอเข้าระบบ')

@section('content')
<div class="grid gap-6 md:grid-cols-2">

    {{-- Pending --}}
    <div class="rounded-2xl border border-slate-800 bg-slate-900/80">
        <div class="px-4 py-3 border-b border-slate-800 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-amber-300">คำขอสมัครสมาชิกที่รออนุมัติ</h3>
                <p class="text-xs text-slate-500">สมาชิกที่ชำระเงินแล้ว แต่ยัง pending</p>
            </div>
            <span class="text-xs text-slate-400">
                {{ $pendingMembers->count() ?? 0 }} รายการ
            </span>
        </div>

        <div class="divide-y divide-slate-800 text-sm">
            @forelse($pendingMembers as $user)
                <div class="px-4 py-3 flex items-center justify-between gap-3">
                    <div>
                        <p class="font-medium text-slate-100">{{ $user->name }}</p>
                        <p class="text-xs text-slate-400">{{ $user->email }}</p>
                        <p class="text-[11px] text-slate-500 mt-1">
                            สมัครเมื่อ {{ $user->created_at?->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    <div class="flex flex-col items-end gap-1 text-xs">
                        <form method="POST" action="{{ route('admin.members.approve', $user) }}">
                            @csrf
                            <button type="submit"
                                    class="rounded-lg bg-emerald-500/90 px-3 py-1 text-slate-900 font-semibold hover:bg-emerald-400">
                                อนุมัติ
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.members.reject', $user) }}"
                              onsubmit="return confirm('ปฏิเสธสมาชิกคนนี้?');">
                            @csrf
                            <button type="submit"
                                    class="rounded-lg border border-red-500/60 px-3 py-1 text-red-300 hover:bg-red-500/10">
                                ปฏิเสธ
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="px-4 py-4 text-sm text-slate-500">
                    ยังไม่มีคำขอสมาชิกที่รออนุมัติ
                </p>
            @endforelse
        </div>
    </div>

    {{-- Active --}}
    <div class="rounded-2xl border border-slate-800 bg-slate-900/80">
        <div class="px-4 py-3 border-b border-slate-800 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-slate-100">สมาชิกที่ใช้งานอยู่ (Active)</h3>
                <p class="text-xs text-slate-500">สมาชิกที่สามารถเข้าถึงคอนเทนต์ Exclusive ได้</p>
            </div>
            <span class="text-xs text-slate-400">
                {{ $activeMembers->count() ?? 0 }} รายการ
            </span>
        </div>

        <div class="max-h-[420px] overflow-auto divide-y divide-slate-800 text-sm">
            @forelse($activeMembers as $user)
                <div class="px-4 py-3 flex items-center justify-between gap-3">
                    <div>
                        <p class="font-medium text-slate-100">{{ $user->name }}</p>
                        <p class="text-xs text-slate-400">{{ $user->email }}</p>
                        <p class="text-[11px] text-slate-500 mt-1">
                            สถานะ: <span class="text-emerald-400">Active</span>
                        </p>
                    </div>
                    <div class="text-right text-[11px] text-slate-500">
                        เริ่มเป็นสมาชิกเมื่อ<br>
                        {{ $user->updated_at?->format('d/m/Y') }}
                    </div>
                </div>
            @empty
                <p class="px-4 py-4 text-sm text-slate-500">
                    ยังไม่มีสมาชิกที่ active
                </p>
            @endforelse
        </div>
    </div>

</div>
@endsection
