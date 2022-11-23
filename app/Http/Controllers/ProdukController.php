<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;



class ProdukController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // controller index mengirim data untuk di gunakan di form bagian select jadi data drop down dinamis dari db
        //kategori get all data tapi di pluck untuk mengambil data nama ketegorinya saja (kategori dan key dalam bentuk array assosiatif)
        // ['1' => 'makanan', '2' => 'minuman']
        $kategori = kategori::all()->pluck('nama_kategori', 'id_kategori');
        //return menampilkan route index pada controller produk sekaligus hasil dari query pluck yang ada di variable $kategori masuk ke compact untuk memasukan datanya ke tampilan
        return view('produk.index', compact('kategori'));
    }

    public function data()
    {   //controller data mengirim data ke datatables yang ada di produk.index view 
        //left join untuk menampilkan data kategori pada table secara dinamis sesuai dengan relasi
        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
            //select nama kategori pada table produk
            ->select('produk.*', 'nama_kategori')
            //urutkan hasil query berdasarkan kode produk secara ascending dari yang terkecil
            ->orderBy('kode_produk', 'asc')->get();
        // $produk di gunakan pada function datatables untuk di masukan ke table datatables
        return datatables()
            //of table produk
            ->of($produk)
            //tambah index kolom
            ->addIndexColumn()
            // add kolom untuk kode produk di baluk menggunakan span untuk styling
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" name="id_produk[]" value="' . $produk->id_produk . '">
                ';
            }) // add kolom untuk harga beli menggunakan format uang yang ada di helper
            ->addColumn('kode_produk', function ($produk) {
                return '<span class="badge badge-success">' . $produk->kode_produk . '</span>';
            }) // add kolom untuk harga beli menggunakan format uang yang ada di helper
            ->addColumn('harga_beli', function ($produk) {
                return format_uang($produk->harga_beli);
            })
            ->addColumn('harga_jual', function ($produk) {
                return format_uang($produk->harga_jual);
            })
            ->addColumn('stock', function ($produk) {
                return format_uang($produk->stock);
            }) //tambah kolom aksi untuk mereturn tombol edit dan delete
            ->addColumn('aksi', function ($produk) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`' . route('produk.update', $produk->id_produk) . '`)" class="btn btn-xs btn-info btn-flat mr-1"><i class="fa 
                   
                    fa-edit"></i>Edit</button>
                    <button type="button" onclick="deleteData(`' . route('produk.destroy', $produk->id_produk) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i>Hapus</button>
                </div>
                ';
                //agar tombol edit bisa di eksekusi maka wajib menggunakan type="button" !yes error alasan perlu di selidiki lebih jauh
            })
            //raw kolom untuk kolom yang return html css agar hasil response berupa element html bukan raw text
            ->rawColumns(['aksi', 'kode_produk', 'select_all'])
            //The static make method creates a new collection instance baca dokumentasi
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //controller store untuk menyimpan data ke mysql
        // ambil data produk yang terbaru atau data baru produk ?? (atau)
        $produk = Produk::latest()->first() ?? new Produk();
        //request untuk index kode produk di tambah dengan P concat tambah no di depan sebanyak 6 kali dan id produk+1 (P000001)
        $request['kode_produk'] = 'P' . tambah_nol_didepan((int)$produk->id_produk + 1, 6);
        //static method create untuk menambahkan data baru ke database
        //untuk data yang di masukan yaitu all request atau semua yang di post oleh ajax
        $produk = Produk::create($request->all());

        return response()->json('data berhasil di simpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //contoller show untuk mengirim data berdasarkan id.. contohnya untuk malakukan editing maka butuh satu id untuk melakukan proses edit
        $produk = Produk::find($id);

        return response()->json($produk);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //route produk/{produk}/edit mengeksekusi kontroller produk.edit jadi tidak di gunakan
        // untuk menampilkan data berdasarkan id untuk edit menggunakan query dari produk.show
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
        $produk = Produk::find($id);
        $produk->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $produk->delete();
        }

        return response(null, 204);
    }

    public function cetakBarcode(Request $request)
    {
        $dataProduk = array(); //menyiapkan data berbentuk array
        foreach ($request->id_produk as $id) { //iterasi request lebih dari 1 dan mengambil data id_produk
            $produk = Produk::find($id); //query semua data berdasarkan id yang sudah di dapat
            $dataProduk[] = $produk;
        }
        $no = 1;
        $pdf = PDF::loadView('produk.barcode', compact('dataProduk', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('produk');
    }
}
