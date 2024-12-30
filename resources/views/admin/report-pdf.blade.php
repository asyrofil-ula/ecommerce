<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h1 class="text-center">Laporan Penjualan</h1>
    <p>Periode: {{ $startDate->format('d-m-Y') }} s/d {{ $endDate->format('d-m-Y') }}</p>

    <h3>Total Penjualan Per Produk</h3>
    <table>
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

    <h3>Detail Penjualan</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Date</th>
                <th>Total Price</th>
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
    </table>
</body>
</html>
