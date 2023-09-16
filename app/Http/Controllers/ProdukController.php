<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produk;

class ProdukController extends Controller
{
    //
    public function index()
    {
        $produk = Produk::all();
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    // public function purchase(Request $request)
    // {
    //     // Ambil data produk yang dipilih oleh pengguna dari formulir
    //     $selectedProducts = $request->input('selectedProducts');

    //     // Ambil jumlah uang yang dimasukkan oleh pengguna dari formulir
    //     $inputUang = $request->input('inputUang');

    //     // Inisialisasi total harga
    //     $totalHarga = 0;

    //     // Inisialisasi pesan
    //     $message = '';

    //     // Hitung total harga produk yang dipilih
    //     foreach ($selectedProducts as $productId => $quantity) {
    //         $produk = Produk::find($productId);

    //         if ($produk) {
    //             $hargaProduk = $produk->harga;
    //             $subtotal = $hargaProduk * $quantity;
    //             $totalHarga += $subtotal;
    //         }
    //     }

    //     // Proses pembayaran
    //     if ($inputUang >= $totalHarga) {
    //         // Hitung kembalian
    //         $kembalian = $inputUang - $totalHarga;

    //         // Proses pengurangan stok produk
    //         foreach ($selectedProducts as $productId => $quantity) {
    //             $produk = Produk::find($productId);

    //             if ($produk) {
    //                 $produk->stock -= $quantity;
    //                 $produk->save();
    //             }
    //         }

    //         $message = 'Pembelian berhasil. Kembalian: ' . $kembalian;
    //     } else {
    //         $message = 'Pembayaran kurang. Mohon masukkan jumlah uang yang cukup.';
    //     }

    //     // Tampilkan kembali halaman dengan pesan
    //     $produk = Produk::all();
    //     return view('produk.index', compact('produk'))->with('message', $message);
    // }

    public function purchase(Request $request)
    {
        // Validasi input uang masuk
        $request->validate([
            'uang_masuk' => 'required|integer|min:1',
        ]);

        // Ambil nilai uang masuk dari formulir
        $uangMasuk = $request->input('uang_masuk');

        // Lakukan logika pembelian produk di sini
        // Misalnya, Anda dapat mengurangi stok produk dan menghitung uang kembali

        // Setelah pembelian selesai, Anda dapat mengarahkan pengguna ke halaman yang sesuai
        return redirect()->route('produk.index')->with('success', 'Pembelian berhasil');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_produk' => 'required|string',
            'harga' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        Produk::create($data);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }
}
