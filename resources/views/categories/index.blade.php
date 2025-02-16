@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách danh mục</h1>
    <div class="mb-3">
        <a href="{{ route('categories.create') }}" class="btn btn-success">Thêm danh mục mới</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Số bài viết</th>
                <th>Số View</th>
                <th>Ngày Tạo</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td><a href="{{ route('categories.edit', $category->id) }}">{{ $category->title }}</a></td>
                <td>{{ $category->posts_count }}</td>
                <td>{{ $category->views }}</td>
                <td>{{ $category->created_at->format('Y-m-d H:i:s') }}</td>
                <td>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn xóa danh mục này?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Xóa</button>
                    </form>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-primary">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Phân trang -->
    {{ $categories->links() }}
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif
</script>
@endsection
