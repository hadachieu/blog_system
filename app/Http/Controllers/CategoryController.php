<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Danh sách danh mục
    public function index()
    {
        // Sắp xếp các danh mục theo created_at giảm dần, kèm theo số bài viết đếm được
        $categories = Category::orderBy('created_at', 'desc')
            ->withCount('posts')
            ->paginate(10);

        $categories->withPath(url('/categories'));

        return view('categories.index', compact('categories'));
    }

    // Hiển thị form thêm danh mục
    public function create()
    {
        return view('categories.create');
    }

    // Lưu danh mục mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);
        Category::create([
            'title' => $request->title,
            'views' => 0
        ]);
        return redirect()->route('categories.index')->with('success', 'Thêm danh mục thành công');
    }

    // Hiển thị form chỉnh sửa danh mục
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    // Cập nhật danh mục
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required'
        ]);
        $category = Category::findOrFail($id);
        $category->update([
            'title' => $request->title
        ]);
        return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công');
    }

    // Xóa danh mục
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Xóa danh mục thành công');
    }
}
