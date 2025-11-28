<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentApiController extends Controller
{
    // ✅ list สำหรับหน้า "คอนเทนต์ทั้งหมด" + หน้าแรก
    public function index(Request $request)
    {
        // พยายามอ่าน user จาก sanctum token (ถ้ามี)
        $user = Auth::guard('sanctum')->user();
        $membershipStatus = $user->membership_status ?? 'visitor'; // visitor / pending / active

        $query = Content::with(['category', 'tags']);

        // 1. Filter by Type (article / video)
        if ($type = $request->input('type')) {
            if ($type !== 'all') {
                $query->where('type', $type);
            }
        }

        // 2. Filter by Category
        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        // 3. Filter by Tag (Exact match by ID)
        if ($tagId = $request->input('tag_id')) {
            $query->whereHas('tags', function ($q) use ($tagId) {
                $q->where('tags.id', $tagId);
            });
        }

        // 4. Search (Title + Content + Tag Name)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('teaser', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%")
                    ->orWhereHas('tags', function ($t) use ($search) {
                        $t->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // 5. Sort (Newest -> Oldest)
        $sort = $request->input('sort', 'newest'); // default newest
        if ($sort === 'oldest') {
            $query->oldest('created_at');
        } else {
            $query->latest('created_at');
        }

        // กำหนด per_page จากหน้าบ้าน ถ้าไม่ส่งมาก็ใช้ 9
        $perPage = (int) ($request->input('per_page') ?: 9);

        // Select only necessary columns for list view (exclude 'body')
        $query->select([
            'id',
            'category_id',
            'title',
            'slug',
            'type',
            'teaser',
            'thumbnail_url',
            'video_url',
            'views',
            'created_at'
        ]);

        $contents = $query->paginate($perPage);

        return response()->json([
            'membership_status' => $membershipStatus,
            'contents' => $contents,
        ]);
    }

    public function getCategories()
    {
        $categories = \Illuminate\Support\Facades\Cache::remember('categories_all', 3600, function () {
            return \App\Models\Category::all();
        });
        return response()->json($categories);
    }

    public function getTags()
    {
        $tags = \Illuminate\Support\Facades\Cache::remember('tags_all', 3600, function () {
            return \App\Models\Tag::all();
        });
        return response()->json($tags);
    }

    // ✅ detail สำหรับหน้า ContentDetailPage.vue
    public function showBySlug(Request $request, string $slug)
    {
        $user = $request->user(); // safe เพราะผ่าน auth:sanctum แล้ว
        $membershipStatus = $user->membership_status ?? 'visitor';
        $canViewFull = $membershipStatus === 'active';

        $content = Content::with(['category', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        $content->increment('views');

        return response()->json([
            'membership_status' => $membershipStatus,
            'can_view_full' => $canViewFull,
            'content' => [
                'id' => $content->id,
                'title' => $content->title,
                'slug' => $content->slug,
                'type' => $content->type,
                'teaser' => $content->teaser,
                'body' => $canViewFull ? $content->body : null,   // ⭐ FIX
                'thumbnail_url' => $content->thumbnail_url,
                'video_url' => $content->video_url,
                'created_at' => $content->created_at,
                'category' => optional($content->category)->name,
                'tags' => $content->tags->pluck('name')->values(),
                'views' => $content->views,
            ],
        ]);
    }

}
