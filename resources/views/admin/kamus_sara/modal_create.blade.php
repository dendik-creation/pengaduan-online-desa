<!-- Create Kata Modal -->
<div class="modal fade" id="createKataModal" tabindex="-1" role="dialog" aria-labelledby="createKataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold" id="createKataModalLabel">
                    <i class="fas fa-book-medical mr-2"></i>Tambah Kata SARA
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('kamus-sara.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="small mb-1" for="kata">
                            <i class="fas fa-font mr-1"></i>Kata <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('kata') is-invalid @enderror" id="kata" name="kata" value="{{ old('kata') }}" placeholder="Masukkan kata" required>
                        @error('kata')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>Simpan Kata
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>