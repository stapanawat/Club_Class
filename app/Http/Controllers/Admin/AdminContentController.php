<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminContentController extends Controller
{
    // ============================
    // INDEX — แสดงรายการคอนเทนต์
    // ============================
    public function index(Request $request)
    {
        $q = $request->input('q');   // keyword จาก search bar

        $contents = Content::with('category', 'tags')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('teaser', 'like', "%{$q}%")
                        ->orWhere('body', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.contents.index', compact('contents', 'q'));
    }

    // ============================
    // CREATE — หน้าเพิ่มคอนเทนต์
    // ============================
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $selectedTags = [];

        $content = new Content();

        return view('admin.contents.create', compact(
            'categories',
            'tags',
            'selectedTags',
            'content'
        ));
    }

    // ============================
    // STORE — บันทึกข้อมูล
    // ============================
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:contents,slug',
            'type' => 'required|in:article,video',
            'teaser' => 'nullable|string',
            'body' => 'nullable|string',
            'video_url' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'thumbnail_file' => 'required|image|max:2048',
            'video_file' => 'nullable|mimetypes:video/mp4,video/webm|max:51200',

            'tags' => 'array',
            'tags.*' => 'exists:tags,id',

            'new_tags' => 'array',
            'new_tags.*' => 'string|max:50',
        ]);

        // excerpt
        $data['excerpt'] = $data['teaser']
            ?? Str::limit(strip_tags($data['body'] ?? ''), 120);

        // Upload Thumbnail
        if ($request->hasFile('thumbnail_file')) {
            $file = $request->file('thumbnail_file');
            if ($file->isValid()) {
                $filename = 'thumb_' . time() . '_' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();

                // Try storeAs first
                $path = $file->storeAs('contents/thumbnails', $filename, 'public');

                // Fallback if storeAs fails
                if (!$path) {
                    $path = 'contents/thumbnails/' . $filename;
                    \Illuminate\Support\Facades\Storage::disk('public')->put($path, file_get_contents($file));
                }

                $data['thumbnail_url'] = '/storage/' . $path;
            }
        }

        // Upload Video File
        if ($request->hasFile('video_file')) {
            $path = $request->file('video_file')->store('contents/videos', 'public');
            $data['video_url'] = '/storage/' . $path;
        }

        \Illuminate\Support\Facades\Log::info('Final Data before Create:', $data);

        // แยก data ของ Content กับ data ของแท็กออกจากกัน
        $contentData = $data;
        unset($contentData['tags'], $contentData['new_tags'], $contentData['thumbnail_file'], $contentData['video_file']);

        // สร้าง content
        $content = Content::create($contentData);

        // ========================
        // จัดการ tags + new_tags
        // ========================
        $tagIds = $data['tags'] ?? [];

        if (!empty($data['new_tags'])) {
            foreach ($data['new_tags'] as $tagName) {
                $tagName = trim($tagName);
                if ($tagName === '') {
                    continue;
                }

                // Fix: Str::slug() might return empty for Thai characters
                $slug = Str::slug($tagName);
                if (empty($slug)) {
                    $slug = str_replace(' ', '-', $tagName);
                }

                $tag = Tag::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $tagName]
                );

                $tagIds[] = $tag->id;
            }
        }

        $content->tags()->sync($tagIds);

        return redirect()->route('admin.contents.index')
            ->with('status', 'สร้างเนื้อหาใหม่เรียบร้อยแล้ว');
    }

    // ============================
    // EDIT — หน้าแก้ไข
    // ============================
    public function edit(Content $content)
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $selectedTags = $content->tags->pluck('id')->toArray();

        return view('admin.contents.edit', compact(
            'content',
            'categories',
            'tags',
            'selectedTags'
        ));
    }

    // ============================
    // UPDATE — บันทึกแก้ไข
    // ============================
    public function update(Request $request, $id)
    {
        $content = Content::findOrFail($id);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', \Illuminate\Validation\Rule::unique('contents', 'slug')->ignore($content->id)],
            'type' => ['required', 'in:article,video'],
            'teaser' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'video_url' => ['nullable', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'thumbnail_file' => ['nullable', 'image', 'max:2048'],
            'video_file' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm', 'max:51200'],

            'tags' => ['array'],
            'tags.*' => ['exists:tags,id'],

            'new_tags' => ['array'],
            'new_tags.*' => ['string', 'max:50'],
        ]);

        // excerpt update เสมอ
        $data['excerpt'] = $data['teaser']
            ?? Str::limit(strip_tags($data['body'] ?? ''), 120);

        // Upload Thumbnail
        if ($request->hasFile('thumbnail_file')) {
            $file = $request->file('thumbnail_file');
            if ($file->isValid()) {
                // Delete old thumbnail if exists
                if (!empty($content->thumbnail_url) && str_starts_with($content->thumbnail_url, '/storage/')) {
                    $oldPath = str_replace('/storage/', '', $content->thumbnail_url);
                    Storage::disk('public')->delete($oldPath);
                }

                $filename = 'thumb_' . time() . '_' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();

                // Try storeAs first
                $path = $file->storeAs('contents/thumbnails', $filename, 'public');

                // Fallback if storeAs fails
                if (!$path) {
                    $path = 'contents/thumbnails/' . $filename;
                    \Illuminate\Support\Facades\Storage::disk('public')->put($path, file_get_contents($file));
                }

                $data['thumbnail_url'] = '/storage/' . $path;
            }
        }

        // Upload Video File
        if ($request->hasFile('video_file')) {
            // ลบวิดีโอเก่าถ้ามี (เฉพาะถ้าเป็นไฟล์ ไม่ใช่ URL)
            if (!empty($content->video_url) && str_starts_with($content->video_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $content->video_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('video_file')->store('contents/videos', 'public');
            $data['video_url'] = '/storage/' . $path;
        } elseif ($request->input('video_source') === 'youtube' && $request->filled('video_url')) {
            // กรณีเปลี่ยนกลับมาใช้ YouTube URL และมีไฟล์เดิมอยู่ ให้ลบไฟล์เดิม
            if (!empty($content->video_url) && str_starts_with($content->video_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $content->video_url);
                Storage::disk('public')->delete($oldPath);
            }
        }

        $contentData = $data;
        unset($contentData['tags'], $contentData['new_tags'], $contentData['thumbnail_file'], $contentData['video_file']);

        $content->update($contentData);

        // ========================
        // จัดการ tags + new_tags
        // ========================
        $tagIds = $data['tags'] ?? [];

        if (!empty($data['new_tags'])) {
            foreach ($data['new_tags'] as $tagName) {
                $tagName = trim($tagName);
                if ($tagName === '') {
                    continue;
                }

                // Fix: Str::slug() might return empty for Thai characters
                $slug = Str::slug($tagName);
                if (empty($slug)) {
                    $slug = str_replace(' ', '-', $tagName);
                }

                $tag = Tag::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $tagName]
                );

                $tagIds[] = $tag->id;
            }
        }

        $content->tags()->sync($tagIds);

        return redirect()->route('admin.contents.index')
            ->with('status', 'อัปเดตเนื้อหาเรียบร้อยแล้ว');
    }

    // ============================
    // DELETE — ลบคอนเทนต์
    // ============================
    public function destroy(Content $content)
    {
        if (!empty($content->thumbnail_url) && str_starts_with($content->thumbnail_url, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $content->thumbnail_url);
            Storage::disk('public')->delete($oldPath);
        }

        if (!empty($content->video_url) && str_starts_with($content->video_url, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $content->video_url);
            Storage::disk('public')->delete($oldPath);
        }

        $content->delete();

        return redirect()->route('admin.contents.index')
            ->with('status', 'ลบเนื้อหาเรียบร้อยแล้ว');
    }
}
