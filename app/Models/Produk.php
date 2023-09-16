<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = ['nama_produk', 'harga', 'stock'];

    public function index()
    {
        $produk = Produk::all();
        return view('produk.index', compact('produk'));
    }
}
