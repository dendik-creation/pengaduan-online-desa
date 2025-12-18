@extends('landing.layout')

@section('title', 'Buat Pengaduan Baru')

@section('content')
<main class="main">
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container">
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">Beranda</a></li>
                    <li><a href="{{ route('landing.pengaduan.index') }}">Data Pengaduan</a></li>
                    <li class="current">Buat Pengaduan</li>
                </ol>
            </nav>
            <h1>Buat Pengaduan Baru</h1>
            <p class="title-description">Sampaikan keluhan atau saran Anda untuk kemajuan desa</p>
        </div>
    </div><!-- End Page Title -->

    <!-- Create Form Section -->
    <section class="section">
        <div class="container" data-aos="fade-up">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-body p-4">
                            <form action="{{ route('landing.pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Kategori Pengaduan -->
                                <div class="mb-3">
                                    <label for="kategori_id" class="form-label">
                                        Kategori Pengaduan <span class="text-danger">*</span>
                                    </label>
                                    <select name="kategori_id" id="kategori_id" class="form-select" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('kategori_id') == $category->id ? 'selected' : '' }}>
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
                                           value="{{ old('tanggal_pengaduan', date('Y-m-d')) }}" required>
                                </div>

                                <!-- Lokasi -->
                                <div class="mb-3">
                                    <label for="lokasi" class="form-label">
                                        Lokasi Kejadian <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="lokasi" id="lokasi" class="form-control" 
                                           value="{{ old('lokasi') }}" 
                                           placeholder="Contoh: Jl. Raya Desa No. 123, RT 01/RW 02" required>
                                </div>

                                <!-- Rincian -->
                                <div class="mb-3">
                                    <label for="rincian" class="form-label">
                                        Rincian Pengaduan <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="rincian" id="rincian" rows="6" class="form-control" 
                                              placeholder="Jelaskan secara detail mengenai pengaduan Anda..." required>{{ old('rincian') }}</textarea>
                                    <div class="form-text">Berikan penjelasan yang jelas dan detail untuk mempermudah penanganan</div>
                                </div>

                                <!-- Upload Foto -->
                                <div class="mb-4">
                                    <label class="form-label">
                                        Foto Pendukung (Opsional)
                                    </label>
                                    <input type="file" class="filepond" name="foto[]" multiple data-max-file-size="2MB" data-max-files="10">
                                    <div class="form-text">
                                        PNG, JPG, JPEG, GIF hingga 2MB per file. Maksimal 10 foto.
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <a href="{{ route('landing.pengaduan.index') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-1"></i> Kembali
                                    </a>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send me-1"></i> Kirim Pengaduan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Create Form Section -->
</main>

@endsection

@section('extra-css')
<!-- FilePond CSS -->
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
@endsection

@section('extra-js')
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
@endsection