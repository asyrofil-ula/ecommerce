@extends('layouts.templateAdmin')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Order List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive text-center">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Addres</th>
                                <th scope="col">Telp</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#</td>
                                <td>jhjdhjshjd</td>
                                <td>2000</td>
                                <td>#</td>
                                <td>jhjdhjshjd</td>
                                <td>2000</td>
                                <td>
                                    <a href="" class="btn btn-primary" id="myModalView" data-bs-toggle="modal" data-bs-target="#myInputView">View Details</a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
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