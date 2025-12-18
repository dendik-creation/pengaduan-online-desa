<!-- Password Update Form -->
<div class="row">
    <div class="col-12 mx-auto">
        <div class="card border-left-warning shadow-sm">
            <div class="card-header bg-warning text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-key mr-2"></i>Keamanan Password
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update-password') }}" id="passwordForm">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="small mb-1" for="current_password">
                            <i class="fas fa-lock mr-1"></i>Password Saat Ini <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password"
                                   class="form-control form-control-user @error('current_password') is-invalid @enderror"
                                   id="current_password"
                                   name="current_password"
                                   required
                                   placeholder="Masukkan password saat ini">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye" id="toggleCurrentIcon"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small mb-1" for="new_password">
                            <i class="fas fa-key mr-1"></i>Password Baru <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password"
                                   class="form-control form-control-user @error('new_password') is-invalid @enderror"
                                   id="new_password"
                                   name="new_password"
                                   required
                                   minlength="8"
                                   placeholder="Masukkan password baru">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('new_password')">
                                    <i class="fas fa-eye" id="toggleNewIcon"></i>
                                </button>
                            </div>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Strength Indicator -->
                        <div class="progress mt-2" style="height: 5px;">
                            <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small class="form-text text-muted">
                            <span id="strengthText">Minimal 8 karakter</span>
                        </small>
                    </div>

                    <div class="form-group">
                        <label class="small mb-1" for="new_password_confirmation">
                            <i class="fas fa-check-double mr-1"></i>Konfirmasi Password Baru <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password"
                                   class="form-control form-control-user @error('new_password_confirmation') is-invalid @enderror"
                                   id="new_password_confirmation"
                                   name="new_password_confirmation"
                                   required
                                   minlength="8"
                                   placeholder="Ulangi password baru">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('new_password_confirmation')">
                                    <i class="fas fa-eye" id="toggleConfirmIcon"></i>
                                </button>
                            </div>
                            @error('new_password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Match Indicator -->
                        <div class="mt-2">
                            <span id="matchIndicator"></span>
                        </div>
                    </div>

                    <!-- Password Requirements Checklist -->
                    <div class="card bg-light border-0">
                        <div class="card-body py-3">
                            <h6 class="card-title mb-2">
                                <i class="fas fa-list-check"></i>Persyaratan Password:
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled mb-0">
                                        <li id="length-check">
                                            <i class="fas fa-times text-danger mr-2"></i>
                                            <small>Minimal 8 karakter</small>
                                        </li>
                                        <li id="uppercase-check">
                                            <i class="fas fa-times text-danger mr-2"></i>
                                            <small>Huruf besar (A-Z)</small>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled mb-0">
                                        <li id="lowercase-check">
                                            <i class="fas fa-times text-danger mr-2"></i>
                                            <small>Huruf kecil (a-z)</small>
                                        </li>
                                        <li id="number-check">
                                            <i class="fas fa-times text-danger mr-2"></i>
                                            <small>Angka (0-9)</small>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="form-group text-right mt-4">
                        <button type="reset" class="btn btn-secondary mr-2">
                            <i class="fas fa-undo mr-1"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-warning" id="submitBtn" disabled>
                            <i class="fas fa-key mr-1"></i>Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('new_password_confirmation');
    const currentPassword = document.getElementById('current_password');
    const submitBtn = document.getElementById('submitBtn');
    const strengthBar = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('strengthText');
    const matchIndicator = document.getElementById('matchIndicator');

    // Password strength checker
    function checkPasswordStrength(password) {
        let strength = 0;
        let feedback = [];

        // Length check
        if (password.length >= 8) {
            strength += 25;
            updateCheck('length-check', true);
        } else {
            updateCheck('length-check', false);
            feedback.push('minimal 8 karakter');
        }

        // Uppercase check
        if (/[A-Z]/.test(password)) {
            strength += 25;
            updateCheck('uppercase-check', true);
        } else {
            updateCheck('uppercase-check', false);
            feedback.push('huruf besar');
        }

        // Lowercase check
        if (/[a-z]/.test(password)) {
            strength += 25;
            updateCheck('lowercase-check', true);
        } else {
            updateCheck('lowercase-check', false);
            feedback.push('huruf kecil');
        }

        // Number check
        if (/[0-9]/.test(password)) {
            strength += 25;
            updateCheck('number-check', true);
        } else {
            updateCheck('number-check', false);
            feedback.push('angka');
        }

        // Update progress bar
        strengthBar.style.width = strength + '%';
        strengthBar.className = 'progress-bar ';

        if (strength < 50) {
            strengthBar.classList.add('bg-danger');
            strengthText.textContent = 'Lemah - Perlu: ' + feedback.join(', ');
            strengthText.className = 'form-text text-danger';
        } else if (strength < 75) {
            strengthBar.classList.add('bg-warning');
            strengthText.textContent = 'Sedang - Perlu: ' + feedback.join(', ');
            strengthText.className = 'form-text text-warning';
        } else if (strength < 100) {
            strengthBar.classList.add('bg-info');
            strengthText.textContent = 'Baik - Perlu: ' + feedback.join(', ');
            strengthText.className = 'form-text text-info';
        } else {
            strengthBar.classList.add('bg-success');
            strengthText.textContent = 'Sangat Kuat';
            strengthText.className = 'form-text text-success';
        }

        return strength;
    }

    // Update checklist items
    function updateCheck(elementId, isValid) {
        const element = document.getElementById(elementId);
        const icon = element.querySelector('i');

        if (isValid) {
            icon.className = 'fas fa-check text-success mr-2';
        } else {
            icon.className = 'fas fa-times text-danger mr-2';
        }
    }

    // Password match checker
    function checkPasswordMatch() {
        if (confirmPassword.value === '') {
            matchIndicator.innerHTML = '';
            return false;
        }

        if (newPassword.value === confirmPassword.value) {
            matchIndicator.innerHTML = '<small class="text-success"><i class="fas fa-check mr-1"></i>Password cocok</small>';
            confirmPassword.classList.remove('is-invalid');
            confirmPassword.classList.add('is-valid');
            return true;
        } else {
            matchIndicator.innerHTML = '<small class="text-danger"><i class="fas fa-times mr-1"></i>Password tidak cocok</small>';
            confirmPassword.classList.add('is-invalid');
            confirmPassword.classList.remove('is-valid');
            return false;
        }
    }

    // Form validation
    function validateForm() {
        const hasCurrentPassword = currentPassword.value.length > 0;
        const passwordStrength = checkPasswordStrength(newPassword.value);
        const passwordsMatch = checkPasswordMatch();

        if (hasCurrentPassword && passwordStrength >= 75 && passwordsMatch) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('btn-secondary');
            submitBtn.classList.add('btn-warning');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('btn-secondary');
            submitBtn.classList.remove('btn-warning');
        }
    }

    // Event listeners
    newPassword.addEventListener('input', function() {
        checkPasswordStrength(this.value);
        if (confirmPassword.value) {
            checkPasswordMatch();
        }
        validateForm();
    });

    confirmPassword.addEventListener('input', function() {
        checkPasswordMatch();
        validateForm();
    });

    currentPassword.addEventListener('input', validateForm);

    // Form submit validation
    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        const strength = checkPasswordStrength(newPassword.value);
        const match = checkPasswordMatch();

        if (strength < 75) {
            e.preventDefault();
            alert('Password terlalu lemah! Password harus memenuhi minimal 3 dari 4 kriteria keamanan!');
            return;
        }

        if (!match) {
            e.preventDefault();
            alert('Konfirmasi password tidak sesuai dengan password baru!');
            return;
        }
    });
});

// Toggle password visibility
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    let iconId;

    // Map field IDs to their corresponding icon IDs
    switch(fieldId) {
        case 'current_password':
            iconId = 'toggleCurrentIcon';
            break;
        case 'new_password':
            iconId = 'toggleNewIcon';
            break;
        case 'new_password_confirmation':
            iconId = 'toggleConfirmIcon';
            break;
        default:
            return;
    }

    const icon = document.getElementById(iconId);

    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
