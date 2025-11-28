@extends('admin.layout')

@section('title', 'แก้ไขแท็ก · Exclusive')
@section('page-title', 'แก้ไขแท็ก')

@section('content')
    <form method="POST" action="{{ route('admin.tags.update', $tag) }}" class="space-y-4 max-w-lg">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-medium text-slate-300 mb-1">ชื่อแท็ก</label>
            <input type="text" name="name" value="{{ old('name', $tag->name) }}"
                class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-100" required>
            @error('name')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-medium text-slate-300 mb-1">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $tag->slug) }}"
                class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-100">
            @error('slug')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-2 pt-2">
            <a href="{{ route('admin.tags.index') }}"
                class="group inline-flex items-center gap-2 rounded-xl border border-slate-700 px-4 py-2 text-xs text-slate-300 transition-all duration-300 hover:bg-slate-800 hover:text-white hover:border-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                    class="w-4 h-4 opacity-60 group-hover:opacity-100 transition-opacity">
                    <path fill-rule="evenodd"
                        d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z"
                        clip-rule="evenodd" />
                </svg>
                ยกเลิก
            </a>
            <button type="submit"
                class="group relative inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-400 to-emerald-600 px-6 py-2 text-xs font-bold text-slate-900 shadow-[0_0_15px_rgba(16,185,129,0.3)] transition-all duration-300 hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] hover:-translate-y-0.5 hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                    class="w-4 h-4 transition-transform group-hover:scale-110">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                        clip-rule="evenodd" />
                </svg>
                อัปเดตแท็ก
            </button>
        </div>
    </form>
@endsection