@extends('layouts.templateAdmin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Category List</h5>
                    <!-- Trigger the first modal -->
                    <a class="btn btn-primary text-white" id="myModalAdd" data-bs-toggle="modal" data-bs-target="#myInputAdd">+</a>
                </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $index => $category)
                        <tr>
                            <th scope="row">{{ $categories->firstItem() + $index }}</th>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td><img src="{{ asset('images/categories/'.$category->image) }}" alt="{{ $category->name }}" width="50"></td>
                            <td>
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myInputUpdate-{{ $category->id }}"><i class="ri-pencil-fill"></i></a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-delete" data-id="{{ $category->id }}"><i class="ri-delete-bin-5-fill"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination Links -->
                <div class="pagination justify-content-center ">
                    <div class="d-flex justify-content-center text-center">
                        {{ $categories->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- add Category -->

<!-- Add Category Modal -->
<div class="modal fade" id="myInputAdd" tabindex="-1" aria-labelledby="exampleModalToggleLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel1">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description" required></textarea>
                    </div>
                    <!-- gambar -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Update Category Modal -->
@foreach ($categories as $category)
<div class="modal fade" id="myInputUpdate-{{ $category->id }}" tabindex="-1" aria-labelledby="exampleModalToggleLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel1">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ $category->description }}</textarea>
                    </div>
                    <!-- gambar -->
                    <div class="mb-3">
                        <img src="{{ asset('images/categories/'.$category->image) }}" alt="{{ $category->name }}" width="50">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
@section('js')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const myModalAdd = document.getElementById('myModalAdd');
        const myInputAdd = document.getElementById('myInputAdd');

        myModalAdd.addEventListener('click', function() {
            myInputAdd.focus();
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const myModalUpdate = document.getElementById('myModalUpdate');
        const myInputUpdate = document.getElementById('myInputUpdate');

        myModalUpdate.addEventListener('click', function() {
            myInputUpdate.focus();
        });
    });
</script>


@endsection