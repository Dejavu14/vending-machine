@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Vending machine</h1>

    <!-- Form Input Uang Masuk -->
    <form method="POST" action="{{ route('produk.purchase') }}">
        @csrf
        <div class="form-group">
            <label for="uang_masuk">Uang Masuk:</label>
            <input type="number" name="uang_masuk" class="form-control" required>
        </div>

        <br>

        <a href="{{ route('produk.create') }}" class="btn btn-primary">Tambah Produk Baru</a>

        <br>


        <!-- Tabel Produk -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produk as $item)
                <tr>
                    <td>{{ $item->nama_produk }}</td>
                    <td>{{ $item->harga }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>
                        <input type="number" name="jumlah[{{ $item->id }}]" class="form-control jumlah" min="0" value="0" data-harga="{{ $item->harga }}">
                    </td>
                    <td>
                        <span class="total-harga" data-harga="{{ $item->harga }}">0</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </form>

    <!-- Jumlah Total Harga Pembelian -->
    <div class="form-group">
        <label for="total_harga_pembelian">Total Harga Pembelian:</label>
        <input type="text" name="total_harga_pembelian" class="form-control" readonly>
    </div>

    <!-- Tombol Beli -->
    <div class="form-group">
        <button type="submit" class="btn btn-success">Beli</button>
    </div>

    <br>

    <div class="form-group" id="uang-kembali-container" style="display: none;">
        <label for="uang_masuk">Uang Kembali:</label>
        <input type="number" name="uang_kembali" class="form-control" id="uang-kembali" readonly>
    </div>

    <br>

    <button type="reset" class="btn btn-danger">Reset</button>

    <!-- Form Uang Kembali -->
    @if(isset($kembalian))
    <div class="alert alert-info">
        Uang Kembali: {{ $kembalian }}
    </div>
    @endif
</div>

<script>
    // Ambil semua elemen input jumlah dan total harga
    const jumlahInputs = document.querySelectorAll('.jumlah');
    const totalHargas = document.querySelectorAll('.total-harga');

    // Tambahkan event listener untuk setiap input jumlah
    jumlahInputs.forEach(input => {
        input.addEventListener('input', () => {
            // Ambil harga dari atribut data-harga
            const harga = parseFloat(input.getAttribute('data-harga'));

            // Hitung total harga berdasarkan jumlah yang dimasukkan
            const jumlah = parseInt(input.value);
            const total = harga * jumlah;

            // Tampilkan total harga
            input.parentElement.nextElementSibling.querySelector('.total-harga').textContent = total.toFixed(2);
        });
    });

    // Ambil elemen input uang masuk, total harga pembelian, dan input uang kembali
    const uangMasukInput = document.querySelector('input[name="uang_masuk"]');
    const totalHargaPembelianInput = document.querySelector('input[name="total_harga_pembelian"]');
    const uangKembaliInput = document.querySelector('input[name="uang_kembali"]');

    // Tambahkan event listener untuk input jumlah produk
    jumlahInputs.forEach(input => {
        input.addEventListener('input', () => {
            // Hitung total harga pembelian
            let totalHargaPembelian = 0;
            totalHargas.forEach(totalHarga => {
                totalHargaPembelian += parseFloat(totalHarga.textContent);
            });

            // Set nilai total harga pembelian pada input
            totalHargaPembelianInput.value = totalHargaPembelian.toFixed(2);

            // Ambil nilai uang masuk
            const uangMasuk = parseFloat(uangMasukInput.value);

            // Hitung uang kembali
            const uangKembali = uangMasuk - totalHargaPembelian;

            // Tampilkan uang kembali jika uang masuk lebih besar dari total harga pembelian
            if (uangKembali >= 0) {
                uangKembaliInput.value = uangKembali.toFixed(2);
            } else {
                uangKembaliInput.value = "";
            }
        });
    });

    const beliButton = document.querySelector('button[type="submit"]');
    const uangKembaliContainer = document.getElementById('uang-kembali-container');
    // const uangKembaliInput = document.getElementById('uang-kembali');

    // Tambahkan event listener untuk tombol "Beli"
    beliButton.addEventListener('click', (event) => {
        event.preventDefault(); // Mencegah pengiriman formulir

        // Ambil total harga pembelian dari input
        const totalHargaPembelian = parseFloat(totalHargaPembelianInput.value);

        // Ambil nilai uang masuk
        const uangMasuk = parseFloat(uangMasukInput.value);

        // Hitung uang kembali
        const uangKembali = uangMasuk - totalHargaPembelian;

        // Tampilkan "Uang Kembali" jika uang masuk mencukupi
        if (uangKembali >= 0) {
            uangKembaliInput.value = uangKembali.toFixed(2);
            uangKembaliContainer.style.display = 'block';
        }
    });


    // Fungsi untuk mengatur ulang semua input jumlah menjadi 0
    function resetForm() {
        jumlahInputs.forEach(input => {
            input.value = 0;
            input.parentElement.nextElementSibling.querySelector('.total-harga').textContent = '0';
        });

        // Hapus isi input uang masuk
        uangMasukInput.value = '';

        // Sembunyikan "Uang Kembali" container
        uangKembaliContainer.style.display = 'none';
    }

    // Tambahkan event listener untuk tombol reset
    const resetButton = document.querySelector('button[type="reset"]');
    resetButton.addEventListener('click', (event) => {
        event.preventDefault(); // Mencegah reset default formulir
        resetForm();
    });

    // Fungsi untuk mengatur ulang semua input jumlah menjadi 0 dan menghitung ulang total harga pembelian
    function resetForm() {
        jumlahInputs.forEach(input => {
            input.value = 0;
            input.parentElement.nextElementSibling.querySelector('.total-harga').textContent = '0';
        });

        // Hitung ulang total harga pembelian
        let totalHargaPembelian = 0;
        totalHargas.forEach(totalHarga => {
            totalHargaPembelian += parseFloat(totalHarga.textContent);
        });

        // Set nilai total harga pembelian pada input
        totalHargaPembelianInput.value = totalHargaPembelian.toFixed(2);

        // Hapus isi input uang masuk
        uangMasukInput.value = '';

        // Sembunyikan "Uang Kembali" container
        uangKembaliContainer.style.display = 'none';
    }
</script>
@endsection