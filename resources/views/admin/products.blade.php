@extends('layouts.templateAdmin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Product List</h5>
                    <!-- search -->
                    <form action="{{ route('admin.products') }}" method="GET" class="">
                        <div class="input-group position-relative ">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="ri-search-line ri-22px me-2"></i>
                            </span>
                            <input
                                type="search"
                                name="search"
                                class="form-control form-control-lg ps-0 border-start-0"
                                placeholder="Search products..."
                                value="{{ request('search') }}"
                                style="box-shadow: none;">
                            <button class="btn btn-primary" type="submit">
                                <i class="ri-search-line ri-22px me-2"></i>
                            </button>
                        </div>
                    </form>
                    <!-- Trigger the first modal -->
                </div>
                <div class="d-flex justify-content-end">
                <a class="btn btn-primary btn-sm text-white justify-content-end align-items-end" id="myModalAdd" data-bs-toggle="modal" data-bs-target="#myInputAdd" style="margin-right: 10px">Tambah Product</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Category</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Price</th>
                                <th scope="col">Image</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $index => $product)
                            <tr>
                                <th scope="row">{{ $products->firstItem() + $index }}</th>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>@currency($product->price)</td>
                                <td><img src="{{ asset('images/products/'.$product->image) }}" alt="{{ $product->name }}" width="50"></td>
                                <td>
                                    <a href="#" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#myInputUpdate-{{ $product->id }}"><i class="ri-pencil-fill"></i></i></a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-delete mt-3" data-id="{{ $product->id }}" data-name="{{ $product->name }}"><i class="ri-delete-bin-5-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-5">
                        {{ $products->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="myInputAdd" tabindex="-1" aria-labelledby="exampleModalToggleLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel1">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <!-- Nama Produk -->
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama produk" required>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Masukkan deskripsi produk" required></textarea>
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Stok -->
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stock" name="stock" placeholder="Masukkan stok produk" required>
                            </div>
                        </div>

                        <!-- Harga -->
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="price" name="price" placeholder="Masukkan harga produk" required>
                            </div>
                        </div>

                        <!-- Gambar Produk -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            <small class="text-muted">Format: jpeg, png, jpg, gif, svg. Maksimal 2 MB.</small>
                            <div id="imageError" class="text-danger"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- edit product -->
@foreach ($products as $product)
<div class="modal fade" id="myInputUpdate-{{ $product->id }}" tabindex="-1" aria-labelledby="updateProductLabel-{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProductLabel-{{ $product->id }}">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name-{{ $product->id }}" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="name-{{ $product->id }}" name="name" value="{{ $product->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description-{{ $product->id }}" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description-{{ $product->id }}" name="description" rows="3" required>{{ $product->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="category_id-{{ $product->id }}" class="form-label">Kategori</label>
                        <select class="form-select" id="category_id-{{ $product->id }}" name="category_id" required>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="stock-{{ $product->id }}" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stock-{{ $product->id }}" name="stock" value="{{ $product->stock }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="price-{{ $product->id }}" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="price-{{ $product->id }}" name="price" value="{{ $product->price }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="image-{{ $product->id }}" class="form-label">Gambar Produk</label>
                        <input type="file" class="form-control" id="image-{{ $product->id }}" name="image" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                        <div id="imageError-{{ $product->id }}" class="text-danger"></div>
                        <img src="{{ asset('images/products/'.$product->image) }}" alt="{{ $product->name }}" width="50">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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