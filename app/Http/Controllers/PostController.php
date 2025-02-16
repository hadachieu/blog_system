<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    // Hiển thị view danh sách bài viết
    public function index()
    {
        $categories = Category::all();
        return view('posts.index', compact('categories'));
    }

    // Trả về dữ liệu cho DataTables (ajax)
    public function getData(Request $request)
    {
        $query = Post::with('categories')
            ->orderBy('created_at', 'desc'); // Sắp xếp mới nhất lên đầu

        if ($request->keyword) {
            $query->where('title', 'LIKE', '%' . $request->keyword . '%');
        }
        if ($request->categories && is_array($request->categories)) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('categories.id', $request->categories);
            });
        }

        return DataTables::of($query)
            ->addColumn('categories', function (Post $post) {
                return $post->categories->pluck('title')->implode(', ');
            })
            ->editColumn('created_at', function (Post $post) {
                return $post->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function (Post $post) {
                return '
                    <a href="' . route('posts.edit', $post->id) . '" class="btn btn-sm btn-primary">Edit</a>
                    <button data-id="' . $post->id . '" class="btn btn-sm btn-danger btn-delete">Xóa</button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    // Hiển thị form thêm bài viết
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    // Lưu bài viết mới
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'categories' => 'required|array'
        ]);

        $post = Post::create([
            'title'   => $request->title,
            'content' => $request->content,
            'views'   => 0,
        ]);

        $post->categories()->attach($request->categories);

        return redirect()->route('posts.index')->with('success', 'Thêm bài viết thành công');
    }

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
        $post = Post::with('categories')->findOrFail($id);
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    // Cập nhật bài viết
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'categories' => 'required|array'
        ]);

        $post = Post::findOrFail($id);
        $post->update([
            'title'   => $request->title,
            'content' => $request->content,
        ]);

        // Đồng bộ danh mục
        $post->categories()->sync($request->categories);

        return redirect()->route('posts.index')->with('success', 'Cập nhật bài viết thành công');
    }

    // Xóa bài viết
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json(['success' => 'Xóa bài viết thành công']);
    }

    public function updateView($id)
    {
        $post = Post::findOrFail($id);
        $post->increment('views');

        // Cập nhật số view cho các danh mục liên quan
        foreach ($post->categories as $category) {
            $totalViews = $category->posts()->sum('views');
            $category->update(['views' => $totalViews]);
        }
        return response()->json(['views' => $post->views]);
    }

    public function show($id)
    {
        // Lấy bài viết kèm theo danh mục
        $post = Post::with('categories')->findOrFail($id);
        
        // Tăng số view cho bài viết
        $post->increment('views');

        // Cập nhật tổng số view của từng danh mục liên quan
        foreach ($post->categories as $category) {
            $totalViews = $category->posts()->sum('views');
            $category->update(['views' => $totalViews]);
        }

        return view('posts.show', compact('post'));
    }

}
