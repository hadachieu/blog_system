@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <p><strong>Số view:</strong> {{ $post->views }}</p>
    <p>
        Danh mục: 
        @foreach($post->categories as $cat)
            <span class="badge badge-info">{{ $cat->title }}</span>
        @endforeach
    </p>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Quay về danh sách bài viết</a>
</div>
@endsection
