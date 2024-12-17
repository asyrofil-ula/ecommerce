@extends('layouts.templateAdmin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">User</h1>
                    <!-- search -->
                    <form action="{{ route('admin.users') }}" method="GET" class="">
                        <div class="input-group position-relative ">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="ri-search-line ri-22px me-2"></i>
                            </span>
                            <input
                                type="search"
                                name="search"
                                class="form-control form-control-lg ps-0 border-start-0"
                                placeholder="Search orders..."
                                value="{{ request('search') }}"
                                style="box-shadow: none;">
                            <button class="btn btn-primary" type="submit">
                                <i class="ri-search-line ri-22px me-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-sm text-center">
                            <thead>
                                <tr>
                                    <th class="text-truncate">No</th>
                                    <th class="text-truncate">User</th>
                                    <th class="text-truncate">Email</th>
                                    <th class="text-truncate">Role</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($users as $user)
                                <tr>
                                    <td class="text-truncate">{{ $users->firstItem() + $loop->index }}</td>
                                    <td class="text-truncate">{{ $user->name }}</td>
                                    <td class="text-truncate">{{ $user->email }}</td>
                                    <td class="text-truncate">
                                        @if ($user->role == 'admin')
                                        <i class="ri-vip-crown-line ri-22px text-primary me-2"></i>
                                            <span>{{ $user->role }}</span>
                                        @else
                                        <i class="ri-user-3-line ri-22px text-success me-2"></i>
                                            <span>{{ $user->role }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $users->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- detail order -->
<div class="modal fade" id="myInputView" tabindex="-1" aria-labelledby="exampleModalToggleLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel1">Detail Order Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h1>Order # - Details</h1>
                <p>Customer: siapa</p>
                <p>Status: panding</p>
                <p>Total Price:10000</p>

                <h3 class="mb-0">Products in this Order:</h3>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price per Unit</th>
                                <th scope="col">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>dsadsdsa</td>
                                <td>321</td>
                                <td>23323</td>
                                <td>32323</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p><strong>Shipping Address:</strong> alamat</p>
                <p><strong>Phone:</strong> telep</p>

                <h3>Order Actions</h3>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalToggle22" data-bs-dismiss="modal">
                    Open second modal
                </button>
            </div>
        </div>
    </div>
</div>


@endsection
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const myModalView = document.getElementById('myModalView');
        const myInputView = document.getElementById('myInputView');

        myModalView.addEventListener('click', function() {
            myInputView.focus();
        });
    });
</script>
@endsection