{{-- resources/views/admin/contents/_form.blade.php --}}
@csrf

{{-- Global Error Alert --}}
@if($errors->any())
    <div
        class="mb-8 rounded-2xl border border-red-500/30 bg-red-500/10 px-6 py-4 text-sm text-red-200 shadow-[0_0_20px_rgba(239,68,68,0.15)] backdrop-blur-sm relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-red-500/10 to-transparent opacity-50"></div>
        <div class="relative flex items-center gap-3 font-bold text-red-100 mb-2 text-base">
            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-red-500/20 text-red-400">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            พบข้อผิดพลาด
        </div>
        <ul class="relative list-disc list-inside space-y-1 text-xs opacity-90 pl-11">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Main Glass Card Container --}}
<div
    class="rounded-3xl border border-slate-800 bg-slate-900/60 p-6 md:p-8 backdrop-blur-xl shadow-2xl shadow-black/50 relative overflow-hidden">
    {{-- Decorative Gradient Blob --}}
    <div class="absolute -top-24 -right-24 w-64 h-64 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="space-y-8 relative">

        {{-- Section: General Info --}}
        <div class="space-y-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="h-8 w-1 bg-gradient-to-b from-amber-400 to-amber-600 rounded-full"></div>
                <h3 class="text-lg font-bold text-slate-100 tracking-tight">ข้อมูลทั่วไป</h3>
            </div>

            {{-- บล็อก: ชื่อเรื่อง + Slug --}}
            <div class="grid gap-6 md:grid-cols-2">
                <div class="group">
                    <label
                        class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2 group-focus-within:text-amber-400 transition-colors">ชื่อเรื่อง</label>
                    <input type="text" name="title" value="{{ old('title', $content->title ?? '') }}"
                        class="w-full rounded-xl border border-slate-700/50 bg-slate-950/50 px-4 py-2.5 text-sm text-slate-100 placeholder-slate-600 shadow-inner transition-all duration-300 focus:border-amber-500/50 focus:bg-slate-900 focus:ring-4 focus:ring-amber-500/10 focus:outline-none @error('title') border-red-500/50 focus:border-red-500 focus:ring-red-500/10 @enderror"
                        placeholder="ใส่ชื่อเรื่องคอนเทนต์..." required>
                    @error('title')
                        <p class="mt-2 text-xs text-red-400 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="group">
                    <label
                        class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2 group-focus-within:text-amber-400 transition-colors">Slug
                        (URL)</label>
                    <input type="text" name="slug" value="{{ old('slug', $content->slug ?? '') }}"
                        class="w-full rounded-xl border border-slate-700/50 bg-slate-950/50 px-4 py-2.5 text-sm text-slate-100 placeholder-slate-600 shadow-inner transition-all duration-300 focus:border-amber-500/50 focus:bg-slate-900 focus:ring-4 focus:ring-amber-500/10 focus:outline-none font-mono text-xs @error('slug') border-red-500/50 focus:border-red-500 focus:ring-red-500/10 @enderror"
                        placeholder="auto-generated-slug" required>
                    @error('slug')
                        <p class="mt-2 text-xs text-red-400 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- บล็อก: ประเภท + หมวดหมู่ --}}
            <div class="grid gap-6 md:grid-cols-2">
                <div class="group">
                    <label
                        class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2 group-focus-within:text-amber-400 transition-colors">ประเภทคอนเทนต์</label>
                    <div class="relative">
                        <select name="type"
                            class="w-full appearance-none rounded-xl border border-slate-700/50 bg-slate-950/50 px-4 py-2.5 text-sm text-slate-100 shadow-inner transition-all duration-300 focus:border-amber-500/50 focus:bg-slate-900 focus:ring-4 focus:ring-amber-500/10 focus:outline-none cursor-pointer">
                            <option value="article" @selected(old('type', $content->type ?? 'article') === 'article')>
                                บทความ (Article)</option>
                            <option value="video" @selected(old('type', $content->type ?? '') === 'video')>วิดีโอ (Video)
                            </option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    @error('type')
                        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="group">
                    <label
                        class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2 group-focus-within:text-amber-400 transition-colors">หมวดหมู่</label>
                    <div class="relative">
                        <select name="category_id"
                            class="w-full appearance-none rounded-xl border border-slate-700/50 bg-slate-950/50 px-4 py-2.5 text-sm text-slate-100 shadow-inner transition-all duration-300 focus:border-amber-500/50 focus:bg-slate-900 focus:ring-4 focus:ring-amber-500/10 focus:outline-none cursor-pointer">
                            <option value="">-- ไม่ระบุ --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $content->category_id ?? null) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    @error('category_id')
                        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- บล็อก: แท็ก (เต็มแถว) --}}
            <div class="group">
                <div class="flex items-center justify-between mb-2">
                    <label
                        class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 group-focus-within:text-amber-400 transition-colors">
                        แท็ก (Tags)
                    </label>
                    <button type="button" id="tag-clear-all"
                        class="inline-flex items-center gap-1 rounded-lg border border-slate-700/50 bg-slate-800/50 px-2 py-1 text-[10px] font-medium text-slate-400 transition-all hover:bg-slate-700 hover:text-white hover:border-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-3 h-3">
                            <path
                                d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z" />
                        </svg>
                        ล้างทั้งหมด
                    </button>
                </div>

                <div class="relative w-full rounded-xl border border-slate-700/50 bg-slate-950/50 px-3 py-2 text-sm text-slate-100 shadow-inner transition-all duration-300 focus-within:border-amber-500/50 focus-within:bg-slate-900 focus-within:ring-4 focus-within:ring-amber-500/10"
                    data-tag-selector data-all-tags='@json($tags->map(fn($t) => ["id" => $t->id, "name" => $t->name]))'
                    data-selected-tags='@json(old("tags", $selectedTags ?? []))'
                    data-old-new-tags='@json(old("new_tags", []))'>

                    {{-- chips + input --}}
                    <div class="flex flex-wrap gap-2 items-center min-h-[38px]" id="tag-chips">
                        {{-- chips ที่ JS จะใส่มาให้ --}}
                        <input type="text"
                            class="flex-1 bg-transparent border-none focus:ring-0 focus:outline-none text-sm py-1 placeholder-slate-600"
                            placeholder="พิมพ์ชื่อแท็ก..." id="tag-input">
                    </div>

                    {{-- dropdown suggestion --}}
                    <ul id="tag-suggestions"
                        class="absolute left-0 right-0 top-full mt-2 max-h-48 overflow-auto rounded-xl border border-slate-700 bg-slate-900/95 backdrop-blur-xl text-xs shadow-2xl z-50 hidden custom-scrollbar">
                    </ul>

                    {{-- hidden input ไว้ส่งค่าไป controller --}}
                    <div id="tag-hidden-inputs"></div>
                </div>
                <p class="mt-2 text-[10px] text-slate-500 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                        class="w-3 h-3 opacity-50">
                        <path fill-rule="evenodd"
                            d="M15 8A7 7 0 1 1 1 8a7 7 0 0 1 14 0ZM9 5a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM6.75 8a.75.75 0 0 0 0 1.5h.75v1.75a.75.75 0 0 0 1.5 0v-2.5A.75.75 0 0 0 8.25 8h-1.5Z"
                            clip-rule="evenodd" />
                    </svg>
                    พิมพ์เพื่อค้นหา หรือกด Enter เพื่อสร้างใหม่
                </p>
            </div>

            {{-- บล็อก: Teaser --}}
            <div class="group">
                <label
                    class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2 group-focus-within:text-amber-400 transition-colors">Teaser
                    / คำโปรย</label>
                <textarea name="teaser" rows="3"
                    class="w-full rounded-xl border border-slate-700/50 bg-slate-950/50 px-4 py-3 text-sm text-slate-100 placeholder-slate-600 shadow-inner transition-all duration-300 focus:border-amber-500/50 focus:bg-slate-900 focus:ring-4 focus:ring-amber-500/10 focus:outline-none resize-none @error('teaser') border-red-500/50 focus:border-red-500 focus:ring-red-500/10 @enderror"
                    placeholder="เขียนคำโปรยสั้นๆ เพื่อดึงดูดความสนใจ...">{{ old('teaser', $content->teaser ?? '') }}</textarea>
                @error('teaser')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="h-px bg-slate-800/50"></div>

        {{-- Section: Content Body --}}
        <div class="space-y-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="h-8 w-1 bg-gradient-to-b from-indigo-400 to-indigo-600 rounded-full"></div>
                <h3 class="text-lg font-bold text-slate-100 tracking-tight">เนื้อหาหลัก</h3>
            </div>

            {{-- บล็อก: BODY + QUILL WYSIWYG --}}
            <div class="group">
                <div class="flex items-center justify-between mb-2">
                    <label
                        class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 group-focus-within:text-indigo-400 transition-colors">
                        เนื้อหา (Body)
                    </label>
                    <span
                        class="text-[10px] font-medium px-2 py-0.5 rounded bg-slate-800 text-slate-400 border border-slate-700/50">
                        Rich Text Editor
                    </span>
                </div>

                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror

                {{-- Hidden Input for Form Submission --}}
                <input type="hidden" name="body" id="body-input">
            </div>
        </div>

        <div class="h-px bg-slate-800/50"></div>

        {{-- Section: Media --}}
        <div class="space-y-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="h-8 w-1 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full"></div>
                <h3 class="text-lg font-bold text-slate-100 tracking-tight">สื่อประกอบ (Media)</h3>
            </div>

            {{-- บล็อก: รูปหน้าปก + วิดีโอ --}}
            <div class="grid gap-6 md:grid-cols-2">
                {{-- รูปหน้าปก / Thumbnail --}}
                <div class="group">
                    <div class="flex items-center justify-between mb-2">
                        <label
                            class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 group-focus-within:text-emerald-400 transition-colors">
                            รูปหน้าปก (Thumbnail)
                        </label>
                        <span class="text-[10px] text-slate-500">16:9 (1280x720)</span>
                    </div>

                    <div
                        class="rounded-2xl border-2 border-dashed border-slate-700/50 bg-slate-900/30 p-4 transition-all hover:border-emerald-500/30 hover:bg-slate-800/50 @error('thumbnail_file') border-red-500/50 @enderror">
                        {{-- Preview รูปเดิมหรือ placeholder --}}
                        <div
                            class="aspect-video rounded-xl overflow-hidden border border-slate-800 bg-slate-950 relative group/preview shadow-lg">
                            @if(!empty($content->thumbnail_url))
                                <img src="{{ $content->thumbnail_url }}" alt="Thumbnail preview" id="thumbnail-preview"
                                    class="h-full w-full object-cover transition-transform duration-700 group-hover/preview:scale-105">
                            @else
                                <img src="" alt="Thumbnail preview" id="thumbnail-preview"
                                    class="hidden h-full w-full object-cover transition-transform duration-700 group-hover/preview:scale-105">
                                <div id="thumbnail-placeholder"
                                    class="absolute inset-0 flex flex-col items-center justify-center text-slate-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-12 h-12 mb-2 opacity-50">
                                        <path fill-rule="evenodd"
                                            d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs font-medium">ไม่มีรูปภาพ</span>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4">
                            <input type="file" name="thumbnail_file" id="thumbnail-input" accept="image/*" class="block w-full text-xs text-slate-400
                                file:mr-3 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-xs file:font-bold
                                file:bg-slate-800 file:text-slate-300
                                file:transition-colors
                                hover:file:bg-emerald-600 hover:file:text-white
                                cursor-pointer
                            " />
                            <p class="mt-2 text-[10px] text-slate-500">
                                รองรับ JPG, PNG (Max 5MB)
                            </p>
                        </div>
                    </div>
                    @error('thumbnail_file')
                        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- วิดีโอ: YouTube URL / Upload ไฟล์ --}}
                <div class="group">
                    <div class="flex items-center justify-between mb-2">
                        <label
                            class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 group-focus-within:text-emerald-400 transition-colors">
                            วิดีโอ (Video Source)
                        </label>
                    </div>

                    <div class="rounded-2xl border border-slate-700/50 bg-slate-900/30 p-4 space-y-4">
                        {{-- ตัวเลือก: YouTube / Upload --}}
                        <div class="flex items-center gap-6 p-1">
                            <label class="inline-flex items-center cursor-pointer group/radio">
                                <input type="radio" name="video_source" value="youtube"
                                    class="form-radio text-emerald-500 focus:ring-emerald-500 bg-slate-900 border-slate-600"
                                    @checked(old('video_source', $content->video_url && !str_starts_with($content->video_url, '/storage') ? 'youtube' : 'youtube') === 'youtube')>
                                <span
                                    class="ml-2 text-sm text-slate-300 group-hover/radio:text-white transition-colors">YouTube
                                    URL</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer group/radio">
                                <input type="radio" name="video_source" value="file"
                                    class="form-radio text-emerald-500 focus:ring-emerald-500 bg-slate-900 border-slate-600"
                                    @checked(old('video_source', $content->video_url && str_starts_with($content->video_url, '/storage') ? 'file' : '') === 'file')>
                                <span
                                    class="ml-2 text-sm text-slate-300 group-hover/radio:text-white transition-colors">อัปโหลดไฟล์</span>
                            </label>
                        </div>

                        {{-- ช่องกรอก YouTube URL --}}
                        <div id="video-source-youtube"
                            class="space-y-3 {{ old('video_source', $content->video_url && !str_starts_with($content->video_url, '/storage') ? 'youtube' : 'youtube') === 'youtube' ? '' : 'hidden' }}">
                            <div>
                                <input type="text" name="video_url" id="video-url-input"
                                    value="{{ old('video_url', ($content->video_url && !str_starts_with($content->video_url, '/storage')) ? $content->video_url : '') }}"
                                    placeholder="วางลิงก์ YouTube ที่นี่..."
                                    class="w-full rounded-xl border border-slate-700/50 bg-slate-950/50 px-4 py-2.5 text-sm text-slate-100 placeholder-slate-600 shadow-inner transition-all duration-300 focus:border-emerald-500/50 focus:bg-slate-900 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none @error('video_url') border-red-500/50 @enderror">
                                @error('video_url')
                                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="video-thumb-preview-wrapper" class="hidden">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">
                                    ตัวอย่าง YouTube Thumbnail
                                </p>
                                <div
                                    class="aspect-video rounded-xl overflow-hidden border border-slate-800 bg-slate-950 shadow-lg">
                                    <img id="video-thumb-preview" src="" alt="Video thumbnail"
                                        class="h-full w-full object-cover">
                                </div>
                            </div>
                        </div>

                        {{-- ช่องอัปโหลดไฟล์ --}}
                        <div id="video-source-file"
                            class="space-y-3 {{ old('video_source', $content->video_url && str_starts_with($content->video_url, '/storage') ? 'file' : '') === 'file' ? '' : 'hidden' }}">
                            <div
                                class="rounded-xl border-2 border-dashed border-slate-700/50 bg-slate-950/30 p-4 text-center hover:bg-slate-900/50 transition-colors">
                                <input type="file" name="video_file" id="video-file-input" accept="video/mp4,video/webm"
                                    class="block w-full text-xs text-slate-400
                                    file:mr-3 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-xs file:font-bold
                                    file:bg-slate-800 file:text-slate-300
                                    file:transition-colors
                                    hover:file:bg-emerald-600 hover:file:text-white
                                    cursor-pointer
                                " />
                                <p class="mt-2 text-[10px] text-slate-500">
                                    MP4, WebM (Max 50MB)
                                </p>
                            </div>

                            @if($content->video_url && str_starts_with($content->video_url, '/storage'))
                                <div
                                    class="rounded-lg bg-emerald-500/10 border border-emerald-500/20 p-3 flex items-center gap-3">
                                    <div class="p-2 bg-emerald-500/20 rounded-full text-emerald-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-4 h-4">
                                            <path
                                                d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-medium text-emerald-200 truncate">มีไฟล์วิดีโอเดิมอยู่แล้ว
                                        </p>
                                        <a href="{{ $content->video_url }}" target="_blank"
                                            class="text-[10px] text-emerald-400 hover:underline">คลิกเพื่อเปิดดู</a>
                                    </div>
                                </div>
                            @endif
                            @error('video_file')
                                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    /* Custom Scrollbar for Suggestions */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #0f172a;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #334155;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #475569;
    }

    /* Quill Dark Mode Premium Overrides */
    .ql-toolbar.ql-snow {
        border: none !important;
        background-color: rgba(15, 23, 42, 0.5);
        /* slate-900/50 */
        color: #e2e8f0;
        border-radius: 0.75rem 0.75rem 0 0;
        padding: 12px 16px !important;
        border-bottom: 1px solid rgba(51, 65, 85, 0.5) !important;
        /* slate-700/50 */
        backdrop-filter: blur(8px);
    }

    .ql-container.ql-snow {
        border: none !important;
        background-color: rgba(2, 6, 23, 0.3);
        /* slate-950/30 */
        color: #f8fafc;
        font-family: 'Kanit', sans-serif;
        font-size: 1rem;
        border-radius: 0 0 0.75rem 0.75rem;
        min-height: 500px;
    }

    /* Icons & Buttons */
    .ql-snow .ql-stroke {
        stroke: #94a3b8 !important;
        transition: stroke 0.2s ease;
    }

    .ql-snow .ql-fill {
        fill: #94a3b8 !important;
        transition: fill 0.2s ease;
    }

    /* Hover & Active States */
    .ql-snow .ql-toolbar button:hover .ql-stroke,
    .ql-snow .ql-toolbar button.ql-active .ql-stroke,
    .ql-snow .ql-picker-label:hover .ql-stroke,
    .ql-snow .ql-picker-label.ql-active .ql-stroke {
        stroke: #818cf8 !important;
        /* indigo-400 */
    }

    .ql-snow .ql-toolbar button:hover .ql-fill,
    .ql-snow .ql-toolbar button.ql-active .ql-fill,
    .ql-snow .ql-picker-label:hover .ql-fill,

    /* Editor Content */
    .ql-editor {
        padding: 2rem;
        line-height: 1.8;
    }

    .ql-editor.ql-blank::before {
        color: #64748b !important;
        font-style: normal;
        opacity: 0.7;
    }
