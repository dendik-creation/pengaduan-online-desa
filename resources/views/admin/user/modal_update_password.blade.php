<!-- Update Password Modal -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" role="dialog" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content shadow">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title font-weight-bold" id="updatePasswordModalLabel">
                    <i class="fas fa-key mr-2"></i>Update Password
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="updatePasswordForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="password_user_id" name="user_id">
                <div class="modal-body">
                    <div class="alert alert-info border-left-info">
                        <div class="text-info">
                            <i class="fas fa-info-circle fa-lg mr-2"></i>
                            <strong>Informasi:</strong> Anda akan mengubah password untuk user 
                            <span class="font-weight-bold" id="passwordUserName"></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="small mb-1" for="password_new">
                            <i class="fas fa-lock mr-1"></i>Password Baru <span class="text-danger">*</span>
                        </label>
                        <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" 
                               id="password_new" name="password" required minlength="6"
                               placeholder="Masukkan password baru">
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle mr-1"></i>Minimal 6 karakter
                        </small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="small mb-1" for="password_confirmation">
                            <i class="fas fa-lock mr-1"></i>Konfirmasi Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" class="form-control form-control-user @error('password_confirmation') is-invalid @enderror" 
                               id="password_confirmation" name="password_confirmation" required minlength="6"
                               placeholder="Ulangi password baru">
                        <small class="form-text text-muted">
                            <i class="fas fa-shield-alt mr-1"></i>Password harus sama dengan yang di atas
                        </small>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-key mr-1"></i>Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Password confirmation validation
document.addEventListener('DOMContentLoaded', function() {
    const passwordField = document.getElementById('password_new');
    const confirmPasswordField = document.getElementById('password_confirmation');
    
    function validatePassword() {
        if (passwordField.value !== confirmPasswordField.value) {
            confirmPasswordField.setCustomValidity('Password tidak cocok');
        } else {
            confirmPasswordField.setCustomValidity('');
        }
    }
    
    passwordField.addEventListener('input', validatePassword);
    confirmPasswordField.addEventListener('input', validatePassword);
});
</script>