{{-- resources/views/admin/contents/create.blade.php --}}
@extends('admin.layout')

@section('title', 'สร้างคอนเทนต์ใหม่ · Exclusive')
@section('page-title', 'สร้างคอนเทนต์ใหม่')

@section('content')
    <form method="POST" action="{{ route('admin.contents.store') }}" class="space-y-4 max-w-4xl"
        enctype="multipart/form-data">
        @include('admin.contents._form')

        <div class="flex justify-end gap-3 mt-6 border-t border-slate-800 pt-6">
            <a href="{{ route('admin.contents.index') }}"
                class="group relative inline-flex items-center gap-2 rounded-xl border border-slate-700 bg-slate-800/50 px-5 py-2.5 text-xs font-medium text-slate-300 transition-all duration-300 hover:bg-slate-700 hover:text-white hover:border-slate-600 hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                    class="w-4 h-4 transition-transform group-hover:-translate-x-1">
                    <path fill-rule="evenodd"
                        d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z"
                        clip-rule="evenodd" />
                </svg>
                ยกเลิก
            </a>
            <button type="submit"
                class="group relative inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 px-6 py-2.5 text-xs font-bold text-slate-900 shadow-[0_0_15px_rgba(245,158,11,0.3)] transition-all duration-300 hover:shadow-[0_0_25px_rgba(245,158,11,0.5)] hover:-translate-y-0.5 hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                    class="w-4 h-4 transition-transform group-hover:scale-110">
                    <path fill-rule="evenodd"
                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                        clip-rule="evenodd" />
                </svg>
                บันทึกคอนเทนต์
            </button>
        </div>
    </form>
@endsection