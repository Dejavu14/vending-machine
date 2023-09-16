@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Produk Baru</h1>
    <form method="POST" action="{{ route('produk.store') }}">
        @csrf

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="nama_produk">Nama Produk:</label>
                <input type="text" name="nama_produk" class="form-control" required>
            </div>

            <div class="form-group col-md-4">
                <label for="harga">Harga:</label>
                <input type="number" name="harga" class="form-control" step="0.01" required>
            </div>

            <div class="form-group col-md-4">
                <label for="stock">Stock:</label>
                <input type="number" name="stock" class="form-control" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

    <br>

    <!-- Tombol "Tampilkan Data" -->
    <a href="{{ route('produk.index') }}" class="btn btn-primary">Tampilkan Data</a>

</div>
@endsection