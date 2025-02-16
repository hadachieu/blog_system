<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Blog System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    @yield('styles')
</head>
<body>
    <div class="container mt-4">
        <!-- Thanh menu điều hướng -->
        <div class="mb-3">
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Trang chủ (Danh mục)</a>
            <a href="{{ route('posts.index') }}" class="btn btn-primary">Danh sách bài viết</a>
        </div>
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- @if(session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif --}}
    @yield('scripts')
</body>
</html>
