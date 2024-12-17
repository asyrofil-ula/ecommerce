@extends('layouts.templateUser')
@section('content')

<div class="container py-5">
    <h1 class="mb-4">Proses Pembayaran</h1>
    <p>Mohon tunggu, Anda akan diarahkan ke halaman pembayaran...</p>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    var snapToken = '{{ $snapToken }}';
    var orderId = '{{ $order->id }}';

    snap.pay(snapToken, {
        onSuccess: function(result) {
            // Jika pembayaran berhasil, arahkan ke halaman sukses
            window.location.href = '/user/orders/success/' + orderId;
        },
        onPending: function(result) {
            // Jika pembayaran tertunda, arahkan ke halaman pending
            window.location.href = '/user/orders/pending/' + orderId;
        },
        onError: function(result) {
            alert('Pembayaran gagal. Silakan coba lagi.');
            // Arahkan kembali ke halaman order user
            window.location.href = '/user/orders';
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
                body: JSON.stringify({ status: 'Pending' })
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
