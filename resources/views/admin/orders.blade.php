@extends('layouts.templateAdmin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Orders List</h5>
                    <!-- search -->
                    <form action="{{ route('admin.orders') }}" method="GET" class="">
                        <div class="input-group position-relative ">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="ri-search-line ri-22px me-2"></i>
                            </span>
                            <input
                                type="search"
                                name="search"
                                class="form-control form-control-lg ps-0 border-start-0"
                                placeholder="Search orders..."
                                value="{{ request('search') }}"
                                style="box-shadow: none;">
                            <button class="btn btn-primary" type="submit">
                                <i class="ri-search-line ri-22px me-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->first_name.' '.$order->last_name }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->mobile }}</td>
                            <td>{{ $order->address }}</td>
                            <td>@currency($order->total_price)</td>
                            @if ($order->status === 'Pending')
                            <td><span class="text-warning">Pending</span></td>
                            @elseif ($order->status === 'Processing')
                            <td><span class="text-info">Processing</span></td>
                            @elseif ($order->status === 'Delivery')
                            <td><span class="text-info">Delivery</span></td>
                            @elseif ($order->status === 'Completed')
                            <td><span class="text-success">Completed</span></td>
                            @elseif ($order->status === 'Cancelled')
                            <td><span class="text-danger">Cancelled</span></td>
                            @endif
                            <td>
                                <!-- Button to trigger modal -->
                                <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#editOrderModal{{ $order->id }}"><i class="ri-pencil-fill"></i></button>
                                <!-- button modal view detail -->
                                <button class="btn btn-info mt-3" data-bs-toggle="modal" data-bs-target="#viewOrderModal{{ $order->id }}"><i class="ri-eye-fill"></i></button>
                            </td>
                        </tr>

                        <!-- Modal for Editing Order -->
                        <div class="modal fade" id="editOrderModal{{ $order->id }}" tabindex="-1" aria-labelledby="editOrderLabel{{ $order->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editOrderLabel{{ $order->id }}">Edit Order #{{ $order->id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="status{{ $order->id }}" class="form-label">Status</label>
                                                <select id="status{{ $order->id }}" name="status" class="form-select"
                                                    {{ $order->status === 'Completed' || $order->status === 'Cancelled' ? 'disabled' : '' }}>
                                                    <option value="Pending" {{ $order->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="Processing" {{ $order->status === 'Processing' ? 'selected' : '' }}>Processing</option>
                                                    <option value="Delivery" {{ $order->status === 'Delivery' ? 'selected' : '' }}>Delivery</option>
                                                    <option value="Completed" {{ $order->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="Cancelled" {{ $order->status === 'Cancelled' ? 'selected' : '' }}>Canceled</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success"
                                                {{ $order->status === 'Completed' || $order->status === 'Cancelled' ? 'disabled' : '' }}>Save Changes</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="d-flex justify-content-center py-3">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
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
                <p><strong>Notes : </strong> {{ $order->notes }}</p>
                <hr>
                <!-- Table Produk -->
                <table class="table table-sm text-center">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderDetails as $detail)
                        <tr>
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
                        body: JSON.stringify({
                            status
                        })
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