@extends('layouts.templateAdmin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Order List</h5>
            </div>
            <div class="card-body text-center">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $item => $order)
                        <tr>
                            <th scope="row">{{ $orders->firstItem() + $item }}</th>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>@currency($order->total_price)</td>
                            @if ($order->created_at != null)
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            @else
                            <td>halo</td>
                            @endif
                            <td>
                                <a href="" class="btn btn-primary" id="myModalView" data-bs-toggle="modal" data-bs-target="#myInputView-{{ $order->id }}">View Details</a>
                        </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- detail order -->
    @foreach ($orders as $order)

    <div class="modal fade" id="myInputView-{{ $order->id }}" tabindex="-1" aria-labelledby="exampleModalToggleLabel1-{{ $order->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel1-{{ $order->id }}">Detail Order Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h1>Order Detail</h1>
                    <p>Customer {{ $order->user->name }}</p>
                    <p>Status: {{ $order->status }}</p>
                    <p>Total Price: @currency($order->total_price)</p>

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
                    <p><strong>Phone:</strong> telp</p>

                    <h3>Order Actions</h3>
                </div>
            </div>
        </div>
    </div>
    @endforeach
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