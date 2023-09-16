@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Produk</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Nama Produk: {{ $produk->nama_produk }}</h5>
            <p class="card-text">Harga: {{ $produk->harga }}</p>
            <p class="card-text">Stock: {{ $produk->stock }}</p>
        </div>
    </div>
    <a href="{{ route('produk.index') }}" class="btn btn-primary mt-3">Kembali</a>
</div>
@endsection