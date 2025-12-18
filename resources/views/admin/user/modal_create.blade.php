<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold" id="createUserModalLabel">
                    <i class="fas fa-user-plus mr-2"></i>Tambah User Baru
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="username">
                                    <i class="fas fa-user mr-1"></i>Username <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-user @error('username') is-invalid @enderror" 
                                       id="username" name="username" value="{{ old('username') }}" 
                                       placeholder="Masukkan username" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="password">
                                    <i class="fas fa-lock mr-1"></i>Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Minimal 6 karakter" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="nama_lengkap">
                                    <i class="fas fa-id-card mr-1"></i>Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-user @error('nama_lengkap') is-invalid @enderror" 
                                       id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" 
                                       placeholder="Masukkan nama lengkap" required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="no_hp">
                                    <i class="fas fa-phone mr-1"></i>No HP <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-user @error('no_hp') is-invalid @enderror" 
                                       id="no_hp" name="no_hp" value="{{ old('no_hp') }}" 
                                       placeholder="Contoh: 081234567890" required>
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="role">
                                    <i class="fas fa-user-tag mr-1"></i>Role <span class="text-danger">*</span>
                                </label>
                                <select class="form-control @error('role') is-invalid @enderror" 
                                        id="role" name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="penduduk" {{ old('role') == 'penduduk' ? 'selected' : '' }}>Penduduk</option>
                                    <option value="eksekutor" {{ old('role') == 'eksekutor' ? 'selected' : '' }}>Eksekutor</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="small mb-1" for="alamat">
                            <i class="fas fa-map-marker-alt mr-1"></i>Alamat <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="3" 
                                  placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>