<!-- Edit Pengaduan Modal -->
<div class="modal fade" id="editPengaduanModal" tabindex="-1" role="dialog" aria-labelledby="editPengaduanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title font-weight-bold" id="editPengaduanModalLabel">
                    <i class="fas fa-edit mr-2"></i>Edit Pengaduan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="editPengaduanForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_pengaduan_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="edit_kategori_id"><i class="fas fa-folder mr-1"></i>Kategori <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_kategori_id" name="kategori_id" required>
                                    @foreach(\App\Models\KategoriPengaduan::orderBy('nama')->get() as $kat)
                                        <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="edit_tanggal_pengaduan"><i class="fas fa-calendar mr-1"></i>Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="edit_tanggal_pengaduan" name="tanggal_pengaduan" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1" for="edit_lokasi"><i class="fas fa-map-marker-alt mr-1"></i>Lokasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_lokasi" name="lokasi" required>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1" for="edit_rincian"><i class="fas fa-align-left mr-1"></i>Rincian <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_rincian" name="rincian" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1" for="edit_dokumen"><i class="fas fa-paperclip mr-1"></i>Dokumen (pdf/jpg/png)</label>
                        <input type="file" class="form-control-file" id="edit_dokumen" name="dokumen" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Ukuran maks 2MB.</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fas fa-times mr-1"></i>Batal</button>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i>Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>