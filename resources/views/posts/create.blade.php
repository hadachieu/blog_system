@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Thêm bài viết mới</h1>
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Tiêu đề</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Nội dung</label>
            <textarea name="content" class="form-control" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label>Danh mục</label>
            <br>
            @foreach($categories as $category)
                <label>
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"> {{ $category->title }}
                </label>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Quay về danh sách bài viết</a>
    </form>
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
