@extends('layouts/master');

@section('title')
    Produk
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Produk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header with-border">
                    <div class="btn-group">

                        <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success btn-xs  mr-1"><i
                                class="fa fa-plus-circle"></i> Tambah</button>
                        <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')"
                            class="btn btn-danger btn-xs mr-1"><i class="fa fa-Trash"></i>
                            Hapus</button>
                        <button onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')"
                            class="btn btn-info btn-xs "><i class="fa fa-barcode"></i>
                            Cetak Barcode</button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <form action="" method="post" class="form-produk">
                        @csrf
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <th>
                                    <input type="checkbox" name="select_all" id="select_all">
                                </th>
                                <th width="5%">No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Merk</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Diskon</th>
                                <th>Stok</th>
                                <th width="15%"><i class="fa fa-cog"></i></th>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @includeIf('produk.form');
@endsection

@push('scripts')
    <script>
        let table; //variable table untuk memudahkan reload table di function lain
        $(function() { //mengisi datatables
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('produk.data') }}',
                },
                columns: [ //mengisi kolom datatables
                    {
                        data: 'select_all'
                    },
                    {
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'kode_produk'
                    },
                    {
                        data: 'nama_produk'
                    },
                    {
                        data: 'nama_kategori'
                    },
                    {
                        data: 'merk'
                    },
                    {
                        data: 'harga_beli'
                    },
                    {
                        data: 'harga_jual'
                    },
                    {
                        data: 'diskon'
                    },
                    {
                        data: 'stock'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            }); //mengisi datatables


            $('#modal-form').validator().on('submit', function(e) { //post data ke controller
                if (!e.preventDefault()) { //preventDefault agar tidak merefresh halaman
                    $.post($('#modal-form form').attr('action'), $('#modal-form form')
                            .serialize()) //post hasil serialize jquery
                        .done((response) => {
                            $('#modal-form').modal('hide'); // hide modal jika berhasil
                            table.ajax.reload(); //realod table jika berhasil
                        })
                        .fail((errors) => {
                            alert('Tidak dapat menyimpan data'); //tampilkan alert jika gagal
                            return;
                        });
                }
            });

            $('[name=select_all]').on('click', function() { //fungsi untuk cheklis semua ketika select_all di klik
                $(':checkbox').prop('checked', this.checked);
                //Get the value of a property for the first element in the set of matched elements.
                // param kedua dari props nya yaitu value nya
            });
        })

        function addForm(url) { // fungsi tambah data 
            $('#modal-form').modal('show'); //show modal
            $('#modal-form .modal-title').text('Tambah Produk'); //tambahkan text ke modal
            $('#modal-form form')[0].reset(); //modal di reset
            $('#modal-form form').attr('action', url); //atribut action di isi dengan route
            //POST-------------------produk----------------produk.store › ProdukController@store
            $('#modal-form [name=_method').val('post'); //isi method form dengan post untuk mengirim isi form
            $('#modal-form [name=nama_produk]').focus(); //modal terbuka dan langsung fokus pada isian pertama
        }


        function editForm(url) { //fungsi edit
            $('#modal-form').modal('show'); //tampilkan modal
            $('#modal-form .modal-title').text('Edit Produk'); //isi title dengan text edit prodak
            $('#modal-form form')[0].reset(); //rest modal 
            $('#modal-form form').attr('action', url); //atribut action di isi dengan route
            $('#modal-form [name=_method]').val('put'); //isi method pada form put untuk proses update 
            $('#modal-form [name=nama_produk]').focus(); //modal terbuka dan langsung fokus pada isian pertama
            $.get(url) //get data berdasarkan url urlnya produk/id_produk jadi akan mengeksekusi produk.show
                // GET|HEAD--------produk/{produk}---------------produk.show › ProdukController@show  
                .done((response) => { //hasil get berupa promise ketika done makan akses param response untuk datanya
                    $('#modal-form [name=nama_produk]').val(response
                        .nama_produk
                    ); //contoh $(select element dengan name nama_produk).isi dengan value(response ajax.nama_produk)
                    $('#modal-form [name=id_kategori]').val(response.id_kategori);
                    $('#modal-form [name=merk]').val(response.merk);
                    $('#modal-form [name=harga_beli]').val(response.harga_beli);
                    $('#modal-form [name=harga_jual]').val(response.harga_jual);
                    $('#modal-form [name=diskon]').val(response.diskon);
                    $('#modal-form [name=stock]').val(response.stock);
                }) // format $(dom).function 
                .fail((errors) => { //jika promise gagal tampilkan error
                    alert('Tidak dapat menampilkan data');
                    return;
                });
        }

        function deleteData(url) { //fungsi delete
            if (confirm('Yakin ingin menghapus data terpilih?')) { //tampilkan confirm sebelum malakukan proses delete
                $.post(url, { //post berdasarkan url yang di hasilkan dari route
                        // DELETE---- produk/{produk}------- produk.destroy › ProdukController@destroy
                        //object di bawah dikirim beserta perintah delete
                        '_token': $('[name=csrf-token]').attr(
                            'content'), //token csrf agar data bisa di hapus sesuai token
                        '_method': 'delete' //method delete di definisikan agar route yang di jalankan yang delete

                    })
                    .done((response) => {
                        table.ajax.reload(); //jika berhasil reload table datatables
                    })
                    .fail((errors) => { //tampilkan error jika gagal
                        alert('Tidak dapat menghapus data');
                        return;
                    });
            }
        }

        function deleteSelected(url) {
            if ($('input:checked').length >= 1) { //pilih data 1 atau lebih
                if (confirm('yakin ingin menghapus data terpilih?')) {
                    $.post(url, $('.form-produk').serialize()) //data di delete berdasarkan id yang di pilih
                        .done((response) => {
                            table.ajax.reload(); //reload ketika proses berhasil
                        })
                        .fail((errors) => {
                            alert('tidak dapat menghapus data')
                            return;
                        })
                }
            } else {
                alert('pilih data yang akan dihapus');
                retrun;
            }
        }

        function cetakBarcode(url) {
            if ($('input:checked').length < 1) { //jika tidak ada yang di pilih tampil alert di bawah
                alert('pilih data yang akan dicetak');
                retrun;
            } else if ($('input:checked').length < 3) { // data minimal di pilih sebanyak 3 row
                alert('pilih minimal 3 data untuk di cetak');
                retrun;
            } else {
                $('.form-produk')
                    .attr('action', url)
                    .attr('target', '_blank')
                    .submit();
            }
        }
    </script>
@endpush
