@extends('layouts.templateUser')

@section('content')
<!-- Single Product Start -->
<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="row g-4 mb-5">
            <div class="col-lg-8 col-xl-9">
                <div class="row g-4">
                    <div class="col-lg-6">

                        <div class="ratio ratio-1x1" style="max-width: 400px; margin: 0 auto;">
                            <img src="{{ asset('images/products/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="fw-bold mb-3">{{ $product->name }}</h4>
                        <p class="mb-3">Category: {{ $product->category->name }}</p>
                        <p class="mb-3">Stock: {{ $product->stock }}</p>
                        <h5 class="fw-bold mb-3">@currency($product->price)</h5>
                        <div class="input-group quantity mb-5" style="width: 100px;">

                        </div>
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary">
                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                            </button>
                        </form>
                    </div>
                    <div class="col-lg-12">
                        <nav>
                            <div class="nav nav-tabs mb-3">
                                <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                    id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                    aria-controls="nav-about" aria-selected="true">Description</button>
                            </div>
                        </nav>
                        <div class="tab-content mb-5">
                            <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Best Products -->
            <div class="col-lg-4 col-xl-3">
                <div class="row g-4 fruite">
                    <div class="col-lg-12">
                        <h4 class="mb-4">Best products</h4>
                        @foreach ($bestProducts as $bestProduct)
                        <div class="d-flex align-items-center justify-content-start mb-3 p-3">
                            <div class="rounded me-4" style="width: 100px; height: 100px;">
                                <img src="{{ asset('images/products/' . $bestProduct->product->image) }}" class="img-fluid rounded" alt="{{ $bestProduct->product->name }}">
                            </div>
                            <div>
                                <h6 class="mb-2">{{ $bestProduct->product->name }}</h6>
                                <div class="d-flex mb-2">
                                    <h5 class="fw-bold me-2">@currency($bestProduct->product->price)</h5>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <h1 class="fw-bold mb-0">Related products</h1>
        <div class="vesitable">
            <div class="owl-carousel vegetable-carousel justify-content-center">
                @foreach ($relatedProducts as $related)
                <div class="border border-primary rounded position-relative vesitable-item">
                    <div class="ratio ratio-1x1">
                        <div class="vesitable-img">
                            <img src="{{ asset('images/products/' . $related->image) }}" class="img-fluid w-100 rounded-top" alt="{{ $related->name }}">
                        </div>
                    </div>
                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">
                        {{ $related->category->name }}
                    </div>
                    <div class="p-4 pb-0 rounded-bottom">
                        <h4>{{ $related->name }}</h4>
                        <p>Stock: {{ $related->stock }}</p>
                        <p>{{ $related->short_description }}</p>
                        <div class="d-flex justify-content-between flex-lg-wrap">
                            <p class="text-dark fs-5 fw-bold">@currency($related->price)</p>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $related->id }}">
                                <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary">
                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection