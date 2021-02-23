@foreach ($barangs as $barang)
<div id="update-{{$barang->id}}" class="modal animated zoomInUp custo-zoomInUp" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <form action="{{ route('barang.update', $barang) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="form-control" id="nama" value="{{ $barang->nama ?? old('nama') }}">
                    </div>
                    <div class="form-group mb-4">
                        <label for="uid">UID</label>
                        <input type="number" name="uid" class="form-control" id="uid" value="{{ $barang->uid ?? old('uid') }}">
                    </div>
                    <div class="form-row mb-4">
                        <div class="form-group col-md-6">
                            <label for="harga_beli">Harga Beli</label>
                            <input type="number" name="harga_beli" class="form-control" id="harga_beli"
                                value="{{ $barang->harga_beli ?? old('harga_beli') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="harga_jual">Harga Jual</label>
                            <input type="number" name="harga_jual" class="form-control" id="harga_jual"
                                value="{{ $barang->harga_jual ?? old('harga_jual') }}">
                        </div>
                    </div>
                    <div class="form-row mb-4">
                        <div class="form-group col-md-6">
                            <label for="merk">Merk</label>
                            <input type="text" name="merk" class="form-control" id="merk"
                                value="{{ $barang->merk ?? old('merk') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kategori_id">Kategori</label>
                            <select id="kategori_id" name="kategori_id" class="form-control">
                                @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row mb-4">
                        <div class="form-group col-md-6">
                            <label for="stok">Stok</label>
                            <input type="number" name="stok" class="form-control" id="stok"
                                value="{{ $barang->stok ?? old('stok') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="diskon">Diskon</label>
                            <input type="number" name="diskon" class="form-control" id="diskon"
                                value="{{ $barang->diskon ?? old('diskon') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal modal-notification animated zoomInUp custo-zoomInUp" id="delete-{{$barang->id}}" tabindex="-1"
    role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" id="deleteLabel">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="icon-content">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-bell">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                </div>
                <p class="modal-text">Apakah anda yakin ingin menghapus ini?.</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Tidak</button>
                <form method="POST" action="{{ route('barang.destroy', $barang) }}">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="btn btn-primary">Ya</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
