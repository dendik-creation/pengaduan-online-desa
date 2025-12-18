@extends('landing.layout')

@section('title', 'Edit Pengaduan')

@section('content')
<main class="main">
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container">
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">Beranda</a></li>
                    <li><a href="{{ route('landing.pengaduan.index') }}">Data Pengaduan</a></li>
                    <li><a href="{{ route('landing.pengaduan.show', $pengaduan->id) }}">Detail Pengaduan</a></li>
                    <li class="current">Edit Pengaduan</li>
                </ol>
            </nav>
            <h1>Edit Pengaduan</h1>
            <p class="title-description">Perbarui informasi pengaduan Anda</p>
        </div>
    </div><!-- End Page Title -->

    <!-- Edit Form Section -->
    <section class="section">
        <div class="container" data-aos="fade-up">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-body p-4">

                            <form action="{{ route('landing.pengaduan.update', $pengaduan->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Kategori Pengaduan -->
                                <div class="mb-3">
                                    <label for="kategori_id" class="form-label">
                                        Kategori Pengaduan <span class="text-danger">*</span>
                                    </label>
                                    <select name="kategori_id" id="kategori_id" class="form-select" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ (old('kategori_id') ?? $pengaduan->kategori_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tanggal Pengaduan -->
                                <div class="mb-3">
                                    <label for="tanggal_pengaduan" class="form-label">
                                        Tanggal Pengaduan <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="tanggal_pengaduan" id="tanggal_pengaduan" class="form-control" 
                                           value="{{ old('tanggal_pengaduan') ?? $pengaduan->tanggal_pengaduan->format('Y-m-d') }}" required>
                                </div>

                                <!-- Lokasi -->
                                <div class="mb-3">
                                    <label for="lokasi" class="form-label">
                                        Lokasi Kejadian <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="lokasi" id="lokasi" class="form-control" 
                                           value="{{ old('lokasi') ?? $pengaduan->lokasi }}" 
                                           placeholder="Contoh: Jl. Raya Desa No. 123, RT 01/RW 02" required>
                                </div>

                                <!-- Rincian -->
                                <div class="mb-3">
                                    <label for="rincian" class="form-label">
                                        Rincian Pengaduan <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="rincian" id="rincian" rows="6" class="form-control" 
                                              placeholder="Jelaskan secara detail mengenai pengaduan Anda..." required>{{ old('rincian') ?? $pengaduan->rincian }}</textarea>
                                    <div class="form-text">Berikan penjelasan yang jelas dan detail untuk mempermudah penanganan</div>
                                </div>

                                <!-- Existing Photos -->
                                @if($pengaduan->foto && count($pengaduan->foto) > 0)
                                <div class="mb-3">
                                    <label class="form-label">Foto Saat Ini</label>
                                    <div class="row g-2" id="existing-photos">
                                        @foreach($pengaduan->foto as $index => $foto)
                                            <div class="col-4 col-md-3 col-lg-2" data-photo="{{ $foto }}">
                                                <div class="existing-photo border rounded p-1">
                                                    <img src="{{ asset('storage/' . $foto) }}" 
                                                         class="img-fluid rounded" 
                                                         alt="Foto {{ $index + 1 }}"
                                                         style="height: 80px; width: 100%; object-fit: cover; cursor: pointer;"
                                                         onclick="showImageModal('{{ asset('storage/' . $foto) }}', 'Foto {{ $index + 1 }}')">
                                                    <button type="button" class="btn btn-danger btn-sm w-100 mt-1 remove-existing-photo" 
                                                            data-photo="{{ $foto }}" style="font-size: 10px;">
                                                        Hapus
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
                                <div class="mb-4">
                                    <label class="form-label">
                                        Tambah Foto Baru (Opsional)
                                    </label>
                                    <input type="file" class="filepond" name="foto[]" multiple data-max-file-size="2MB" data-max-files="10">
                                    <div class="form-text">
                                        PNG, JPG, JPEG, GIF hingga 2MB per file. Maksimal 10 foto total.
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <a href="{{ route('landing.pengaduan.show', $pengaduan->id) }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-1"></i> Batal
                                    </a>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Edit Form Section -->
</main>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Foto">
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra-css')
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
@endsection

@section('extra-js')
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
            this.textContent = 'Dipulihkan';
            this.classList.remove('btn-danger');
            this.classList.add('btn-success');
            
            // Change functionality to restore
            this.onclick = function() {
                existingPhotos.push(photoPath);
                photoContainer.classList.remove('removed');
                this.textContent = 'Hapus';
                this.classList.remove('btn-success');
                this.classList.add('btn-danger');
                this.onclick = arguments.callee.caller; // Reset to original function
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
    const pond = FilePond.create(inputElement, {
        storeAsFile: true,
        labelIdle: 'Drag & Drop your picture or <span class="filepond--label-action">Browse</span>',
        acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'],
        maxFileSize: '2MB',
        maxFiles: 10,
        allowMultiple: true,
        credits: false
    });
});

// Image modal functionality
function showImageModal(src, title) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModalLabel').textContent = title;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>
@endsection
