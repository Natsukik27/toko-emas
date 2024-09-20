@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Tambah Transaksi</h1>

    <!-- Success and Error Messages -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif

    <!-- Transaction Form -->
    <div class="card">
        <div class="card-header">
            Form Transaksi
        </div>
        <div class="card-body">
            <form action="{{ route('transaksi.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="produk_id" class="form-label">Jenis Emas</label>
                    <select id="produk_id" name="produk_id" class="form-select" required>
                        <option value="">Pilih Jenis Emas</option>
                        @foreach ($produk as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_produk }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="berat" class="form-label">Berat (g)</label>
                    <input type="number" id="berat" name="berat" class="form-control" step="0.01" min="0" required>
                </div>
                <div class="mb-3">
                    <label for="harga_per_gram" class="form-label">Harga per Gram</label>
                    <input type="number" id="harga_per_gram" name="harga_per_gram" class="form-control" step="0.01" min="0" required>
                </div>
                <div class="mb-3">
                    <label for="total_harga" class="form-label">Total Harga</label>
                    <input type="number" id="total_harga" name="total_harga" class="form-control" step="0.01" min="0" required>
                </div>
                <div class="mb-3">
                    <label for="pelanggan" class="form-label">Pelanggan</label>
                    <input type="text" id="pelanggan" name="pelanggan" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
            </form>
        </div>
    </div>
</div>
@endsection
