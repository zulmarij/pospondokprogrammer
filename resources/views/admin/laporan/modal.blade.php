
<div id="ubah" class="modal animated zoomInUp custo-zoomInUp" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <form action="{{ route('laporan.index') }}">
                {{-- @csrf --}}
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Tanggal</h5>
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
                        <label for="awal">Tanggal Awal</label>
                        <input type="string" name="awal" class="form-control" id="awal" value="{{ old('awal') }}">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="akhir">Tanggal Akhir</label>
                        <input type="string" name="akhir" class="form-control" id="akhir" value="{{ old('akhir') }}">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
