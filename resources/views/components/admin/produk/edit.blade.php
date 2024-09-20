<div class="modal-header">
    <h5 class="modal-title">Edit Produk</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form method="post" action="{{ route('admin.update_produk') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <label for="">Kategori</label>
            <select class="form-select" name="id_kategori" required>
                @foreach($kategori as $r)
                <option value="{{ $r->id }}" {{ $edit->id_kategori == $r->id ? 'selected' : ''}}>{{ $r->nama_kategori }}</option>
                @endforeach
            </select>
            @error("id_kategori")
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="">Nama Produk</label>
            <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" value="{{$edit->nama_produk}}" name="nama_produk" id="nama_produk" placeholder="">
            @error("nama_produk")
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="">Deskripsi</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" rows="8" name="deskripsi" id="deskripsi" placeholder="">{{$edit->deskripsi}}</textarea>
            @error("deskripsi")
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="">Harga jual</label>
            <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" value="{{$edit->harga_jual}}" name="harga_jual" id="harga_jual" placeholder="">
            @error("harga_jual")
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tambahan untuk Berat -->
        <div class="form-group mt-3">
            <label for="">Berat (gram)</label>
            <input type="number" class="form-control @error('berat') is-invalid @enderror" value="{{$edit->berat}}" name="berat" id="berat" placeholder="Masukkan berat dalam gram">
            @error("berat")
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tambahan untuk Kadar (Karat) -->
        <div class="form-group mt-3">
            <label for="">Kadar (Karat)</label>
            <input type="number" class="form-control @error('kadar') is-invalid @enderror" value="{{$edit->kadar}}" name="kadar" id="kadar" placeholder="Masukkan kadar (karat)">
            @error("kadar")
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tambahan untuk Harga per Gram -->
        <div class="form-group mt-3">
            <label for="">Harga per Gram</label>
            <input type="number" class="form-control @error('harga_per_gram') is-invalid @enderror" value="{{$edit->harga_per_gram}}" name="harga_per_gram" id="harga_per_gram" placeholder="Masukkan harga per gram">
            @error("harga_per_gram")
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="">Gambar <small class="text-danger ms-1">* Opsional</small></label>
            <input type="file" class="form-control @error('gambar') is-invalid @enderror" value="{{old('gambar')}}" name="gambar" id="gambar" placeholder="">
            @error("gambar")
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <a href="{{url_images('gambar', $edit->gambar)}}" target="_blank">
                <img src="{{url_images('gambar', $edit->gambar)}}" class="img-fluid mt-3" style="width:80px;">
            </a>
        </div>
        <input type="hidden" value="{{$edit->id}}" name="id">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
