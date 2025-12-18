@extends('layout.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/eksekutor/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('eksekutor.tindak-lanjut.index') }}">Tindak Lanjut</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('eksekutor.tindak-lanjut.show', $tindakLanjut->id) }}">Detail</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
            <p class="text-muted mb-0">{{ $description }}</p>
        </div>
    </div>

    @include('partials.toaster')

    <div class="row">
        <div class="col-lg-8">
            <!-- Form Edit Tindak Lanjut -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Tindak Lanjut</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Terdapat kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('eksekutor.tindak-lanjut.update', $tindakLanjut->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Tanggal Update -->
                        <div class="form-group">
                            <label for="tanggal_update">Tanggal Update <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_update" id="tanggal_update" class="form-control"
                                value="{{ old('tanggal_update', $tindakLanjut->tanggal_update->format('Y-m-d')) }}"
                                required>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status">Status Tindak Lanjut <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="">Pilih Status</option>
                                <option value="progress"
                                    {{ (old('status') ?? $tindakLanjut->status) === 'progress' ? 'selected' : '' }}>Progress
                                </option>
                                <option value="selesai"
                                    {{ (old('status') ?? $tindakLanjut->status) === 'selesai' ? 'selected' : '' }}>Selesai
                                </option>
                                <option value="terhambat"
                                    {{ (old('status') ?? $tindakLanjut->status) === 'terhambat' ? 'selected' : '' }}>
                                    Terhambat</option>
                            </select>
                        </div>

                        <!-- Catatan -->
                        <div class="form-group">
                            <label for="catatan">Catatan Tindak Lanjut <span class="text-danger">*</span></label>
                            <textarea name="catatan" id="catatan" rows="6" class="form-control"
                                placeholder="Jelaskan tindak lanjut yang telah dilakukan..." required>{{ old('catatan', $tindakLanjut->catatan) }}</textarea>
                            <small class="form-text text-muted">Berikan penjelasan yang jelas mengenai progress yang telah
                                dicapai</small>
                        </div>

                        <!-- Foto Saat Ini -->
                        @if ($tindakLanjut->foto && count($tindakLanjut->foto) > 0)
                            <div class="form-group">
                                <label>Foto Saat Ini</label>
                                <div class="row g-2" id="existing-photos">
                                    @foreach ($tindakLanjut->foto as $index => $foto)
                                        <div class="col-4 col-md-3 col-lg-2" data-photo="{{ $foto }}">
                                            <div class="existing-photo border rounded p-1">
                                                <img src="{{ asset('storage/' . $foto) }}" class="img-fluid rounded"
                                                    alt="Foto {{ $index + 1 }}"
                                                    style="height: 80px; width: 100%; object-fit: cover; cursor: pointer;"
                                                    onclick="showImageModal('{{ asset('storage/' . $foto) }}', 'Foto {{ $index + 1 }}')">
                                                <button type="button"
                                                    class="btn btn-danger btn-sm w-100 mt-1 remove-existing-photo"
                                                    data-photo="{{ $foto }}" style="font-size: 10px;">
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Hidden input to store which existing photos to keep -->
                                <input type="hidden" name="existing_photos" id="existing-photos-input"
                                    value="{{ json_encode($tindakLanjut->foto ?? []) }}">
                            </div>
                        @endif

                        <!-- Upload Foto Baru -->
                        <div class="form-group">
                            <label>Upload Foto Baru (Opsional)</label>
                            <input type="file" class="filepond" name="foto[]" multiple data-max-file-size="2MB" data-max-files="10">
                            <small class="form-text text-muted">Maksimal 10 foto (JPG, PNG, GIF). Max 2MB per file.</small>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group pt-3 border-top">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update Tindak Lanjut
                            </button>
                            <a href="{{ route('eksekutor.tindak-lanjut.show', $tindakLanjut->id) }}"
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
                    <p class="mb-1"><strong>Kategori:</strong></p>
                    <span class="badge badge-info mb-2">{{ $tindakLanjut->pengaduan->kategori->nama }}</span>

                    <p class="mb-1 mt-2"><strong>Lokasi:</strong></p>
                    <p class="mb-2">{{ $tindakLanjut->pengaduan->lokasi }}</p>

                    <p class="mb-1"><strong>Status Pengaduan:</strong></p>
                    @switch($tindakLanjut->pengaduan->status)
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

                    <p class="mb-1 mt-2"><strong>Tanggal Pengaduan:</strong></p>
                    <p class="mb-2">{{ $tindakLanjut->pengaduan->tanggal_pengaduan->format('d F Y') }}</p>

                    <p class="mb-1"><strong>Pelapor:</strong></p>
                    <p class="mb-0">
                        {{ $tindakLanjut->pengaduan->pengguna->nama_lengkap ?? $tindakLanjut->pengaduan->pengguna->username }}
                    </p>
                </div>
            </div>

            <!-- Panduan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Panduan Edit</h6>
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

                        <p class="mb-0"><strong>Foto:</strong><br>
                            Jika Anda upload foto baru, foto lama akan diganti. Kosongkan jika ingin mempertahankan foto
                            lama.</p>
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

    <style>
        .existing-photo {
            position: relative;
            background: #f8f9fa;
        }

        .existing-photo.removed {
            opacity: 0.5;
            filter: grayscale(100%);
        }

        .remove-existing-photo:hover {
            transform: scale(1.05);
        }
    </style>
@endpush

@push('modals')
    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Foto">
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <!-- FilePond JS -->
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>

    <script>
        // Initialize existing photos management
        let existingPhotos = @json($tindakLanjut->foto ?? []);

        function updateExistingPhotosInput() {
            document.getElementById('existing-photos-input').value = JSON.stringify(existingPhotos);
        }

        // Handle existing photo removal
        document.addEventListener('DOMContentLoaded', function() {
            const removeButtons = document.querySelectorAll('.remove-existing-photo');
            
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const photoPath = this.getAttribute('data-photo');
                    const photoContainer = this.closest('[data-photo]');
                    const btn = this;
                    
                    if (btn.classList.contains('btn-danger')) {
                        // Remove action
                        const index = existingPhotos.indexOf(photoPath);
                        if (index > -1) {
                            existingPhotos.splice(index, 1);
                        }
                        
                        photoContainer.querySelector('.existing-photo').classList.add('removed');
                        btn.textContent = 'Dipulihkan';
                        btn.classList.remove('btn-danger');
                        btn.classList.add('btn-success');
                    } else {
                        // Restore action
                        existingPhotos.push(photoPath);
                        photoContainer.querySelector('.existing-photo').classList.remove('removed');
                        btn.textContent = 'Hapus';
                        btn.classList.remove('btn-success');
                        btn.classList.add('btn-danger');
                    }
                    
                    updateExistingPhotosInput();
                });
            });
        });

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

        // Image modal functionality
        function showImageModal(src, title) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModalLabel').textContent = title;
            $('#imageModal').modal('show');
        }
    </script>
@endpush
