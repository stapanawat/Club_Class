@extends('admin.layout')

@section('title', 'จัดการแท็ก · Exclusive')
@section('page-title', 'จัดการแท็ก (Tags)')
@section('page-subtitle', 'ใช้แท็กในการจัดกลุ่มคอนเทนต์แบบยืดหยุ่น')

@section('content')
    <div class="flex items-center justify-between mb-4 gap-3">
        <div>
            <h2 class="text-sm font-semibold text-slate-100">แท็กทั้งหมด</h2>
            @if(!empty($q))
                <p class="text-xs text-slate-400 mt-1">
                    ค้นหา: <span class="font-semibold text-amber-300">{{ $q }}</span>
                </p>
            @endif
        </div>

        <form method="GET" action="{{ route('admin.tags.index') }}" class="flex items-center gap-2">
            <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="ค้นหา name / slug..."
                class="rounded-xl border border-slate-700 bg-slate-950 px-3 py-1.5 text-xs text-slate-100 w-56">
            <button type="submit"
                class="group relative inline-flex items-center gap-2 rounded-xl bg-slate-800/50 border border-slate-700/50 px-4 py-2 text-xs font-medium text-slate-300 transition-all duration-300 hover:bg-slate-700 hover:text-white hover:shadow-[0_0_15px_rgba(255,255,255,0.1)]">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                    class="w-4 h-4 transition-transform group-hover:scale-110">
                    <path fill-rule="evenodd"
                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                        clip-rule="evenodd" />
                </svg>
                ค้นหา
            </button>
        </form>
    </div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-semibold text-slate-100">รายการแท็ก</h3>
        <a href="{{ route('admin.tags.create') }}"
            class="group relative inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 px-5 py-2.5 text-xs font-bold text-slate-900 shadow-[0_0_15px_rgba(245,158,11,0.3)] transition-all duration-300 hover:shadow-[0_0_25px_rgba(245,158,11,0.5)] hover:-translate-y-0.5 hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                class="w-4 h-4 transition-transform group-hover:rotate-90">
                <path
                    d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
            </svg>
            สร้างแท็กใหม่
        </a>
    </div>

    <div class="rounded-2xl border border-slate-800 bg-slate-900/80 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-900/90 text-xs uppercase text-slate-400">
                <tr>
                    <th class="px-4 py-2 text-left">ชื่อแท็ก</th>
                    <th class="px-4 py-2 text-left">Slug</th>
                    <th class="px-4 py-2 text-right">จัดการ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($tags as $tag)
                    <tr>
                        <td class="px-4 py-2">
                            <div class="font-medium text-slate-100">{{ $tag->name }}</div>
                        </td>
                        <td class="px-4 py-2 text-xs text-slate-400">
                            {{ $tag->slug }}
                        </td>
                        <td class="px-4 py-2">
                            <div class="flex justify-end gap-2 text-xs">
                                <a href="{{ route('admin.tags.edit', $tag) }}"
                                    class="group/edit inline-flex justify-center items-center gap-2 rounded-xl border border-slate-700 bg-slate-800/50 px-3 py-2 text-slate-300 transition-all duration-300 hover:bg-slate-700 hover:text-white hover:border-slate-600 hover:shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-3.5 h-3.5 transition-transform group-hover/edit:-translate-y-0.5 group-hover/edit:translate-x-0.5">
                                        <path
                                            d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                        <path
                                            d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}"
                                    onsubmit="return confirm('ยืนยันการลบแท็กนี้?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="group/delete inline-flex justify-center items-center gap-2 rounded-xl border border-red-500/30 bg-red-500/5 px-3 py-2 text-red-400 transition-all duration-300 hover:bg-red-500/20 hover:text-red-300 hover:border-red-500/50 hover:shadow-[0_0_15px_rgba(239,68,68,0.2)]">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-3.5 h-3.5 transition-transform group-hover/delete:scale-110">
                                            <path fill-rule="evenodd"
                                                d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-6 text-center text-sm text-slate-500">
                            ยังไม่มีแท็กในระบบ
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($tags, 'links'))
        <div class="mt-4">
            {{ $tags->links() }}
        </div>
    @endif
@endsection