@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách bài viết</h1>

    <div class="mb-3">
        <a href="{{ route('posts.create') }}" class="btn btn-success">Thêm bài viết mới</a>
    </div>

    <!-- Bộ lọc -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" id="keyword" class="form-control" placeholder="Tìm theo tiêu đề">
        </div>
        <div class="col-md-8">
            @foreach($categories as $category)
                <label>
                    <input type="checkbox" name="filter_categories[]" value="{{ $category->id }}"> {{ $category->title }}
                </label>
            @endforeach
        </div>
    </div>

    <table class="table table-bordered" id="posts-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Danh mục</th>
                <th>Số View</th>
                <th>Ngày Tạo</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@section('scripts')
<!-- Include jQuery, DataTables JS/CSS và toastr JS/CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(function() {
    // Khởi tạo DataTable
    var table = $('#posts-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('posts.data') }}",
            data: function (d) {
                d.keyword = $('#keyword').val();
                d.categories = [];
                $('input[name="filter_categories[]"]:checked').each(function(){
                    d.categories.push($(this).val());
                });
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title', render: function(data, type, row) {
                return '<a href="/posts/' + row.id + '">'+data+'</a>';
            }},            
            { data: 'categories', name: 'categories' },
            { data: 'views', name: 'views' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable:false, searchable:false }
        ]
    });

    // Lọc dữ liệu
    $('#keyword').on('keyup', function(){
        table.draw();
    });
    $('input[name="filter_categories[]"]').on('change', function(){
        table.draw();
    });

    // Xử lý xóa bài viết qua ajax
    $('#posts-table').on('click', '.btn-delete', function(){
        if(confirm('Bạn có chắc chắn muốn xóa bài viết này?')){
            var id = $(this).data('id');
            $.ajax({
                url: '/posts/' + id,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response){
                    toastr.success(response.success);
                    table.draw();
                }
            });
        }
    });

    // Hiển thị toastr nếu có session success
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif
});
</script>
@endsection
