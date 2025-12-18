<!-- Profile Update Form -->
<div class="row">
    <div class="col-12 mx-auto">
        <div class="card border-left-primary shadow-sm">
            <div class="card-header bg-primary text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-user-edit mr-2"></i>Informasi Profil
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="username">
                                    <i class="fas fa-user mr-1"></i>Username <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control form-control-user @error('username') is-invalid @enderror"
                                       id="username"
                                       name="username"
                                       value="{{ old('username', $user->username) }}"
                                       required
                                       placeholder="Masukkan username">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="nama_lengkap">
                                    <i class="fas fa-id-card mr-1"></i>Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control form-control-user @error('nama_lengkap') is-invalid @enderror"
                                       id="nama_lengkap"
                                       name="nama_lengkap"
                                       value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                                       required
                                       placeholder="Masukkan nama lengkap">
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="no_hp">
                                    <i class="fas fa-phone mr-1"></i>No HP <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control form-control-user @error('no_hp') is-invalid @enderror"
                                       id="no_hp"
                                       name="no_hp"
                                       value="{{ old('no_hp', $user->no_hp) }}"
                                       required
                                       placeholder="Masukkan nomor HP">
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="role">
                                    <i class="fas fa-user-tag mr-1"></i>Role
                                </label>
                                <input type="text"
                                       class="form-control form-control-user"
                                       value="{{ ucfirst($user->role) }}"
                                       readonly
                                       disabled>
                                <small class="form-text text-muted">
                                    <i class="fas fa-lock mr-1"></i>Role tidak dapat diubah
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small mb-1" for="alamat">
                            <i class="fas fa-map-marker-alt mr-1"></i>Alamat <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror"
                                  id="alamat"
                                  name="alamat"
                                  rows="4"
                                  required
                                  placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="form-group text-right">
                        <button type="reset" class="btn btn-secondary mr-2">
                            <i class="fas fa-undo mr-1"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>Update Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.getElementById('no_hp');
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');

        if (value.length > 15) {
            value = value.slice(0, 15);
        }

        e.target.value = value;
    });

    document.getElementById('profileForm').addEventListener('submit', function(e) {
        let isValid = true;
        const requiredFields = ['username', 'nama_lengkap', 'no_hp', 'alamat'];

        requiredFields.forEach(function(fieldId) {
            const field = document.getElementById(fieldId);
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            if (window.innerWidth <= 768) {
                toastResult("top", "center", "Mohon lengkapi field form yang ada", "error")
            } else {
                toastResult("bottom", "right", "Mohon lengkapi field form yang ada", "error")
            }
        }
    });
});
</script>
