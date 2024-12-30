@extends('layouts.templateUser')
@section('content')

<div class="container py-5">
    <div class="container py-5">
        <h1 class="mb-4">Proses Pembayaran</h1>
        <p>Mohon tunggu, Anda akan diarahkan ke halaman pembayaran...</p>
        <a href="{{ route('user.orders') }}" class="btn btn-primary">Kembali ke Pesanan Saya</a>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    var snapToken = '{{ $snapToken }}';
    var orderId = '{{ $order->id }}';

    snap.pay(snapToken, {
        onSuccess: function(result) {
        // Jika pembayaran berhasil, tampilkan SweetAlert sukses
        Swal.fire({
            icon: 'success',
            title: 'Pembayaran Berhasil',
            text: 'Pesanan Anda sedang diproses.',
            confirmButtonText: 'OK'
        }).then(() => {
            // Arahkan ke halaman sukses setelah menutup SweetAlert
            window.location.href = '/user/orders';
        });
    },
    onPending: function(result) {
        // Jika pembayaran tertunda, tampilkan SweetAlert pending
        Swal.fire({
            icon: 'warning',
            title: 'Pembayaran Tertunda',
            text: 'Pembayaran Anda sedang diproses. Silakan cek kembali nanti.',
            confirmButtonText: 'OK'
        }).then(() => {
            // Arahkan ke halaman pending setelah menutup SweetAlert
            window.location.href = '/user/orders';
        });
    },
    onError: function(result) {
        // Jika pembayaran gagal, tampilkan SweetAlert error
        Swal.fire({
            icon: 'error',
            title: 'Pembayaran Gagal',
            text: 'Silakan coba lagi.',
            confirmButtonText: 'OK'
        }).then(() => {
            // Arahkan kembali ke halaman order user setelah menutup SweetAlert
            window.location.href = '/user/orders';
        });
    },
        onClose: function() {
            // Jika modal ditutup tanpa menyelesaikan pembayaran
            alert('Anda telah menutup modal pembayaran. Status pesanan akan diperbarui menjadi pending.');

            // Perbarui status pesanan menjadi pending di backend
            fetch('/orders/' + orderId + '/update-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: 'Pending'
                    })
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '/user/orders'; // Redirect ke halaman orders
                    } else {
                        alert('Gagal memperbarui status pesanan.');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui status pesanan.');
                });
        }
    });
</script>

@endsection