</style>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // =========================
            // AUTO SLUG GENERATION
            // =========================
            const titleInput = document.querySelector('input[name="title"]');
            const slugInput = document.querySelector('input[name="slug"]');
            const isCreate = @json(!$content->exists);

            if (titleInput && slugInput && isCreate) {
                slugInput.addEventListener('input', function () {
                    slugInput.dataset.manuallyChanged = 'true';
                });

                titleInput.addEventListener('input', function () {
                    if (slugInput.dataset.manuallyChanged === 'true') return;
                    let val = titleInput.value;
                    let slug = val.toLowerCase()
                        .replace(/\s+/g, '-')
                        .replace(/[^\w\u0E00-\u0E7F\-]/g, '')
                        .replace(/\-\-+/g, '-')
                        .replace(/^-+/, '')
                        .replace(/-+$/, '');
                    slugInput.value = slug;
                });
            }

            // =========================
            // PREVENT DOUBLE SUBMIT
            // =========================
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function (e) {
                    if (form.dataset.submitting === 'true') {
                        e.preventDefault();
                        return;
                    }
                    const btn = form.querySelector('button[type="submit"]');
                    if (btn) {
                        form.dataset.submitting = 'true';
                        btn.disabled = true;
                        const originalText = btn.innerHTML;
                        btn.innerHTML = `
                                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                กำลังบันทึก...
                                            `;
                        btn.classList.add('opacity-75', 'cursor-not-allowed');
                    }
                });
            }

            // =========================
            // TAG AUTOCOMPLETE + CHIPS
            // =========================
            const container = document.querySelector('[data-tag-selector]');
            if (container) {
                const allTags = JSON.parse(container.dataset.allTags || '[]');
                const selectedIdsFromServer = JSON.parse(container.dataset.selectedTags || '[]');
                const oldNewTags = JSON.parse(container.dataset.oldNewTags || '[]');

                const chipsContainer = container.querySelector('#tag-chips');
                const input = container.querySelector('#tag-input');
                const suggestions = container.querySelector('#tag-suggestions');
                const hiddenInputs = container.querySelector('#tag-hidden-inputs');
                const clearBtn = document.getElementById('tag-clear-all');

                let selectedExistingIds = [...selectedIdsFromServer];
                let selectedNewNames = [...oldNewTags];

                function renderHiddenInputs() {
                    hiddenInputs.innerHTML = '';
                    selectedExistingIds.forEach(id => {
                        const inputHidden = document.createElement('input');
                        inputHidden.type = 'hidden';
                        inputHidden.name = 'tags[]';
                        inputHidden.value = id;
                        hiddenInputs.appendChild(inputHidden);
                    });
                    selectedNewNames.forEach(name => {
                        const inputHidden = document.createElement('input');
                        inputHidden.type = 'hidden';
                        inputHidden.name = 'new_tags[]';
                        inputHidden.value = name;
                        hiddenInputs.appendChild(inputHidden);
                    });
                }

                function createChip(label, { type, value }) {
                    const chip = document.createElement('span');
                    chip.className = 'inline-flex items-center gap-1 rounded-lg bg-gradient-to-r from-slate-800 to-slate-700 border border-slate-600 px-2.5 py-1 text-xs text-slate-200 shadow-sm animate-fadeIn';
                    chip.dataset.type = type;
                    chip.dataset.value = value;
                    chip.innerHTML = `
                                            <span>${label}</span>
                                            <button type="button" class="ml-1 text-slate-400 hover:text-red-400 transition-colors focus:outline-none">&times;</button>
                                        `;
                    chip.querySelector('button').addEventListener('click', () => {
                        if (type === 'existing') {
                            selectedExistingIds = selectedExistingIds.filter(id => String(id) !== String(value));
                        } else {
                            selectedNewNames = selectedNewNames.filter(name => name !== value);
                        }
                        chip.remove();
                        renderHiddenInputs();
                        updateSuggestions();
                    });
                    chipsContainer.insertBefore(chip, input);
                }

                function initSelectedFromServer() {
                    selectedExistingIds.forEach(id => {
                        const tag = allTags.find(t => String(t.id) === String(id));
                        if (tag) {
                            createChip(tag.name, { type: 'existing', value: tag.id });
                        }
                    });
                    selectedNewNames.forEach(name => {
                        createChip(name, { type: 'new', value: name });
                    });
                    renderHiddenInputs();
                }

                function renderSuggestionList(list) {
                    suggestions.innerHTML = '';
                    if (!list.length) {
                        suggestions.classList.add('hidden');
                        return;
                    }
                    list.forEach(tag => {
                        const li = document.createElement('li');
                        li.className = 'px-4 py-2 hover:bg-slate-800 cursor-pointer flex justify-between items-center transition-colors';
                        li.innerHTML = `<span class="text-slate-200">${tag.name}</span><span class="text-[10px] text-slate-500 bg-slate-800 px-1.5 py-0.5 rounded border border-slate-700">เลือก</span>`;
                        li.addEventListener('click', () => {
                            addExistingTag(tag);
                        });
                        suggestions.appendChild(li);
                    });
                    suggestions.classList.remove('hidden');
                }

                function updateSuggestions() {
                    const query = input.value.trim().toLowerCase();
                    const usedIds = new Set(selectedExistingIds.map(id => String(id)));
                    let filtered = allTags.filter(tag => !usedIds.has(String(tag.id)));
                    if (query) {
                        filtered = filtered.filter(tag => tag.name.toLowerCase().includes(query));
                    }
                    renderSuggestionList(filtered);
                }

                function addExistingTag(tag) {
                    if (selectedExistingIds.includes(tag.id)) return;
                    selectedExistingIds.push(tag.id);
                    createChip(tag.name, { type: 'existing', value: tag.id });
                    input.value = '';
                    renderHiddenInputs();
                    updateSuggestions();
                }

                function addNewTag(name) {
                    name = name.trim();
                    if (!name) return;
                    const existing = allTags.find(t => t.name.toLowerCase() === name.toLowerCase());
                    if (existing) {
                        addExistingTag(existing);
                        return;
                    }
                    if (selectedNewNames.some(n => n.toLowerCase() === name.toLowerCase())) {
                        input.value = '';
                        return;
                    }
                    selectedNewNames.push(name);
                    createChip(name, { type: 'new', value: name });
                    input.value = '';
                    renderHiddenInputs();
                    updateSuggestions();
                }

                function clearAllTags() {
                    selectedExistingIds = [];
                    selectedNewNames = [];
                    chipsContainer.querySelectorAll('span[data-type]').forEach(chip => chip.remove());
                    input.value = '';
                    renderHiddenInputs();
                    updateSuggestions();
                }

                if (clearBtn) {
                    clearBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        clearAllTags();
                        input.focus();
                    });
                }

                input.addEventListener('input', () => updateSuggestions());
                input.addEventListener('focus', () => updateSuggestions());
                chipsContainer.addEventListener('click', () => {
                    input.focus();
                    updateSuggestions();
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ',') {
                        e.preventDefault();
                        const value = input.value.trim();
                        if (!value) return;
                        addNewTag(value);
                    } else if (e.key === 'Backspace' && input.value === '') {
                        const chips = chipsContainer.querySelectorAll('span[data-type]');
                        if (chips.length > 0) {
                            const lastChip = chips[chips.length - 1];
                            const type = lastChip.dataset.type;
                            const value = lastChip.dataset.value;
                            if (type === 'existing') {
                                selectedExistingIds = selectedExistingIds.filter(id => String(id) !== String(value));
                            } else {
                                selectedNewNames = selectedNewNames.filter(name => name !== value);
                            }
                            lastChip.remove();
                            renderHiddenInputs();
                            updateSuggestions();
                        }
                    }
                });

                document.addEventListener('click', (e) => {
                    if (!container.contains(e.target)) {
                        suggestions.classList.add('hidden');
                    }
                });

                initSelectedFromServer();
            }

            // =========================
            // QUILL EDITOR SETUP
            // =========================
            if (document.getElementById('editor-container')) {
                const quill = new Quill('#editor-container', {
                    theme: 'snow',
                    placeholder: 'เริ่มเขียนเนื้อหาของคุณที่นี่...',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, false] }],
                            [{ 'size': ['small', false, 'large', 'huge'] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                            [{ 'color': [] }, { 'background': [] }],
                            ['link', 'image', 'video'],
                            ['clean']
                        ]
                    }
                });

                // Sync content to hidden input on form submit
                const editorContainer = document.getElementById('editor-container');
                const form = editorContainer ? editorContainer.closest('form') : null;
                const bodyInput = document.getElementById('body-input');

                if (form && bodyInput) {
                    form.addEventListener('submit', function () {
                        if (quill.getText().trim().length === 0 && !quill.root.innerHTML.includes('<img')) {
                            bodyInput.value = '';
                        } else {
                            bodyInput.value = quill.root.innerHTML;
                        }
                    });
                }
            }

            // =========================
            // THUMBNAIL IMAGE PREVIEW
            // =========================
            const thumbnailInput = document.getElementById('thumbnail-input');
            const thumbnailPreview = document.getElementById('thumbnail-preview');
            const thumbnailPlaceholder = document.getElementById('thumbnail-placeholder');

            if (thumbnailInput && thumbnailPreview) {
                thumbnailInput.addEventListener('change', function () {
                    const file = this.files && this.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        thumbnailPreview.src = e.target.result;
                        thumbnailPreview.classList.remove('hidden');
                        if (thumbnailPlaceholder) {
                            thumbnailPlaceholder.classList.add('hidden');
                        }
                    };
                    reader.readAsDataURL(file);
                });
            }

            // =========================
            // VIDEO URL → AUTO YOUTUBE THUMBNAIL PREVIEW
            // =========================
            const videoUrlInput = document.getElementById('video-url-input');
            const videoThumbWrapper = document.getElementById('video-thumb-preview-wrapper');
            const videoThumbImg = document.getElementById('video-thumb-preview');

            function updateYoutubeThumbPreview() {
                if (!videoUrlInput || !videoThumbImg) return;
                const value = videoUrlInput.value.trim();
                let videoId = '';
                try {
                    const url = new URL(value);
                    if (url.hostname.includes('youtu.be')) {
                        videoId = url.pathname.replace('/', '');
                    } else if (url.hostname.includes('youtube.com')) {
                        videoId = url.searchParams.get('v') || '';
                    }
                } catch (e) {
                    videoId = '';
                }

                if (videoId) {
                    const thumbUrl = `https://i.ytimg.com/vi/${videoId}/hqdefault.jpg`;
                    videoThumbImg.src = thumbUrl;
                    if (videoThumbWrapper) videoThumbWrapper.classList.remove('hidden');
                } else {
                    videoThumbImg.src = '';
                    if (videoThumbWrapper) videoThumbWrapper.classList.add('hidden');
                }
            }

            if (videoUrlInput) {
                videoUrlInput.addEventListener('change', updateYoutubeThumbPreview);
                videoUrlInput.addEventListener('blur', updateYoutubeThumbPreview);
                videoUrlInput.addEventListener('keyup', function () {
                    // Debounce slightly if needed, but keyup is fine for immediate feedback
                    updateYoutubeThumbPreview();
                });
                // Initial check
                updateYoutubeThumbPreview();
            }

            // =========================
            // TOGGLE VIDEO SOURCE
            // =========================
            const radioButtons = document.querySelectorAll('input[name="video_source"]');
            const youtubeSection = document.getElementById('video-source-youtube');
            const fileSection = document.getElementById('video-source-file');

            radioButtons.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === 'youtube') {
                        youtubeSection.classList.remove('hidden');
                        fileSection.classList.add('hidden');
                    } else {
                        youtubeSection.classList.add('hidden');
                        fileSection.classList.remove('hidden');
                    }
                });
            });
        });
    </script>
@endpush