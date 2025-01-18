@extends('layouts.templateUser')
@section('content')

<div class="container-fluid py-5">
    <div class="container py-5">
        <h1 class="mb-4">Billing details</h1>
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="row g-5">
                <div class="col-md-12 col-lg-6 col-xl-6">
                    <div class="form-item">
                        <label class="form-label my-3">First Name<sup>*</sup></label>
                        <input type="text" class="form-control" name="first_name" value="{{ Auth::user()->name }}" required>
                    </div>
                    <!-- <div class="col-md-12 col-lg-6">
                            <div class="form-item w-100">
                                <label class="form-label my-3">Last Name<sup>*</sup></label>
                                <input type="text" class="form-control" name="last_name" value="{{ Auth::user()->last_name }}" required>
                            </div>
                        </div> -->
                    <div class="form-item">
                        <label class="form-label my-3">Address <sup>*</sup></label>
                        <input type="text" class="form-control" name="address" placeholder="House Number Street Name" value="{{ Auth::user()->address }}" required>
                    </div>
                    <div class="form-item">
                        <label class="form-label my-3">Mobile<sup>*</sup></label>
                        <input type="tel" class="form-control" name="mobile" value="{{ Auth::user()->phone }}" required>
                    </div>
                    <div class="form-item pb-3">
                        <label class="form-label my-3 p-2">Email Address<sup>*</sup></label>
                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>
                    </div>
                    <div class="form-item">
                        <label class="form-label my-3">Order Notes</label>
                        <textarea name="order_notes" class="form-control" spellcheck="false" cols="30" rows="11" placeholder="Order Notes (Optional)" required></textarea>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Products</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $cartItem)
                                <tr>
                                    <th scope="row">
                                        <div class="d-flex align-items-center mt-2">
                                            <img src="{{ asset('images/products/' . $cartItem->product->image) }}" class="img-fluid rounded-circle" style="width: 90px; height: 90px;" alt="">
                                        </div>
                                    </th>
                                    <td class="py-5">{{ $cartItem->product->name }}</td>
                                    <td class="py-5">@currency($cartItem->product->price)</td>
                                    <td class="py-5">{{ $cartItem->quantity }}</td>
                                    <td class="py-5">@currency($cartItem->product->price * $cartItem->quantity)</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th scope="row"></th>
                                    <td class="py-5"></td>
                                    <td class="py-5"></td>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark py-3">Total</p>
                                    </td>
                                    <td class="py-5">
                                        <div class="py-3 border-bottom border-top">
                                            <p class="mb-0 text-dark">@currency($totalPrice)</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="payment_midtrans" value="midtrans" checked>
                        <label class="form-check-label" for="payment_midtrans">Bayar dengan Midtrans</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="payment_cod" value="cod">
                        <label class="form-check-label" for="payment_cod">Cash on Delivery</label>
                    </div>

                    <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                        <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Place Order</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection