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
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
            <p class="text-muted mb-0">{{ $description }}</p>
        </div>
    </div>

    @include('partials.toaster')

    <div class="row">
        <div class="col-lg-8">
            <!-- Detail Tindak Lanjut -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Tindak Lanjut</h6>
                        <div>
                            @switch($tindakLanjut->status)
                                @case('progress')
                                    <span class="badge badge-info">Progress</span>
                                    @break
                                @case('selesai')
                                    <span class="badge badge-success">Selesai</span>
                                    @break
                                @case('terhambat')
                                    <span class="badge badge-danger">Terhambat</span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Tanggal Update:</strong>
                            <p>{{ $tindakLanjut->tanggal_update->format('d F Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Dibuat:</strong>
                            <p>{{ $tindakLanjut->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <strong>Eksekutor:</strong>
                            <p>{{ $tindakLanjut->eksekutor->nama_lengkap ?? $tindakLanjut->eksekutor->username }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <strong>Catatan Tindak Lanjut:</strong>
                            <p>{{ $tindakLanjut->catatan }}</p>
                        </div>
                    </div>

                    <!-- Foto Bukti -->
                    @if($tindakLanjut->foto && count($tindakLanjut->foto) > 0)
                        <div class="row">
                            <div class="col-12">
                                <strong>Foto Bukti:</strong>
                                <div class="row mt-2">
                                    @foreach($tindakLanjut->foto as $index => $foto)
                                        <div class="col-6 col-md-4 col-lg-3 mb-2">
                                            <div class="border rounded p-1">
                                                <img src="{{ asset('storage/' . $foto) }}"
                                                     class="img-fluid rounded"
                                                     alt="Foto {{ $index + 1 }}"
                                                     style="height: 120px; width: 100%; object-fit: cover; cursor: pointer;"
                                                     onclick="showImageModal('{{ asset('storage/' . $foto) }}', 'Foto {{ $index + 1 }}')">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="border-top pt-3 mt-3">
                        <a href="{{ route('eksekutor.tindak-lanjut.edit', $tindakLanjut->id) }}"
                           class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger ml-2" onclick="deleteTindakLanjut({{ $tindakLanjut->id }})">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
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
                    <p class="mb-2">{{ $tindakLanjut->pengaduan->pengguna->nama_lengkap ?? $tindakLanjut->pengaduan->pengguna->username }}</p>

                    <div class="border-top pt-2">
                        <a href="{{ route('eksekutor.pengaduan.show', $tindakLanjut->pengaduan->id) }}"
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye"></i> Lihat Detail Pengaduan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('eksekutor.tindak-lanjut.edit', $tindakLanjut->id) }}"
                       class="btn btn-warning btn-block mb-2">
                        <i class="fas fa-edit"></i> Edit Tindak Lanjut
                    </a>
                    <a href="{{ route('eksekutor.tindak-lanjut.index') }}" class="btn btn-secondary btn-block mb-2">
                        <i class="fas fa-list"></i> Semua Tindak Lanjut
                    </a>
                    <a href="{{ route('eksekutor.pengaduan.index') }}" class="btn btn-outline-secondary btn-block">
                        <i class="fas fa-arrow-left"></i> Kembali ke Pengaduan
                    </a>
                </div>
            </div>
        </div>
    </div>

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

    @include('partials.confirm_modal', [
        'modal_id' => 'deleteTindakLanjutModal',
        'modal_title' => 'Konfirmasi Hapus Tindak Lanjut',
        'modal_description' => 'Apakah Anda yakin ingin menghapus tindak lanjut ini? Tindakan ini tidak dapat dibatalkan.',
        'form_action' => '#',
        'form_method' => 'DELETE',
        'confirm_button_text' => 'Hapus Tindak Lanjut',
        'confirm_button_class' => 'btn-danger',
        'confirm_button_icon' => 'fas fa-trash',
        'cancel_button_text' => 'Batal',
        'title_icon' => 'fas fa-exclamation-triangle',
        'body_icon' => 'fas fa-exclamation-triangle fa-3x text-danger',
        'header_class' => 'bg-danger text-white'
    ])

@endsection

@push('scripts')
<script>
function showImageModal(imageSrc, imageTitle) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModalLabel').textContent = imageTitle;
    $('#imageModal').modal('show');
}

function deleteTindakLanjut(id) {
    document.getElementById('deleteTindakLanjutModalForm').action = '/eksekutor/tindak-lanjut/' + id;
    $('#deleteTindakLanjutModal').modal('show');
}
</script>
@endpush
