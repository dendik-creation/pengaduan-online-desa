<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title font-weight-bold" id="editUserModalLabel">
                    <i class="fas fa-user-edit mr-2"></i>Edit User
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="editUserForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_user_id" name="user_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="edit_username">
                                    <i class="fas fa-user mr-1"></i>Username <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-user @error('username') is-invalid @enderror" 
                                       id="edit_username" name="username" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="edit_nama_lengkap">
                                    <i class="fas fa-id-card mr-1"></i>Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-user @error('nama_lengkap') is-invalid @enderror" 
                                       id="edit_nama_lengkap" name="nama_lengkap" required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="edit_no_hp">
                                    <i class="fas fa-phone mr-1"></i>No HP <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-user @error('no_hp') is-invalid @enderror" 
                                       id="edit_no_hp" name="no_hp" required>
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="edit_role">
                                    <i class="fas fa-user-tag mr-1"></i>Role <span class="text-danger">*</span>
                                </label>
                                <select class="form-control @error('role') is-invalid @enderror" 
                                        id="edit_role" name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="penduduk">Penduduk</option>
                                    <option value="eksekutor">Eksekutor</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label class="small mb-1" for="edit_alamat">
                            <i class="fas fa-map-marker-alt mr-1"></i>Alamat <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="edit_alamat" name="alamat" rows="3" required></textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-1"></i>Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>