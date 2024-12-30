@extends('layouts.templateUser')
@section('content')

<div class="container py-5">
    <div class="container py-5 px-4 text-center">
        <h1 class="mb-4">Daftar Pesanan Saya</h1>
        @if($orders->isEmpty())
        <p>Anda belum memiliki pesanan.</p>
        <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Belanja Sekarang</a>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pesanan</th>
                    <th>Total Harga</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                    <td>@currency($order->total_price)</td>
                    <td>{{ $order->payment_method === 'midtrans' ? 'Midtrans' : 'COD' }}</td>
                    <td>
                        @if ($order->status === 'Pending')
                        <span class="text-warning">Pending</span>
                        @elseif ($order->status === 'Processing')
                        <span class="text-info">Processing</span>
                        @elseif ($order->status === 'Delivery')
                        <span class="text-info">Delivery</span>
                        @elseif ($order->status === 'Completed')
                        <span class="text-success">Completed</span>
                        @elseif ($order->status === 'Cancelled')
                            <span class="text-danger">Cancelled</span>
                            @endif
                        </td>

                    <td>
                        @if($order->status === 'Pending')
                            @if($order->payment_method === 'midtrans')
                            <span class="text-warning">Gagal Melakukan Pembayaran</span>
                            @else
                            <span class="text-secondary">Menunggu COD</span>
                            @endif
                            @elseif($order->status === 'Processing')
                            <span class="text-info">Pesanan Sedang Diproses</span>
                            @elseif($order->status === 'Delivery')
                            <span class="text-info">Pesanan Sedang Dalam Perjalanan</span>
                            @elseif($order->status === 'Completed')
                            <span class="text-success">Pesanan Selesai</span>
                            @elseif($order->status === 'Cancelled')
                            <span class="text-danger">Pesanan Dibatalkan</span>
                            @else
                            <span class="text-secondary">Sedang Diproses</span>
                        @endif
                    </td>
                    <td class="text-center px-3">
                    @if($order->status === 'Pending')
                            @if($order->payment_method === 'midtrans')
                            @endif
                            @elseif($order->status === 'Processing')
                            <button class="btn btn-danger btn-sm" onclick="updateOrderStatus('{{ $order->id }}', 'Cancelled')">Batalkan Pesanan</button>
                            @elseif($order->status === 'Delivery')
                            <button class="btn btn-success btn-sm" onclick="updateOrderStatus('{{ $order->id }}', 'Completed')">Pesanan Selesai</button>
                        @endif
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewOrderModal{{ $order->id }}">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>



<!-- modal detail order -->
@foreach ($orders as $order)
<div class="modal fade" id="viewOrderModal{{ $order->id }}" tabindex="-1" aria-labelledby="viewOrderLabel{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewOrderLabel{{ $order->id }}">Detail Order #{{ $order->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="strukContent{{ $order->id }}">
                <!-- Header Struk -->
                <div class="text-center mb-3">
                    <h4>Nama Toko Anda</h4>
                    <p>Alamat Toko<br>Nomor Telepon: 08123456789</p>
                    <hr>
                </div>
                <!-- Detail Order -->
                <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                <p><strong>Customer:</strong> {{ $order->user->name }}</p>
                <p><strong>Alamat:</strong> {{ $order->address }}</p>
                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d-m-Y H:i') }}</p>
                <hr>
                <!-- Table Produk -->
                <table class="table table-sm text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderDetails as $detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $detail->product->name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>@currency($detail->product->price)</td>
                            <td>@currency($detail->product->price * $detail->quantity)</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
                <!-- Total Harga -->
                <p class="text-end"><strong>Total:</strong> @currency($order->total_price)</p>
                <p class="text-center mt-3">Terima kasih atas pembelian Anda!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="printStruk('{{ $order->id }}')">Cetak Struk</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach



@endsection
@section('js')
<script>
   function updateOrderStatus(orderId, status) {
    Swal.fire({
        title: status === 'Completed' ? 'Selesaikan Pesanan?' : 'Batalkan Pesanan?',
        text: `Apakah Anda yakin ingin ${status === 'Completed' ? 'menyelesaikan' : 'membatalkan'} pesanan ini?`,
        icon: status === 'Completed' ? 'success' : 'warning',
        showCancelButton: true,
        confirmButtonColor: status === 'Completed' ? '#28a745' : '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/orders/${orderId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status })
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Status pesanan berhasil diperbarui.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Status pesanan gagal diperbarui.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                    });
                }
            }).catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan pada server.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
            });
        }
    });
}

</script>
<script>
    function printStruk(orderId) {
        const printContent = document.getElementById(`strukContent${orderId}`).innerHTML;
        const originalContent = document.body.innerHTML;
        document.body.innerHTML = `
            <div style="max-width: 300px; margin: auto; font-family: Arial, sans-serif; font-size: 12px;">
                ${printContent}
            </div>
        `;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload(); // Reload halaman untuk mengembalikan state asli
    }
</script>

@endsection