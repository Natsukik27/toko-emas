@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Manajemen Stok Emas</h1>

        <!-- Notifikasi stok rendah -->
        @if (count($lowStockItems) > 0)
            <div class="alert alert-warning">
                <strong>Peringatan:</strong> Ada beberapa produk dengan stok rendah (di bawah 5):
                <ul>
                    @foreach ($lowStockItems as $item)
                        <li>{{ $item->nama_produk }} - Sisa stok: {{ $item->stok }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Add Product Button -->
        <a href="{{ route('admin.produk') }}" class="btn btn-primary mb-4">Tambah Produk Baru</a>

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

        <!-- Table for Stock Management -->
        <div class="card">
            <div class="card-header">
                Daftar Produk
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Berat (g)</th>
                            <th>Kadar (Karat)</th>
                            <th>Harga per Gram</th>
                            <th>Stok Tersedia</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $item)
                            <tr>
                                <td><img src="{{ asset('storage/gambar/' . $item->gambar) }}" alt="{{ $item->nama_produk }}"
                                        class="img-thumbnail" width="100"></td>
                                <td>{{ $item->nama_produk }}</td>
                                <td>{{ $item->berat }}</td>
                                <td>{{ $item->kadar }}</td>
                                <td>{{ number_format($item->harga_per_gram, 0, ',', '.') }}</td>

                                <!-- Kondisi untuk stok rendah -->
                                <td class="{{ $item->stok <= 5 ? 'text-danger' : '' }}">
                                    {{ $item->stok }}
                                </td>

                                <td>
                                    <form action="{{ route('admin.updateStock', $item->id) }}" method="POST">
                                        @csrf
                                        <input type="number" name="stok" value="{{ $item->stok }}" min="0"
                                            class="form-control" />
                                        <button type="submit" class="btn btn-primary mt-2">Update</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination Controls -->
                <div class="d-flex justify-content-between mt-4">
                    <div>
                        Showing {{ $produk->firstItem() }} to {{ $produk->lastItem() }} of {{ $produk->total() }} entries
                    </div>
                    <div>
                        {{ $produk->links() }} <!-- Laravel's pagination links -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .img-thumbnail {
            border: 1px solid #ddd;
            border-radius: .25rem;
            padding: .25rem;
            background-color: #fff;
        }

        /* Highlight stok rendah */
        .text-danger {
            color: red;
            font-weight: bold;
        }
    </style>
@endsection
