@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chỉnh sửa bài viết</h1>
    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Tiêu đề</label>
            <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
        </div>
        <div class="form-group">
            <label>Nội dung</label>
            <textarea name="content" class="form-control" rows="5" required>{{ $post->content }}</textarea>
        </div>
        <div class="form-group">
            <label>Danh mục</label>
            <br>
            @foreach($categories as $category)
                <label>
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                    {{ in_array($category->id, $post->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                    {{ $category->title }}
                </label>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
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
