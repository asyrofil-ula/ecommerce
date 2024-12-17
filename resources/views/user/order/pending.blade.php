@extends('layouts.templateUser')
@section('content')

<div class="container py-5">
    <h1 class="mb-4">Pembayaran Belum Selesai</h1>
    <p>Pembayaran Anda tertunda. Silakan melanjutkan pembayaran untuk memproses pesanan Anda.</p>
    <a href="{{ route('checkout.retry', $order->id) }}" class="btn btn-warning">Lanjutkan Pembayaran</a>
    <a href="{{ route('user.orders') }}" class="btn btn-secondary">Kembali ke Pesanan Saya</a>
</div>

@endsection
