@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Thêm danh mục mới</h1>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Tiêu đề</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Quay về trang chủ</a>
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
