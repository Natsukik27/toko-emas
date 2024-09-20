@extends('layouts.frontend')

@section('content')
    <div class="container mt-5">
        <!-- Check for success message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-sm-9 mx-auto">
                <!-- Product Details -->
                <div class="product">
                    <h4 class="mb-4"><b>{{ $title }}</b></h4>
                    <div class="row">
                        <div class="col-sm-4">
                            <img src="{{ url_images('gambar', $edit->gambar) }}" class="img-fluid w-100 mb-3">
                        </div>
                        <div class="col-sm-8 detail-produk">
                            <div class="row mt-3">
                                <div class="col-sm-4"><b>Kategori</b></div>
                                <div class="col-sm-8">
                                    <a class="text-produk" href="{{ url('kategori/' . $edit->id) }}">
                                        {{ $edit->nama_kategori }}
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4"><b>Nama Produk</b></div>
                                <div class="col-sm-8">{{ $edit->nama_produk }}</div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4"><b>Harga jual</b></div>
                                <div class="col-sm-8 text-success">
                                    <h4><b>Rp{{ number_format($edit->harga_jual) }},-</b></h4>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4"><b>Berat</b></div>
                                <div class="col-sm-8">{{ $edit->berat }} gram</div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4"><b>Kadar (Karat)</b></div>
                                <div class="col-sm-8">{{ $edit->kadar }}K</div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4"><b>Harga per Gram</b></div>
                                <div class="col-sm-8">Rp{{ number_format($edit->harga_per_gram, 0, ',', '.') }}</div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4"><b>Deskripsi</b></div>
                                <div class="col-sm-8">{{ $edit->deskripsi }}</div>
                            </div>
                            <!-- New Stock Info -->
                            <div class="row mt-3">
                                <div class="col-sm-4"><b>Stok</b></div>
                                <div class="col-sm-8">{{ $edit->stok }} unit</div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4"><b></b></div>
                                <div class="col-sm-8">
                                    <button class="btn btn-success btn-md" id="openPurchaseForm">
                                        <i class="fas fa-shopping-cart"></i> Beli Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Purchase Form -->
                    <div id="purchaseForm" style="display: none;" class="mt-4">
                        <div class="card">
                            <div class="card-header">
                                Form Pembelian
                            </div>
                            <div class="card-body">
                                <form action="{{ route('transaksi.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $edit->id }}">
                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">Jumlah</label>
                                        <input type="number" id="jumlah" name="jumlah" class="form-control"
                                            step="1" min="1" max="{{ $edit->stok }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="berat" class="form-label">Berat per Unit (g)</label>
                                        <input type="number" id="berat" name="berat" class="form-control"
                                            value="{{ $edit->berat }}" step="0.01" min="0" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="harga_per_gram" class="form-label">Harga per Gram</label>
                                        <input type="number" id="harga_per_gram" name="harga_per_gram" class="form-control"
                                            value="{{ $edit->harga_per_gram }}" step="0.01" min="0" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="total_harga" class="form-label">Total Harga</label>
                                        <input type="number" id="total_harga" name="total_harga" class="form-control"
                                            step="0.01" min="0" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pelanggan" class="form-label">Nama Pelanggan</label>
                                        <input type="text" id="pelanggan" name="pelanggan" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Kirim Pesanan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('javascript')
        <script>
            document.getElementById('openPurchaseForm').addEventListener('click', function() {
                var form = document.getElementById('purchaseForm');
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            });

            document.getElementById('jumlah').addEventListener('input', function() {
                var jumlah = parseInt(this.value) || 0;
                var berat = parseFloat(document.getElementById('berat').value) || 0;
                var hargaPerGram = parseFloat(document.getElementById('harga_per_gram').value) || 0;
                var totalHarga = jumlah * berat * hargaPerGram;
                document.getElementById('total_harga').value = totalHarga.toFixed(2);
            });
        </script>
    @endsection
