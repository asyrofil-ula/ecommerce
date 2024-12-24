@extends('layouts.templateUser')
@section('content')

<!-- Fruits Shop Start -->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Fresh fruits shop</h1>
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4">
                    <!-- Search -->
                    <div class="col-xl-3">
                        <form method="GET" action="{{ route('shop') }}" class="input-group w-100 mx-auto d-flex">
                            <input type="search" name="keyword" value="{{ request('keyword') }}" class="form-control p-3" placeholder="Search products">
                            <button type="submit" class="input-group-text p-3">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="row g-4">
                    <!-- Sidebar -->
                    <div class="col-lg-3">
                        <!-- Categories -->
                        <div class="mb-3">
                            <h4>Categories</h4>
                            <ul class="list-unstyled fruite-categorie">
                                @foreach ($categories as $category)
                                <li>
                                    <div class="d-flex justify-content-between fruite-name">
                                        <a href="{{ route('shop', ['category' => $category->id]) }}"
                                            class="{{ request('category') == $category->id ? 'text-primary fw-bold' : '' }}">
                                            <i class="fas fa-apple-alt me-2"></i>{{ $category->name }}
                                        </a>
                                        <span>({{ $category->products_count }})</span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Best Products -->
                        <div>
                            <h4 class="mb-3">Best products</h4>
                            @foreach ($bestproducts as $best)
                            <div class="d-flex align-items-center justify-content-start mb-3 p-3">
                                <div class="rounded me-4" style="width: 100px; height: 100px;">
                                    <img src="{{ asset('images/products/' . $best->product->image) }}" class="img-fluid rounded" alt="{{ $best->product->name }}">
                                </div>
                                <div>
                                    <h6 class="mb-2">{{ $best->product->name }}</h6>
                                    <div class="d-flex mb-2">
                                        <h5 class="fw-bold me-2">@currency($best->product->price)</h5>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $best->product->id }}">
                                        <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary">
                                            <i class="fa fa-shopping-bag "></i>
                                        </button>
                                    </form>
                                    <div class="text-center">
                                        <a href="{{ route('shop.show', $best->product->id) }}" class="btn border border-secondary rounded-pill px-3 text-primary">
                                            <i class="fa fa-eye "></i>
                                        </a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Products -->
                    <div class="col-lg-9">
                        <div class="row g-4 justify-content-between">
                            @foreach ($products as $product)
                            <div class="col-md-6 col-lg-6 col-xl-4">
                                <div class="rounded position-relative fruite-item h-100 d-flex flex-column">
                                    <!-- Product Image -->
                                    <div class="fruite-img">
                                        <img src="{{ asset('images/products/' . $product->image) }}"
                                            class="img-fluid w-100 rounded-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                    </div>
                                    <!-- Product Category -->
                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">
                                        {{ $product->category->name }}
                                    </div>
                                    <!-- Product Details -->
                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom d-flex flex-column justify-content-between flex-grow-1">
                                        <h4>{{ $product->name }}</h4>
                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <p class="text-dark fs-5 fw-bold mb-0">@currency($product->price)</p>
                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                    <i class="fa fa-shopping-bag "></i>
                                                </button>
                                            </form>
                                            <div class="text-center">
                                                <a href="{{ route('shop.show', $product->id) }}" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                    <i class="fa fa-eye "></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="col-12">
                            <div class="pagination d-flex justify-content-center mt-5">
                                <!-- Menampilkan Pagination Dinamis -->
                                {{ $products->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fruits Shop End -->

@endsection