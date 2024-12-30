@extends('layouts.templateAdmin')

@section('content')

<div class="container">
    <div class="bg-light p-5 rounded">
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
                    <button type="submit" class="btn btn-primary mt-6">Filter</button>
                    <a href="{{ route('admin.report.pdf', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-danger mt-6">
                        Cetak PDF
                    </a>
                </div>
            </div>
        </form>


    </div>
    <div class="card text-center mt-4">
        <h3>Total Penjualan Per Produk</h3>
        <table class="table table-hover ">
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
                    <td>@currency($item->price)</td>
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
    </div>

    <!-- Tabel untuk menampilkan data penjualan -->
    <div class="card text-center mt-4">
        <h3>Data Detail Penjualan</h3>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                    <th scope="col">Total Price</th>
                </tr>
            </thead>
            <tbody>
                @php
                $number = 1;
                @endphp
                @foreach ($order as $item)
                @if ($item->status == 'Completed')
                <tr>
                    <td>{{ $number++ }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                    <td>@currency($item->total_price)</td>
                </tr>
                @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">Total</th>
                    <th>@currency($totalSales)</th>
                </tr>
            </tfoot>
        </table>
        <div class="pagination justify-content-center ">
            <div class="d-flex justify-content-center text-center">
                {{ $order->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

@endsection