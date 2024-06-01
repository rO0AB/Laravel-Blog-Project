@extends('back.layouts.master')
@section('title', 'All Categories')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Create Category</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('admin.category.create')}}">
                        @csrf
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" class="form-control" name="category" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Add</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Number of Articles</th>
                                <th>Status</th>
                                <th>Operation</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->articleCount()}}</td>
                                    <td>
                                        <input class="switch" category-id="{{$category->id}}" type="checkbox"
                                               data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                               @if($category->status==1) checked @endif data-on="Active"
                                               data-off="Passive">
                                    </td>
                                    <td>
                                        <a category-id="{{$category->id}}" title="Edit Category"
                                           class="btn btn-sm btn-primary edit-click"><i
                                                class="fa fa-edit text-white"></i></a>
                                        <a category-id="{{$category->id}}" category-name="{{$category->name}}"
                                           category-count="{{$category->articleCount()}}" title="Delete Category"
                                           class="btn btn-sm btn-danger remove-click"><i
                                                class="fa fa-times text-white"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kategoriyi Düzenle</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('admin.category.update')}}">
                        @csrf
                        <div class="form-group">
                            <labe>Category Adı</labe>
                            <input id="category" type="text" class="form-control" name="category">
                            <input type="hidden" id="category_id" class="form-control" name="id">
                        </div>
                        <div class="form-group">
                            <labe>Category Adı</labe>
                            <input id="slug" type="text" class="form-control" name="slug">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-success">Kaydet</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Kategoriyi Sil</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal footer -->
                <div class="modal-body" id="body">
                    <div class="alert alert-danger" id="articleAlert"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                    <form method="post" action="{{route('admin.category.delete')}}">
                        @csrf
                        <input type="hidden" name="id" id="deleteId">
                        <button id="deleteButton" type="submit" class="btn btn-success">Sil</button>
                    </form>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@section('js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        $(function () {
            $('.remove-click').click(function () {
                id = $(this)[0].getAttribute('category-id');
                count = $(this)[0].getAttribute('category-count');
                name = $(this)[0].getAttribute('category-name');

                if (id == 1) {
                    $('#articleAlert').html(name + ' category is fixed category. Articles from other deleted categories will be added to this category.');//vulnerable to dom based xss :((
                    $('#body').show();
                    $('#deleteButton').hide();
                    $('#deleteModal').modal();
                    return;
                }

                $('#deleteButton').show();
                $('#deleteId').val(id);
                $('#articleAlert').html('');
                $('#body').hide();
                if (count > 0) {
                    $('#articleAlert').html('There are ' + count + ' articles in this category. Are you sure you want to delete?');
                    $('#body').show();
                }
                $('#deleteModal').modal();
            });

            $('.edit-click').click(function () {
                id = $(this)[0].getAttribute('category-id');
                $.ajax({
                    type: 'GET',
                    url: '{{route('admin.category.get.data')}}',
                    data: {id: id},
                    success: function (data) {
                        $('#category').val(data.name);
                        $('#slug').val(data.slug);
                        $('#category_id').val(data.id);
                        $('#editModal').modal();
                    }
                });
            });

            $('.switch').change(function () {
                id = $(this)[0].getAttribute('category-id');
                statu = $(this).prop('checked')
                $.get("{{route('admin.category.switch')}}", {id: id, statu: statu}, function (data, status) {
                });
            })
        })
    </script>
@endsection
