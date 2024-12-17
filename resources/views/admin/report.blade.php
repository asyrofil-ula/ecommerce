@extends('layouts.templateAdmin')

@section('content')

<div class="container">
    <h1>Laporan Penjualan</h1>




    <!-- Form untuk memilih periode laporan -->
    <form action="{{ route('admin.report') }}" method="GET">
        <div class="row">
            <div class="col-md-4">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate->format('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate->format('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary mt-4">Filter</button>
            </div>
        </div>
    </form>
    <h3>Total Penjualan Per Produk</h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Quantity</th>
                <th>Total Penjualan</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($orderDetails as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>@currency($item->order->total_price)</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th></th>
                <th>{{ $totalProductsSold }}</th>
                <th>@currency($totalSales)</th>
            </tr>
        </tfoot>
    </table>

    <!-- Tabel untuk menampilkan data penjualan -->
    <table class="table mt-4">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Customer</th>
                <th scope="col">Total Price</th>
                <th scope="col">Status</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderDetails as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->order->user->name }}</td>
                <td>@currency($item->order->total_price)</td>
                <td>{{ ucfirst($item->order->status) }}</td>
                <td>{{ $item->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection