<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Str;

class AdminTagController extends Controller
{
 public function index(Request $request)
    {
        $q = $request->input('q');

        $tags = Tag::when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('slug', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.tags.index', compact('tags', 'q'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $data['slug'] = Str::slug($data['name'], '-'); // ⭐ เพิ่ม slug

        Tag::create($data);

        return redirect()->route('admin.tags.index')
            ->with('status', 'เพิ่มแท็กสำเร็จ');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $data['slug'] = Str::slug($data['name'], '-'); // ⭐ เพิ่ม slug

        $tag->update($data);

        return redirect()->route('admin.tags.index')
            ->with('status', 'อัปเดตแท็กสำเร็จ');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('status', 'ลบแท็กเรียบร้อยแล้ว');
    }
}
