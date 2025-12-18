<!-- Edit Kategori Modal -->
<div class="modal fade" id="editKategoriModal" tabindex="-1" role="dialog" aria-labelledby="editKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content shadow">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title font-weight-bold" id="editKategoriModalLabel">
                    <i class="fas fa-edit mr-2"></i>Edit Kategori Pengaduan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="editKategoriForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_kategori_id" name="kategori_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="small mb-1" for="edit_nama">
                            <i class="fas fa-tag mr-1"></i>Nama <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="edit_nama" name="nama" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="small mb-1" for="edit_deskripsi">
                            <i class="fas fa-align-left mr-1"></i>Deskripsi
                        </label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-1"></i>Update Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>