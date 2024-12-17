@extends('layouts.templateUser')
@section('content')

<div class="container py-5">
    <h1 class="mb-4">Pembayaran Berhasil</h1>
    <p>Terima kasih telah melakukan pembayaran. Pesanan Anda sedang diproses.</p>
    <a href="{{ route('user.orders') }}" class="btn btn-primary">Lihat Pesanan Saya</a>
</div>

@endsection
