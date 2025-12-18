@extends('layout.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Master User</li>
                </ol>
            </nav>
        </div>
        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"
            data-target="#createUserModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah User
        </button>
    </div>

    @include('partials.toaster')

    <!-- Search Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="{{ route('users.index') }}" class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" 
                                   name="search" placeholder="Cari username, nama lengkap, atau no HP..." 
                                   value="{{ $search }}" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-sm" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if($search)
                                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center" width="5%">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col" class="text-center" width="12%">Role</th>
                            <th scope="col">No HP</th>
                            <th scope="col">Alamat</th>
                            <th scope="col" class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="font-weight-bold">{{ $user->username }}</td>
                                <td>{{ $user->nama_lengkap }}</td>
                                <td class="text-center">
                                    @if ($user->role == 'admin')
                                        <span class="badge badge-primary badge-pill">Admin</span>
                                    @elseif($user->role == 'penduduk')
                                        <span class="badge badge-success badge-pill">Penduduk</span>
                                    @else
                                        <span class="badge badge-info badge-pill">Eksekutor</span>
                                    @endif
                                </td>
                                <td>
                                    <i class="fas fa-phone fa-sm text-gray-400 mr-1"></i>
                                    {{ $user->no_hp }}
                                </td>
                                <td>
                                    <i class="fas fa-map-marker-alt fa-sm text-gray-400 mr-1"></i>
                                    {{ Str::limit($user->alamat, 40) }}
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning btn-circle btn-sm mr-1"
                                        onclick="editUser({{ $user->id }}, '{{ $user->username }}', '{{ $user->nama_lengkap }}', '{{ $user->alamat }}', '{{ $user->no_hp }}', '{{ $user->role }}')"
                                        data-toggle="modal" data-target="#editUserModal" title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-info btn-circle btn-sm mr-1"
                                        onclick="updatePassword({{ $user->id }}, '{{ $user->nama_lengkap }}')"
                                        data-toggle="modal" data-target="#updatePasswordModal" title="Update Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-circle btn-sm"
                                        onclick="deleteUser({{ $user->id }}, '{{ $user->nama_lengkap }}')"
                                        title="Hapus User">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-users fa-2x mb-2 text-gray-300"></i><br>
                                    Tidak ada data user yang ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @include('partials.paginator', ['paginator' => $users])
        </div>
    </div>

    {{-- Include Modals --}}
    @include('admin.user.modal_create')
    @include('admin.user.modal_edit')
    @include('admin.user.modal_update_password')

    {{-- Delete Confirmation Modal --}}
    @include('partials.confirm_modal', [
        'modal_id' => 'deleteUserModal',
        'modal_title' => 'Konfirmasi Hapus User',
        'modal_description' => 'Apakah Anda yakin ingin menghapus user <span id="deleteUserName" class="font-weight-bold text-danger"></span>?',
        'form_action' => '#',
        'form_method' => 'DELETE',
        'confirm_button_text' => 'Hapus User',
        'confirm_button_class' => 'btn-danger',
        'confirm_button_icon' => 'fas fa-trash',
        'cancel_button_text' => 'Batal',
        'title_icon' => 'fas fa-user-times',
        'body_icon' => 'fas fa-exclamation-triangle fa-3x text-danger',
        'header_class' => 'bg-danger text-white',
        'additional_info' => 'Tindakan ini tidak dapat dibatalkan. Semua data yang terkait dengan user ini akan ikut terhapus.'
    ])

    <script>
        $(document).ready(function() {
            // Search with Enter key
            $('input[name="search"]').on('keypress', function(e) {
                if (e.which === 13) { // Enter key
                    $(this).closest('form').submit();
                }
            });

            // Loading state for search button
            $('form').on('submit', function() {
                var submitBtn = $(this).find('button[type="submit"]');
                var originalText = submitBtn.html();
                submitBtn.html('<i class="fas fa-spinner fa-spin fa-sm"></i>');
                submitBtn.prop('disabled', true);

                // Re-enable after a short delay (in case of quick back navigation)
                setTimeout(function() {
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);
                }, 2000);
            });

            // Loading state for pagination links
            $('.pagination a').on('click', function() {
                var $this = $(this);
                if (!$this.parent().hasClass('disabled') && !$this.parent().hasClass('active')) {
                    $this.html('<i class="fas fa-spinner fa-spin fa-sm"></i>');
                }
            });
        });

        function editUser(id, username, nama_lengkap, alamat, no_hp, role) {
            document.getElementById('edit_user_id').value = id;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_nama_lengkap').value = nama_lengkap;
            document.getElementById('edit_alamat').value = alamat;
            document.getElementById('edit_no_hp').value = no_hp;
            document.getElementById('edit_role').value = role;
            document.getElementById('editUserForm').action = '/admin/users/' + id;
        }

        function updatePassword(id, nama_lengkap) {
            document.getElementById('password_user_id').value = id;
            document.getElementById('passwordUserName').textContent = nama_lengkap;
            document.getElementById('updatePasswordForm').action = '/admin/users/' + id + '/update-password';
        }

        function deleteUser(id, nama_lengkap) {
            document.getElementById('deleteUserName').textContent = nama_lengkap;
            document.getElementById('deleteUserModalForm').action = '/admin/users/' + id;
            $('#deleteUserModal').modal('show');
        }
    </script>
@endsection
