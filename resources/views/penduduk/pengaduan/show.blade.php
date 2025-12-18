@extends('layout.app')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('penduduk.pengaduan.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

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
                    <span class="badge badge-{{ $badgeMap[$item->status] ?? 'secondary' }}">
                        {{ $statusLabelMap[$item->status] ?? $item->status }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Tanggal Pengaduan:</strong><br>
                            {{ $item->tanggal_pengaduan->format('d F Y') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Kategori:</strong><br>
                            <span class="badge badge-info">{{ optional($item->kategori)->nama ?? '-' }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Lokasi Kejadian:</strong><br>
                        {{ $item->lokasi }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>Rincian Pengaduan:</strong><br>
                        <div class="bg-light p-3 rounded">
                            {!! nl2br(e($item->rincian)) !!}
                        </div>
                    </div>

                    <!-- Foto-foto -->
                    @if($item->foto && count($item->foto) > 0)
                        <div class="mb-3">
                            <strong>Foto Pendukung:</strong><br>
                            <div class="row mt-2">
                                @foreach($item->foto as $index => $foto)
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <img src="{{ asset('storage/' . $foto) }}" 
                                                 class="card-img-top" 
                                                 alt="Foto {{ $index + 1 }}"
                                                 style="height: 200px; object-fit: cover; cursor: pointer;"
                                                 onclick="showImageModal('{{ asset('storage/' . $foto) }}', 'Foto {{ $index + 1 }}')">
                                            <div class="card-body p-2">
                                                <small class="text-muted">Foto {{ $index + 1 }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>



            <!-- Tindak Lanjut -->
            @if($item->tindakLanjut && $item->tindakLanjut->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tindak Lanjut</h6>
                </div>
                <div class="card-body">
                    @foreach($item->tindakLanjut->sortByDesc('created_at') as $tindak)
                        <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="fw-bold">{{ $tindak->judul }}</div>
                            <div class="text-muted mb-2">{{ $tindak->deskripsi }}</div>
                            <small class="text-muted">
                                {{ $tindak->created_at->format('d F Y, H:i') }}
                                oleh {{ optional($tindak->eksekutor)->nama_lengkap ?? 'Eksekutor' }}
                            </small>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
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
                        <h6 class="font-weight-bold">{{ $item->pengguna->nama_lengkap }}</h6>
                        <p class="text-muted small mb-0">{{ $item->pengguna->username }}</p>
                        <p class="text-muted small mb-0">{{ $item->pengguna->alamat }}</p>
                    </div>
                </div>
            </div>

            <!-- Penugasan -->
            @if($item->penugasan && $item->penugasan->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tim Penanganan</h6>
                </div>
                <div class="card-body">
                    @foreach($item->penugasan as $penugasan)
                        <div class="mb-3">
                            <div class="fw-bold">{{ $penugasan->eksekutor->nama_lengkap }}</div>
                            <div class="text-muted small">
                                Username: {{ $penugasan->eksekutor->username }}
                            </div>
                            <div class="text-muted small">
                                No. HP: {{ $penugasan->eksekutor->no_hp }}
                            </div>
                            <div class="text-muted small">
                                Ditugaskan: {{ $penugasan->created_at->format('d F Y') }}
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
                    @if($overallRating)
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

                    <!-- Form Tambah Ulasan untuk Penduduk -->
                    <div class="mb-3 p-3 bg-light rounded">
                        <h6 class="mb-3">Tambah/Update Ulasan</h6>
                        <form method="POST" action="{{ route('penduduk.pengaduan.ulasan.store', $item) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
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
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="small mb-1">Keterangan</label>
                                        <input type="text" name="keterangan" class="form-control form-control-sm" placeholder="(Opsional)">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="small mb-1">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-sm form-control">
                                            <i class="fas fa-star"></i> Berikan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Daftar Ulasan -->
                    @if($item->ulasan && $item->ulasan->count() > 0)
                        <div class="mt-3">
                            <h6>Semua Ulasan</h6>
                            @foreach($item->ulasan->groupBy('tipe') as $tipe => $ulasanGrup)
                                <div class="mb-3 p-2 border rounded">
                                    <strong class="small text-primary">{{ $tipeOptions[$tipe] ?? $tipe }}:</strong>
                                    @foreach($ulasanGrup as $ulasan)
                                        <div class="mt-2 p-2 bg-light rounded">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge badge-warning">{{ $ulasan->nilai }}/5 ★</span>
                                                <small class="text-muted">
                                                    oleh {{ optional($ulasan->pengguna)->nama_lengkap ?? 'Pengguna' }}
                                                    @if($ulasan->pengguna_id === Auth::id())
                                                        <span class="badge badge-info badge-sm">Ulasan Saya</span>
                                                    @endif
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
                            <p class="mb-0 mt-2">Belum ada ulasan. Jadilah yang pertama memberikan ulasan!</p>
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

<script>
function showImageModal(src, title) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModalLabel').textContent = title;
    $('#imageModal').modal('show');
}
</script>
@endsection