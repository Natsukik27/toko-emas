@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Daftar Transaksi</h1>

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

    <!-- Table for Transaction Management -->
    <div class="card">
        <div class="card-header">
            Transaksi Emas
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jenis Emas</th>
                        <th>Berat (g)</th>
                        <th>Harga per Gram</th>
                        <th>Total Harga</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->produk->nama_produk }}</td>
                            <td>{{ $item->berat }}</td>
                            <td>{{ number_format($item->harga_per_gram, 2, ',', '.') }}</td>
                            <td>{{ number_format($item->total_harga, 2, ',', '.') }}</td>
                            <td>{{ $item->pelanggan }}</td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <div class="d-flex justify-content-between mt-4">
                <div>
                    Showing {{ $transaksi->firstItem() }} to {{ $transaksi->lastItem() }} of {{ $transaksi->total() }} entries
                </div>
                <div>
                    {{ $transaksi->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
