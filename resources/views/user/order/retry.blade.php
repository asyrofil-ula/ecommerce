@extends('layouts.templateUser')
@section('content')

<div class="container py-5">
    <h1 class="mb-4">Proses Ulang Pembayaran</h1>
    <p>Mohon tunggu, Anda akan diarahkan ke halaman pembayaran...</p>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    var snapToken = '{{ $snapToken }}';
    snap.pay(snapToken, {
        onSuccess: function(result) {
            window.location.href = '/user/orders/success/{{ $order->id }}';
        },
        onPending: function(result) {
            window.location.href = '/user/orders/pending/{{ $order->id }}';
        },
        onError: function(result) {
            alert('Pembayaran gagal. Silakan coba lagi.');
            window.location.href = '/user/orders';
        }
    });
</script>

@endsection
