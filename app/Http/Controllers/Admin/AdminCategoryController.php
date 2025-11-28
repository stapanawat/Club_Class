<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    // 🔹 แสดงรายการหมวดหมู่ทั้งหมด
 public function index(Request $request)
    {
        $q = $request->input('q');

        $categories = Category::when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('slug', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.categories.index', compact('categories', 'q'));
    }

    // 🔹 ฟอร์มสร้างหมวดหมู่ใหม่
    public function create()
    {
        return view('admin.categories.create');
    }

    // 🔹 บันทึกหมวดหมู่ใหม่
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $data['slug'] = Str::slug($data['name'], '-');

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('status', 'เพิ่มหมวดหมู่สำเร็จ');
    }

    // 🔹 ฟอร์มแก้ไขหมวดหมู่
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // 🔹 อัปเดตหมวดหมู่
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $data['slug'] = Str::slug($data['name'], '-');

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('status', 'แก้ไขหมวดหมู่สำเร็จ');
    }

    // 🔹 ลบหมวดหมู่
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('status', 'ลบหมวดหมู่แล้ว');
    }
}
