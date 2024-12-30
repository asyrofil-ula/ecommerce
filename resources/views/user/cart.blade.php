@extends('layouts.templateUser')

@section('content')
<!-- Cart Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="table-responsive">
            @if ($cartItems->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Products</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $cartItem)
                    <tr>
                        <th scope="row">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('images/products/' . $cartItem->product->image) }}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                            </div>
                        </th>
                        <td>
                            <p class="mb-0 mt-4">{{ $cartItem->product->name }}</p>
                        </td>
                        <td>
                            <p class="mb-0 mt-4" data-price-cart-id="{{ $cartItem->id }}" data-price="{{ $cartItem->product->price }}">
                                @currency($cartItem->product->price)
                            </p>
                        </td>
                        <td>
                            <div class="input-group quantity mt-4" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-minus rounded-circle bg-light border" data-action="decrease" data-cart-id="{{ $cartItem->id }}" min="1" step="1">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="number" class="form-control form-control-sm text-center border-0 cart-quantity"
                                    value="{{ $cartItem->quantity }}"
                                    data-cart-id="{{ $cartItem->id }}"
                                    min="1">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-plus rounded-circle bg-light border" data-action="increase" data-cart-id="{{ $cartItem->id }}" min="1" step="1">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>

                        <td>
                            <p class="mb-0 mt-4" data-subtotal-cart-id="{{ $cartItem->id }}">
                                @currency($cartItem->product->price * $cartItem->quantity)
                            </p>
                        </td>
                        <td>
                            <form action="{{ route('cart.remove', $cartItem->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-md rounded-circle bg-light border mt-4">
                                    <i class="fa fa-times text-danger"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>Your cart is empty.</p>
            @endif
        </div>
        <div class="row g-4 justify-content-end">
            <div class="col-8"></div>
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded">
                    <div class="p-4">
                        <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                    </div>
                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                        <!-- <div class="d-flex justify-content-between mb-4"> -->
                        <h5 class="mb-0 ps-4 me-4">Total</h5>
                        <p class="mb-0 pe-4" id="cart-total">@currency($cartItems->sum('product.price'))</p>
                        <!-- </div> -->
                    </div>
                    <button id="checkout-button" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button">Proceed Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart Page End -->

@endsection
@section('js')
<script>
//checkout-button
document.getElementById('checkout-button').addEventListener('click', function () {
    window.location.href = "{{ route('checkout.show') }}";
})

document.addEventListener('click', function (e) {
    if (e.target.closest('button[data-action]')) {
        const button = e.target.closest('button[data-action]');
        const action = button.dataset.action; 
        const cartId = button.dataset.cartId; 
        const quantityInput = document.querySelector(`input.cart-quantity[data-cart-id="${cartId}"]`);
        const priceElement = document.querySelector(`p[data-price-cart-id="${cartId}"]`);
        const subtotalElement = document.querySelector(`p[data-subtotal-cart-id="${cartId}"]`);

        let quantity = parseInt(quantityInput.value) || 1; 

        if (action === 'increase') {
            quantity + 1; 
        } else if (action === 'decrease' && quantity > 1) {
            quantity - 1;
        }

        // Perbarui nilai di input quantity
        quantityInput.value = quantity;

        // Hitung ulang subtotal
        const price = parseFloat(priceElement.dataset.price) || 0; 
        const subtotal = price * quantity;
        subtotalElement.textContent = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(subtotal);

        // Kirim perubahan ke server
        updateCartQuantity(cartId, quantity);

        // Perbarui total keranjang
        updateCartTotal();
    }
});

function updateCartTotal() {
    let total = 0;

    // Hitung total dari semua subtotal
    document.querySelectorAll('p[data-subtotal-cart-id]').forEach(subtotalElement => {
        const subtotalText = subtotalElement.textContent.replace(/[^\d]/g, ''); 
        const subtotalValue = parseInt(subtotalText) || 0;
        total += subtotalValue;
    });

    // Tampilkan total di elemen total keranjang
    document.getElementById('cart-total').textContent = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(total);
}

function updateCartQuantity(cartId, quantity) {
    // Kirim request ke server untuk memperbarui quantity
    fetch(`{{ route('cart.update') }}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            cart_id: cartId,
            quantity: quantity
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Cart updated:', data.message);
        } else {
            alert('Failed to update cart: ' + data.message);
        }
    })
    .catch(error => console.error('Error updating cart:', error));
}

</script>


@endsection