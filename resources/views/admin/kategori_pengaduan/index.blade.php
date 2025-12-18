@extends('layout.app')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Master Kategori Pengaduan</li>
                </ol>
            </nav>
        </div>
        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"
            data-target="#createKategoriModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Kategori
        </button>
    </div>

    @include('partials.toaster')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">Data Kategori Pengaduan</h6>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="{{ route('kategori-pengaduan.index') }}" class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" 
                                   name="search" placeholder="Cari nama atau deskripsi..." 
                                   value="{{ $search }}" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-sm" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if($search)
                                    <a href="{{ route('kategori-pengaduan.index') }}" class="btn btn-outline-secondary btn-sm">
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
                            <th class="text-center" width="5%">#</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategori as $index => $k)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="font-weight-bold">{{ $k->nama }}</td>
                                <td>{{ Str::limit($k->deskripsi, 80) }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning btn-circle btn-sm mr-1"
                                        onclick="editKategori({{ $k->id }}, '{{ addslashes($k->nama) }}', '{{ addslashes($k->deskripsi) }}')"
                                        data-toggle="modal" data-target="#editKategoriModal" title="Edit Kategori">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-circle btn-sm"
                                        onclick="deleteKategori({{ $k->id }}, '{{ addslashes($k->nama) }}')"
                                        title="Hapus Kategori">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="fas fa-folder-open fa-2x mb-2 text-gray-300"></i><br>
                                    Tidak ada data kategori yang ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @include('partials.paginator', ['paginator' => $kategori])
        </div>
    </div>

    @include('admin.kategori_pengaduan.modal_create')
    @include('admin.kategori_pengaduan.modal_edit')

    @include('partials.confirm_modal', [
        'modal_id' => 'deleteKategoriModal',
        'modal_title' => 'Konfirmasi Hapus Kategori',
        'modal_description' => 'Apakah Anda yakin ingin menghapus kategori <span id="deleteKategoriName" class="font-weight-bold text-danger"></span>?',
        'form_action' => '#',
        'form_method' => 'DELETE',
        'confirm_button_text' => 'Hapus Kategori',
        'confirm_button_class' => 'btn-danger',
        'confirm_button_icon' => 'fas fa-trash',
        'cancel_button_text' => 'Batal',
        'title_icon' => 'fas fa-times',
        'body_icon' => 'fas fa-exclamation-triangle fa-3x text-danger',
        'header_class' => 'bg-danger text-white',
        'additional_info' => 'Tindakan ini tidak dapat dibatalkan.'
    ])

    <script>
        function editKategori(id, nama, deskripsi) {
            document.getElementById('edit_kategori_id').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_deskripsi').value = deskripsi || '';
            document.getElementById('editKategoriForm').action = '/admin/kategori-pengaduan/' + id;
        }

        function deleteKategori(id, nama) {
            document.getElementById('deleteKategoriName').textContent = nama;
            document.getElementById('deleteKategoriModalForm').action = '/admin/kategori-pengaduan/' + id;
            $('#deleteKategoriModal').modal('show');
        }
    </script>
@endsection