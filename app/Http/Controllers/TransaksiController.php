<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = Transaksi::with('produk')->paginate(10); // Menampilkan 10 transaksi per halaman
        return view('contents.frontend.transaksi.index', compact('transaksi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produk = Produk::all(); // Mengambil semua produk untuk pemilihan
        return view('contents.frontend.transaksi.create', compact('produk'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input dari pengguna
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1',
            'berat' => 'required|numeric|min:0',
            'harga_per_gram' => 'required|numeric|min:0',
            'total_harga' => 'required|numeric|min:0',
            'pelanggan' => 'required|string|max:255',
        ]);
    
        // Ambil data produk berdasarkan ID
        $produk = Produk::findOrFail($request->produk_id);
    
        // Cek jika stok cukup
        if ($produk->stok < $request->jumlah) {
            return redirect()->back()->withErrors('Stok tidak cukup untuk jumlah yang diminta.');
        }
    
        // Simpan transaksi ke database
        Transaksi::create([
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'berat' => $request->berat,
            'harga_per_gram' => $request->harga_per_gram,
            'total_harga' => $request->total_harga,
            'pelanggan' => $request->pelanggan,
        ]);
    
        // Kurangi stok produk
        $produk->stok -= $request->jumlah;
        $produk->save();
    
        // Redirect dengan pesan sukses
        return redirect()->route('frontend.produk', ['id' => $request->produk_id])
                         ->with('success', 'Transaksi berhasil dilakukan. Terima kasih atas pembelian Anda!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
