@extends('admin.layout')

@section('content')
<div class="max-w-4xl mx-auto py-8 text-slate-100">
    <h1 class="text-2xl font-semibold mb-4">สร้างเนื้อหาใหม่</h1>

    <form method="POST" action="{{ route('admin.contents.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Title</label>
            <input name="title" class="w-full px-3 py-2 rounded bg-slate-900 border border-slate-700">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Teaser</label>
            <textarea name="teaser" class="w-full px-3 py-2 rounded bg-slate-900 border border-slate-700"></textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Body</label>
            <textarea id="editor" name="body"></textarea>
        </div>

        <button class="px-4 py-2 rounded bg-amber-500 text-slate-900 font-semibold">
            บันทึก
        </button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#editor',
    height: 500,
    menubar: false,
    plugins: 'link image lists code',
    toolbar: 'undo redo | bold italic underline | bullist numlist | link image | code',
});
</script>
@endsection
