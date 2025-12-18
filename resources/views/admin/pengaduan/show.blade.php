@extends('layout.app')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pengaduan #{{ $pengaduan->id }}</h1>
        <div class="btn-group">
            <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editPengaduanModal">
                <i class="fas fa-edit"></i> Edit
            </button>
            <button class="btn btn-sm btn-danger" onclick="deletePengaduan({{ $pengaduan->id }})">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </div>
    </div>

    @include('partials.toaster')

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

    <div class="row">
        <!-- Detail Pengaduan -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Pengaduan</h6>
                    <span class="badge badge-{{ $badgeMap[$pengaduan->status] ?? 'secondary' }}">
                        {{ $statusLabelMap[$pengaduan->status] ?? $pengaduan->status }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Tanggal Pengaduan:</strong><br>
                            {{ $pengaduan->tanggal_pengaduan->format('d F Y') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Kategori:</strong><br>
                            <span class="badge badge-info">{{ $pengaduan->kategori?->nama ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Lokasi Kejadian:</strong><br>
                        {{ $pengaduan->lokasi }}
                    </div>

                    <div class="mb-3">
                        <strong>Rincian Pengaduan:</strong><br>
                        <div class="bg-light p-3 rounded">
                            {!! nl2br(e($pengaduan->rincian)) !!}
                        </div>
                    </div>

                    <!-- Foto-foto -->
                    @if($pengaduan->foto && count($pengaduan->foto) > 0)
                        <div class="mb-3">
                            <strong>Foto Pendukung:</strong><br>
                            <div class="row mt-2">
                                @foreach($pengaduan->foto as $index => $foto)
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <img src="{{ asset("storage/{$foto}") }}"
                                                 class="card-img-top"
                                                 alt="Foto {{ $index + 1 }}"
                                                 style="height: 200px; object-fit: cover; cursor: pointer;"
                                                 onclick="showImage('{{ asset("storage/{$foto}") }}')">
                                            <div class="card-body p-2">
                                                <small class="text-muted">Foto {{ $index + 1 }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Dokumen (jika ada) -->
                    @if($pengaduan->dokumen)
                        <div class="mb-3">
                            <strong>Dokumen Pendukung:</strong><br>
                            <a href="{{ Storage::url($pengaduan->dokumen) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-file-alt mr-1"></i>Lihat Dokumen
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tindak Lanjut -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Progress Pengaduan</h6>
                </div>
                <div class="card-body">
                    @php
                        $tindakList = $pengaduan->tindakLanjut ?? collect();
                    @endphp

                    @if($tindakList?->count())
                        <h6 class="text-muted mb-2">Tindak Lanjut</h6>
                        @php
                            $statusBadge = ['progress' => 'info','selesai' => 'success','terhambat' => 'danger'];
                        @endphp
                        <div class="accordion" id="tindakLanjutAccordion">
                            @foreach($tindakList->sortByDesc('tanggal_update') as $tl)
                                @php
                                    $accId = "tl-{$tl->id}";
                                    $tglUpdate = $tl->tanggal_update instanceof \Illuminate\Support\Carbon ?
                                        $tl->tanggal_update->format('d F Y') :
                                        \Illuminate\Support\Carbon::parse($tl->tanggal_update)->format('d F Y');
                                @endphp
                                <div class="card">
                                    <div class="card-header" id="heading-{{ $accId }}">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                                    data-target="#collapse-{{ $accId }}" aria-expanded="false"
                                                    aria-controls="collapse-{{ $accId }}">
                                                <span class="mr-3 font-weight-bold">{{ $tglUpdate }}</span>
                                                <span class="badge badge-{{ $statusBadge[$tl->status] ?? 'secondary' }} mr-2 text-capitalize">
                                                    {{ $tl->status }}
                                                </span>
                                                <small class="text-muted">Dibuat: {{ $tl->created_at->format('d F Y H:i') }}</small>
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapse-{{ $accId }}" class="collapse" aria-labelledby="heading-{{ $accId }}"
                                         data-parent="#tindakLanjutAccordion">
                                        <div class="card-body">
                                            <p class="mb-1"><strong>Eksekutor:</strong>
                                                {{ $tl->eksekutor->nama_lengkap ?? $tl->eksekutor->username ?? 'Tidak diketahui' }}
                                            </p>
                                            <p class="mb-1"><strong>Catatan:</strong> {{ $tl->catatan }}</p>
                                            <p class="mb-1"><strong>Tanggal Update:</strong> {{ $tglUpdate }}</p>
                                            @if($tl->foto && count($tl->foto) > 0)
                                                <div class="mt-2">
                                                    <strong>Foto Bukti:</strong><br>
                                                    <div class="row mt-1">
                                                        @foreach($tl->foto as $index => $foto)
                                                            <div class="col-6 col-md-4 mb-1">
                                                                <div class="border rounded p-1">
                                                                    <img src="{{ asset("storage/{$foto}") }}"
                                                                         alt="Foto {{ $index + 1 }}"
                                                                         style="height: 80px; width: 100%; object-fit: cover; cursor: pointer;"
                                                                         class="img-fluid rounded"
                                                                         onclick="showImage('{{ asset("storage/{$foto}") }}')">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Belum ada progres yang dilaporkan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Info Pengadu -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pengadu</h6>
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

            <!-- Form Update Status -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Perbarui Status</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.pengaduan.update-status',$pengaduan->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="small mb-1" for="status_baru">Status Baru</label>
                            <select class="form-control" id="status_baru" name="status_baru" required>
                                <option value="">Pilih Status</option>
                                @foreach($statuses as $st)
                                    <option value="{{ $st }}" {{ $pengaduan->status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info btn-sm">
                            <i class="fas fa-sync mr-1"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Penugasan Eksekutor</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.pengaduan.assign-eksekutor',$pengaduan->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="small mb-1" for="eksekutor_id">Eksekutor</label>
                            <select class="form-control" id="eksekutor_id" name="eksekutor_id" required>
                                <option value="">Pilih Eksekutor</option>
                                @foreach($eksekutorList as $e)
                                    <option value="{{ $e->id }}">{{ $e->nama_lengkap }} ({{ $e->username }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="tanggal_penugasan">Tanggal Penugasan</label>
                            <input type="date" class="form-control" id="tanggal_penugasan" name="tanggal_penugasan" value="{{ now()->format('Y-m-d') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-user-check mr-1"></i>Tugaskan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Penugasan -->
            @if($pengaduan->penugasan && $pengaduan->penugasan->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tim Penanganan</h6>
                </div>
                <div class="card-body">
                    @foreach($pengaduan->penugasan as $penugasan)
                        <div class="mb-3">
                            <div class="font-weight-bold">{{ $penugasan->eksekutor->nama_lengkap }}</div>
                            <div class="text-muted small">
                                Username: {{ $penugasan->eksekutor->username }}
                            </div>
                            <div class="text-muted small">
                                No. HP: {{ $penugasan->eksekutor->no_hp }}
                            </div>
                            <div class="text-muted small">
                                Ditugaskan: {{ $penugasan->tanggal_penugasan ? $penugasan->tanggal_penugasan->format('d F Y') : $penugasan->created_at->format('d F Y') }}
                            </div>
                            <div class="text-muted small">
                                Oleh: {{ $penugasan->admin?->nama_lengkap ?? 'Admin' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Rating/Ulasan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rating & Ulasan</h6>
                </div>
                <div class="card-body">
                    @if(isset($overallRating) && $overallRating)
                        <div class="text-center mb-3">
                            <div class="h4 text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $overallRating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <div class="text-muted">Rating Keseluruhan: {{ $overallRating }}/5</div>
                        </div>
                    @endif

                    @if($avgRatings && count($avgRatings))
                        @foreach($avgRatings as $tipe => $rata)
                            <div class="mb-2">
                                <div class="d-flex justify-content-between">
                                    <span class="small">{{ $tipeOptions[$tipe] ?? $tipe }}</span>
                                    <span class="small">{{ $rata }}/5</span>
                                </div>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-warning" style="width: {{ ($rata / 5) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <!-- Form Tambah Ulasan untuk Admin -->
                    <div class="mt-3 p-3 bg-light rounded">
                        <h6 class="mb-3">Tambah Ulasan Admin</h6>
                        <form method="POST" action="{{ route('admin.pengaduan.ulasan.store', $pengaduan) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1">Jenis</label>
                                        <select name="tipe" class="form-control form-control-sm" required>
                                            @foreach($tipeOptions as $k => $lbl)
                                                <option value="{{ $k }}">{{ $lbl }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="small mb-1">Nilai</label>
                                        <select name="nilai" class="form-control form-control-sm" required>
                                            @for($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1">Keterangan</label>
                                        <input type="text" name="keterangan" class="form-control form-control-sm" placeholder="(Opsional)">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="small mb-1">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-sm form-control">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Daftar Ulasan -->
                    @if($pengaduan->ulasan && $pengaduan->ulasan->count() > 0)
                        <div class="mt-3">
                            <h6>Daftar Ulasan</h6>
                            @foreach($pengaduan->ulasan->groupBy('tipe') as $tipe => $ulasanGrup)
                                <div class="mb-3 p-2 border rounded">
                                    <strong class="small text-primary">{{ $tipeOptions[$tipe] ?? $tipe }}:</strong>
                                    @foreach($ulasanGrup as $ulasan)
                                        <div class="mt-2 p-2 bg-light rounded">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge badge-warning">{{ $ulasan->nilai }}/5 ★</span>
                                                <small class="text-muted">
                                                    oleh {{ $ulasan->pengguna?->nama_lengkap ?? 'Pengguna' }}
                                                    • {{ $ulasan->created_at?->diffForHumans() }}
                                                </small>
                                            </div>
                                            @if($ulasan->keterangan)
                                                <div class="mt-1 small">"{{ $ulasan->keterangan }}"</div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted mt-3">
                            <i class="fas fa-star fa-2x"></i>
                            <p class="mb-0 mt-2">Belum ada ulasan</p>
                        </div>
                    @endif
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

@include('admin.pengaduan.modal_edit')
@include('partials.confirm_modal', [
    'modal_id' => 'deletePengaduanModal',
    'modal_title' => 'Konfirmasi Hapus Pengaduan',
    'modal_description' => 'Apakah Anda yakin ingin menghapus pengaduan ini?',
    'form_action' => '#',
    'form_method' => 'DELETE',
    'confirm_button_text' => 'Hapus Pengaduan',
    'confirm_button_class' => 'btn-danger',
    'confirm_button_icon' => 'fas fa-trash',
    'cancel_button_text' => 'Batal',
    'title_icon' => 'fas fa-exclamation-triangle',
    'body_icon' => 'fas fa-exclamation-triangle fa-3x text-danger',
    'header_class' => 'bg-danger text-white'
])

<script>
function deletePengaduan(id){
    document.getElementById('deletePengaduanModalForm').action = '/admin/pengaduan/' + id;
    $('#deletePengaduanModal').modal('show');
}

// JavaScript untuk modal gambar
function showImage(src) {
    document.getElementById('modalImage').src = src;
    $('#imageModal').modal('show');
}
</script>
@endsection
