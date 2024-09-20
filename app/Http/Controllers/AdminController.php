<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use App\Models\GoldPrice;
use App\Models\Transaksi;

class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [
            'title' => 'Admin Toko'
        ];
        
        return view('contents.admin.home', $data);
    }

    // produk
    public function produk(Request $request)
    {
        $reqsearch = $request->get('search');
        $produkdb = Produk::leftJoin('kategori', 'produk.id_kategori', '=', 'kategori.id')
            ->select('kategori.nama_kategori', 'produk.*')
            ->when($reqsearch, function ($query, $reqsearch) {
                $search = '%' . $reqsearch . '%';
                return $query->whereRaw('nama_kategori like ? or nama_produk like ?', [
                    $search,
                    $search
                ]);
            });
        $data = [
            'title'     => 'Data Produk',
            'kategori'  => Kategori::All(),
            'produk'    => $produkdb->latest()->paginate(5),
            'request'   => $request
        ];
        return view('contents.admin.produk', $data);
    }

    public function edit_produk(Request $request)
    {
        $data = [
            'edit' => Produk::findOrFail($request->get('id')),
            'kategori' => Kategori::All(),
        ];
        return view('components.admin.produk.edit', $data);
    }

    // data proses produk 
    public function create_produk(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            "id_kategori"   => "required",
            "gambar"        => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            "nama_produk"   => "required",
            "deskripsi"     => "required",
            "harga_jual"    => "required",
            "berat"         => "required|numeric",
            "kadar"         => "required|numeric",
            "harga_per_gram" => "nullable|numeric",
        ]);

        if ($validator->passes()) {

            $image = $request->file('gambar');
            $input['imagename'] = 'produk_' . time() . '.' . $image->getClientOriginalExtension();

            $destinationPath = storage_path('app/public/gambar');
            $image->move($destinationPath, $input['imagename']);

            Produk::insert([
                'id_kategori'   => $request->get("id_kategori"),
                'gambar'        => $input['imagename'],
                'nama_produk'   => $request->get("nama_produk"),
                'deskripsi'     => $request->get("deskripsi"),
                'harga_jual'    => $request->get("harga_jual"),
                'berat'         => $request->get("berat"),
                'kadar'         => $request->get("kadar"),
                'harga_per_gram' => $request->get("harga_per_gram"),
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
            return redirect()->back()->with("success", " Berhasil Insert Data ! ");
        } else {
            return redirect()->back()->withErrors($validator)->with("failed", " Gagal Insert Data ! ");
        }
    }

    public function update_produk(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            "id"            => "required",
            "id_kategori"   => "required",
            "nama_produk"   => "required",
            "deskripsi"     => "required",
            "harga_jual"    => "required",
            "berat"         => "required|numeric",
            "kadar"         => "required|numeric",
            "harga_per_gram" => "nullable|numeric",
        ]);

        if ($validator->passes()) {
            $produkdb = Produk::findorFail($request->get('id'));
            if ($request->file('gambar')) {
                $validator = \Validator::make($request->all(), [
                    "gambar" => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                if ($validator->passes()) {
                    $image = $request->file('gambar');
                    $input['imagename'] = 'produk_' . time() . '.' . $image->getClientOriginalExtension();

                    $destinationPath = storage_path('app/public/gambar');
                    $image->move($destinationPath, $input['imagename']);
                    $gambar = $input['imagename'];
                } else {
                    return redirect()->back()->withErrors($validator)->with("failed", " Gagal Update Data ! ");
                }
            } else {
                $gambar = $produkdb->gambar;
            }

            $produkdb->update([
                'id_kategori'   => $request->get("id_kategori"),
                'gambar'        => $gambar,
                'nama_produk'   => $request->get("nama_produk"),
                'deskripsi'     => $request->get("deskripsi"),
                'harga_jual'    => $request->get("harga_jual"),
                'berat'         => $request->get("berat"),
                'kadar'         => $request->get("kadar"),
                'harga_per_gram' => $request->get("harga_per_gram"),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);

            return redirect()->back()->with("success", " Berhasil Update Data Produk " . $request->get("nama_produk") . ' !');
        } else {
            return redirect()->back()->withErrors($validator)->with("failed", " Gagal Update Data ! ");
        }
    }

    public function manageStock()
    {
        // Mengambil data produk dan mengatur pagination
        $produk = Produk::paginate(5); // Menampilkan 5 produk per halaman

        // Memeriksa jika stok hampir habis (stok < 5)
        $lowStockItems = []; // Inisialisasi array untuk menampung produk yang stoknya rendah
        foreach ($produk as $item) {
            if ($item->stok < 5) { // Cek jika stok kurang dari 5
                $lowStockItems[] = $item; // Tambahkan produk ke daftar lowStockItems
            }
        }

        return view('contents.admin.stok', compact('produk', 'lowStockItems'));
    }


    public function showGoldPrice()
    {
        $goldPrice = GoldPrice::latest()->first(); // Get the latest price
        return view('contents.admin.home', compact('goldPrice'));
    }



    // Memperbarui stok produk
    public function updateStock(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'stok' => 'required|integer|min:0',
        ]);

        if ($validator->passes()) {
            $produk = Produk::findOrFail($id);
            $produk->stok = $request->input('stok');
            $produk->save();

            return redirect()->route('admin.manageStock')->with('success', 'Stok berhasil diperbarui!');
        } else {
            return redirect()->route('admin.manageStock')->withErrors($validator)->with('failed', 'Gagal memperbarui stok!');
        }
    }

    public function transaksiIndex()
    {
        // Mengambil data transaksi dan mengatur pagination
        $transaksi = Transaksi::with('produk')->paginate(10); // Menampilkan 10 transaksi per halaman
    
        // Mengembalikan view dengan data transaksi
        return view('contents.admin.transaksi.index', compact('transaksi'));
    }

    public function transaksiCreate()
    {
        return view('contents.admin.transaksi.create');
    }

    public function transaksiStore(Request $request)
    {
        // Validasi dan simpan transaksi
        $validated = $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'berat' => 'required|numeric',
            'harga_per_gram' => 'required|numeric',
            'total_harga' => 'required|numeric',
            'pelanggan' => 'required|string|max:255',
        ]);

        Transaksi::create($validated);

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dibuat.');
    }

    public function delete_produk(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect()->back()->with("success", " Berhasil Delete Data Produk ! ");
    }

    // kategori
    public function kategori(Request $request)
    {
        if (!empty($request->get('id'))) {
            $edit = Kategori::findOrFail($request->get('id'));
        } else {
            $edit = '';
        }

        $data = [
            'title'     => 'Data Kategori',
            'kategori'  => Kategori::paginate(5),
            'edit'      => $edit,
            'request'   => $request
        ];
        return view('contents.admin.kategori', $data);
    }

    // data proses kategori
    public function create_kategori(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            "nama_kategori" => "required",
        ]);
        if ($validator->passes()) {
            Kategori::insert([
                'nama_kategori' => $request->get("nama_kategori"),
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
            return redirect()->back()->with("success", " Berhasil Insert Data ! ");
        } else {
            return redirect()->back()->withErrors($validator)->with("failed", " Gagal Insert Data ! ");
        }
    }

    public function update_kategori(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            "id"            => "required",
            "nama_kategori" => "required",
        ]);
        if ($validator->passes()) {
            Kategori::findOrFail($request->get('id'))->update([
                'nama_kategori' => $request->get("nama_kategori"),
                'update_at' => date('Y-m-d H:i:s'),
            ]);
            return redirect()->back()->with("success", " Berhasil Update Data ! ");
        } else {
            return redirect()->back()->withErrors($validator)->with("failed", " Gagal Update Data ! ");
        }
    }


    public function delete_kategori(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect()->back()->with("success", " Berhasil Delete Data ! ");
    }

    // profil
    public function profil(Request $request)
    {
        $data = [
            'title' => 'Data Produk',
            'edit' => User::findOrFail(auth()->user()->id),
            'request' => $request
        ];
        return view('contents.admin.profil', $data);
    }

    // data proses profil
    public function update_profil(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            "name"                  => "required",
            "email"                 => "required",
            "password"              => "required|min:6",
            "password_confirmation" => "required|min:6",
        ]);

        if ($validator->passes()) {
            if ($request->get("password") == $request->get("password_confirmation")) {
                User::findOrFail(auth()->user()->id)->update([
                    'name'          => $request->get("name"),
                    'email'         => $request->get("email"),
                    'phone'         => $request->get("phone"),
                    'address'       => $request->get("address"),
                    'password'      => Hash::make($request->get("password")),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);
                return redirect()->back()->with("success", " Berhasil Update Data ! ");
            } else {
                return redirect()->back()->with("failed", "Confirm Password Tidak Sama !");
            }
        } else {
            return redirect()->back()->withErrors($validator)->with("failed", " Gagal Update Data ! ");
        }
    }
}
