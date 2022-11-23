<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="#" method="post" class="form-horizontal">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row justify-content-md-center align-items-center">
                        <label for="nama_produk" class="col-md-2 md-offset-1">Nama</label>
                        <div class="col-md-8">
                            <input type="text" name="nama_produk" id="nama_produk"
                                class="form-control form-control-sm" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row justify-content-md-center align-items-center">
                        <label for="id_kategori" class="col-md-2 md-offset-1">Kategori</label>
                        <div class="col-md-8">
                            <select name="id_kategori" id="id_kategori" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                <!--hasil pluck dari controller produk.index di iterasi di sini-->
                                @foreach ($kategori as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row justify-content-md-center align-items-center">
                        <label for="merk" class="col-md-2 md-offset-1">Merk</label>
                        <div class="col-md-8">
                            <input type="text" name="merk" id="merk" class="form-control form-control-sm"
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row justify-content-md-center align-items-center">
                        <label for="harga_beli" class="col-md-2 md-offset-1">Harga Beli</label>
                        <div class="col-md-8">
                            <input type="number" name="harga_beli" id="harga_beli" class="form-control form-control-sm"
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row justify-content-md-center align-items-center">
                        <label for="harga_jual" class="col-md-2 md-offset-1">Harga Jual</label>
                        <div class="col-md-8">
                            <input type="number" name="harga_jual" id="harga_jual" class="form-control form-control-sm"
                                required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row justify-content-md-center align-items-center">
                        <label for="diskon" class="col-md-2 md-offset-1">Diskon</label>
                        <div class="col-md-8">
                            <input type="number" name="diskon" id="diskon" class="form-control form-control-sm"
                                autofocus value="0">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row justify-content-md-center align-items-center">
                        <label for="stock" class="col-md-2 md-offset-1">Stock</label>
                        <div class="col-md-8">
                            <input type="number" name="stock" id="stock" class="form-control form-control-sm"
                                autofocus required value="0">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    <button type="submit" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
