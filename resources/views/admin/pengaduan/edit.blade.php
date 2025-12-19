@extends('layout.app')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Pengaduan #{{ $pengaduan->id }}</h1>
        <div class="btn-group">
            <a href="{{ route('admin.pengaduan.show', $pengaduan->id) }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Detail
            </a>
        </div>
    </div>

    @include('partials.toaster')

    <div class="row">
        <!-- Form Edit -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit mr-2"></i>Form Edit Pengaduan
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pengaduan.update', $pengaduan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Kategori Pengaduan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1 font-weight-bold" for="kategori_id">
                                        <i class="fas fa-folder mr-1"></i>Kategori Pengaduan <span class="text-danger">*</span>
                                    </label>
                                    <select name="kategori_id" id="kategori_id" class="form-control" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ (old('kategori_id') ?? $pengaduan->kategori_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Tanggal Pengaduan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1 font-weight-bold" for="tanggal_pengaduan">
                                        <i class="fas fa-calendar mr-1"></i>Tanggal Pengaduan <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="tanggal_pengaduan" id="tanggal_pengaduan" class="form-control"
                                           value="{{ old('tanggal_pengaduan') ?? $pengaduan->tanggal_pengaduan->format('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div class="form-group">
                            <label class="small mb-1 font-weight-bold" for="lokasi">
                                <i class="fas fa-map-marker-alt mr-1"></i>Lokasi Kejadian <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="lokasi" id="lokasi" class="form-control"
                                   value="{{ old('lokasi') ?? $pengaduan->lokasi }}"
                                   placeholder="Contoh: Jl. Raya Desa No. 123, RT 01/RW 02" required>
                        </div>

                        <!-- Rincian -->
                        <div class="form-group">
                            <label class="small mb-1 font-weight-bold" for="rincian">
                                <i class="fas fa-align-left mr-1"></i>Rincian Pengaduan <span class="text-danger">*</span>
                            </label>
                            <textarea name="rincian" id="rincian" rows="6" class="form-control"
                                      placeholder="Jelaskan secara detail mengenai pengaduan..." required>{{ old('rincian') ?? $pengaduan->rincian }}</textarea>
                            <small class="text-muted">Berikan penjelasan yang jelas dan detail untuk mempermudah penanganan</small>
                        </div>

                        <!-- Existing Photos -->
                        @if($pengaduan->foto && count($pengaduan->foto) > 0)
                        <div class="form-group">
                            <label class="small mb-1 font-weight-bold">
                                <i class="fas fa-images mr-1"></i>Foto Saat Ini
                            </label>
                            <div class="row g-2" id="existing-photos">
                                @foreach($pengaduan->foto as $index => $foto)
                                    <div class="col-6 col-md-4 col-lg-3 mb-2" data-photo="{{ $foto }}">
                                        <div class="existing-photo border rounded p-2 bg-light">
                                            <img src="{{ asset('storage/' . $foto) }}"
                                                 class="img-fluid rounded mb-2"
                                                 alt="Foto {{ $index + 1 }}"
                                                 style="height: 100px; width: 100%; object-fit: cover; cursor: pointer;"
                                                 onclick="showImageModal('{{ asset('storage/' . $foto) }}', 'Foto {{ $index + 1 }}')">
                                            <button type="button" class="btn btn-danger btn-sm w-100 remove-existing-photo"
                                                    data-photo="{{ $foto }}">
                                                <i class="fas fa-trash mr-1"></i>Hapus
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Hidden input to store which existing photos to keep -->
                            <input type="hidden" name="existing_photos" id="existing-photos-input"
                                   value="{{ json_encode($pengaduan->foto ?? []) }}">
                        </div>
                        @endif

                        <!-- Upload New Photos -->
                        <div class="form-group">
                            <label class="small mb-1 font-weight-bold">
                                <i class="fas fa-camera mr-1"></i>Tambah Foto Baru (Opsional)
                            </label>
                            <input type="file" class="filepond" name="foto[]" multiple data-max-file-size="2MB" data-max-files="10">
                            <small class="text-muted">PNG, JPG, JPEG, GIF hingga 2MB per file. Maksimal 10 foto total.</small>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('admin.pengaduan.show', $pengaduan->id) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times mr-1"></i> Batal
                                </a>

                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <!-- Info Pengaduan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pengaduan</h6>
                </div>
                <div class="card-body">
                    @php
                        $badgeMap = [
                            'baru' => 'warning',
                            'diproses' => 'info',
                            'selesai' => 'success',
                            'ditolak' => 'danger',
                        ];
                        $statusLabelMap = [
                            'baru' => 'Baru',
                            'diproses' => 'Diproses',
                            'selesai' => 'Selesai',
                            'ditolak' => 'Ditolak',
                        ];
                    @endphp

                    <div class="mb-3">
                        <strong class="small">ID Pengaduan:</strong><br>
                        <span class="h5 text-primary">#{{ $pengaduan->id }}</span>
                    </div>

                    <div class="mb-3">
                        <strong class="small">Status Saat Ini:</strong><br>
                        <span class="badge badge-{{ $badgeMap[$pengaduan->status] ?? 'secondary' }}">
                            {{ $statusLabelMap[$pengaduan->status] ?? $pengaduan->status }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <strong class="small">Dibuat:</strong><br>
                        {{ $pengaduan->created_at->format('d F Y H:i') }}
                    </div>

                    <div class="mb-3">
                        <strong class="small">Terakhir Diupdate:</strong><br>
                        {{ $pengaduan->updated_at->format('d F Y H:i') }}
                    </div>
                </div>
            </div>

            <!-- Info Pengadu -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pengadu (Pelapor)</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="mb-2">
                            <i class="fas fa-user-circle fa-3x text-gray-300"></i>
                        </div>
                        <h6 class="font-weight-bold">{{ $pengaduan->pengguna->nama_lengkap }}</h6>
                        <p class="text-muted small mb-0">{{ $pengaduan->pengguna->username }}</p>
                        @if($pengaduan->pengguna->no_hp)
                            <p class="text-muted small mb-0">{{ $pengaduan->pengguna->no_hp }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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

.filepond--root {
    margin-bottom: 0;
}

.card-header {
    border-bottom: 1px solid #e3e6f0;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
</style>
@endpush

@push('scripts')
<!-- FilePond JS -->
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>

<script>
// Initialize existing photos management
let existingPhotos = @json($pengaduan->foto ?? []);

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

            // Remove from existingPhotos array
            const index = existingPhotos.indexOf(photoPath);
            if (index > -1) {
                existingPhotos.splice(index, 1);
            }

            // Visual feedback
            photoContainer.classList.add('removed');
            this.innerHTML = '<i class="fas fa-undo mr-1"></i>Pulihkan';
            this.classList.remove('btn-danger');
            this.classList.add('btn-success');

            // Change functionality to restore
            const originalFunction = this.onclick;
            this.onclick = function() {
                existingPhotos.push(photoPath);
                photoContainer.classList.remove('removed');
                this.innerHTML = '<i class="fas fa-trash mr-1"></i>Hapus';
                this.classList.remove('btn-success');
                this.classList.add('btn-danger');
                this.onclick = originalFunction;
                updateExistingPhotosInput();
            };

            updateExistingPhotosInput();
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
    if (inputElement) {
        const pond = FilePond.create(inputElement, {
            storeAsFile: true,
            labelIdle: 'Drag & Drop your picture or <span class="filepond--label-action">Browse</span>',
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'],
            maxFileSize: '2MB',
            maxFiles: 10,
            allowMultiple: true,
            credits: false
        });
    }
});

// Image modal functionality
function showImageModal(src, title) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModalLabel').textContent = title;
    $('#imageModal').modal('show');
}
</script>
@endpush
