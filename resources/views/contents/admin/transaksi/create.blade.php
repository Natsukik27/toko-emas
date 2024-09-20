@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Tambah Transaksi Pembelian Emas</h1>

    <form action="{{ route('admin.transaksi.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="produk_id">Produk</label>
            <select name="produk_id" id="produk_id" class="form-control" required>
                @foreach ($produk as $produk)
                    <option value="{{ $produk->id }}">{{ $produk->nama_produk }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="berat">Berat (g)</label>
            <input type="number" name="berat" id="berat" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="harga_per_gram">Harga per Gram</label>
            <input type="number" name="harga_per_gram" id="harga_per_gram" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="total_harga">Total Harga</label>
            <input type="number" name="total_harga" id="total_harga" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="pelanggan">Pelanggan</label>
            <input type="text" name="pelanggan" id="pelanggan" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>
@endsection
