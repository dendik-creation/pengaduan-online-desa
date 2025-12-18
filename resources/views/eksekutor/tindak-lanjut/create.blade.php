@extends('layout.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/eksekutor/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('eksekutor.pengaduan.index') }}">Pengaduan</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('eksekutor.pengaduan.show', $pengaduan->id) }}">Detail
                            Pengaduan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Tindak Lanjut</li>
                </ol>
            </nav>
            <p class="text-muted mb-0">{{ $description }}</p>
        </div>
    </div>

    @include('partials.toaster')

    <div class="row">
        <div class="col-lg-8">
            <!-- Form Tindak Lanjut -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tindak Lanjut</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('eksekutor.tindak-lanjut.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="pengaduan_id" value="{{ $pengaduan->id }}">

                        <!-- Tanggal Update -->
                        <div class="form-group">
                            <label for="tanggal_update">Tanggal Update <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_update" id="tanggal_update" class="form-control"
                                value="{{ old('tanggal_update', date('Y-m-d')) }}" required>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status">Status Tindak Lanjut <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="">Pilih Status</option>
                                <option value="progress" {{ old('status') === 'progress' ? 'selected' : '' }}>Progress
                                </option>
                                <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="terhambat" {{ old('status') === 'terhambat' ? 'selected' : '' }}>Terhambat
                                </option>
                            </select>
                        </div>

                        <!-- Catatan -->
                        <div class="form-group">
                            <label for="catatan">Catatan Tindak Lanjut <span class="text-danger">*</span></label>
                            <textarea name="catatan" id="catatan" rows="6" class="form-control"
                                placeholder="Jelaskan tindak lanjut yang telah dilakukan..." required>{{ old('catatan') }}</textarea>
                            <small class="form-text text-muted">Berikan penjelasan yang jelas mengenai progress yang telah
                                dicapai</small>
                        </div>

                        <!-- Foto Bukti -->
                        <div class="form-group">
                            <label>Foto Bukti (Opsional)</label>
                            <input type="file" class="filepond" name="foto[]" multiple data-max-file-size="2MB" data-max-files="10">
                            <small class="form-text text-muted">Maksimal 10 foto (JPG, PNG, GIF). Max 2MB per file.</small>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group pt-3 border-top">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan Tindak Lanjut
                            </button>
                            <a href="{{ route('eksekutor.pengaduan.show', $pengaduan->id) }}"
                                class="btn btn-secondary ml-2">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Informasi Pengaduan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pengaduan</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex" style="gap: 1em;">
                        <div class="">
                            <p class="mb-1"><strong>Kategori:</strong></p>
                            <span class="badge badge-info mb-2">{{ $pengaduan->kategori->nama }}</span>
                        </div>
                        <div class="">
                            <p class="mb-1"><strong>Status:</strong></p>
                            @switch($pengaduan->status)
                                @case('baru')
                                    <span class="badge badge-warning mb-2">Baru</span>
                                @break

                                @case('diproses')
                                    <span class="badge badge-info mb-2">Diproses</span>
                                @break

                                @case('selesai')
                                    <span class="badge badge-success mb-2">Selesai</span>
                                @break

                                @case('ditolak')
                                    <span class="badge badge-danger mb-2">Ditolak</span>
                                @break
                            @endswitch
                        </div>
                    </div>

                    <p class="mb-1 mt-2"><strong>Tanggal Pengaduan:</strong></p>
                    <p class="mb-2">{{ $pengaduan->tanggal_pengaduan->format('d F Y') }}</p>

                    <p class="mb-1"><strong>Pelapor:</strong></p>
                    <p class="mb-0">{{ $pengaduan->pengguna->nama_lengkap ?? $pengaduan->pengguna->username }}</p>

                    <p class="mb-1 mt-2"><strong>Lokasi:</strong></p>
                    <p class="mb-2">{{ $pengaduan->lokasi }}</p>

                    <p class="mb-1 mt-2"><strong>Rincian:</strong></p>
                    <p class="mb-2">{{ $pengaduan->rincian }}</p>

                </div>
            </div>

            <!-- Panduan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Panduan Tindak Lanjut</h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <p class="mb-2"><strong>Status Progress:</strong><br>
                            Gunakan ketika sedang dalam proses penanganan pengaduan.</p>

                        <p class="mb-2"><strong>Status Selesai:</strong><br>
                            Gunakan ketika pengaduan telah selesai ditangani. Status pengaduan akan otomatis berubah menjadi
                            "Selesai".</p>

                        <p class="mb-2"><strong>Status Terhambat:</strong><br>
                            Gunakan ketika ada kendala dalam penanganan pengaduan.</p>

                        <p class="mb-0"><strong>Tips:</strong><br>
                            Sertakan foto bukti untuk meningkatkan kredibilitas laporan tindak lanjut Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <!-- FilePond CSS -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
@endpush

@push('scripts')
    <!-- FilePond JS -->
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>

    <script>
        // Register FilePond plugins
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize
        );

        // Get a reference to the file input element
        const inputElement = document.querySelector('input[type="file"].filepond');

        // Create a FilePond instance
        const pond = FilePond.create(inputElement, {
            storeAsFile: true,
            labelIdle: 'Drag & Drop your picture or <span class="filepond--label-action">Browse</span>',
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'],
            maxFileSize: '2MB',
            maxFiles: 10,
            allowMultiple: true,
            credits: false
        });
    </script>
@endpush
