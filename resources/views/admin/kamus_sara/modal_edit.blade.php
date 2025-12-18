<!-- Edit Kata Modal -->
<div class="modal fade" id="editKataModal" tabindex="-1" role="dialog" aria-labelledby="editKataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content shadow">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title font-weight-bold" id="editKataModalLabel">
                    <i class="fas fa-edit mr-2"></i>Edit Kata SARA
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="editKataForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_kata_id" name="kata_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="small mb-1" for="edit_kata">
                            <i class="fas fa-font mr-1"></i>Kata <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('kata') is-invalid @enderror" id="edit_kata" name="kata" required>
                        @error('kata')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-1"></i>Update Kata
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>