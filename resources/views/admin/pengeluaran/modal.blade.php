@foreach ($pengeluarans as $pengeluaran)
<div id="update-{{$pengeluaran->id}}" class="modal animated zoomInUp custo-zoomInUp" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form action="{{ route('pengeluaran.update', $pengeluaran) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ubah pengeluaran</h5>
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
                        <label for="tipe">Tipe</label>
                        <input type="text" name="tipe" class="form-control" id="tipe"
                            value="{{ $pengeluaran->tipe ?? old('tipe') }}">
                    </div>
                    <div class="form-group mb-4">
                        <label for="biaya">biaya</label>
                        <input type="number" name="biaya" class="form-control" id="biaya"
                            value="{{ $pengeluaran->biaya ?? old('biaya') }}">
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

<div class="modal modal-notification animated zoomInUp custo-zoomInUp" id="delete-{{$pengeluaran->id}}" tabindex="-1"
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
                <form method="POST" action="{{ route('pengeluaran.destroy', $pengeluaran) }}">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="btn btn-primary">Ya</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
