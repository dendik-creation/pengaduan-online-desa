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
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
            <p class="text-muted mb-0">{{ $description }}</p>
        </div>
    </div>

    @include('partials.toaster')

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Detail Pengaduan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Pengaduan</h6>
                        <div>
                            @switch($pengaduan->status)
                                @case('baru')
                                    <span class="badge badge-warning">Baru</span>
                                    @break
                                @case('diproses')
                                    <span class="badge badge-info">Diproses</span>
                                    @break
                                @case('selesai')
                                    <span class="badge badge-success">Selesai</span>
                                    @break
                                @case('ditolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Tanggal Pengaduan:</strong>
                            <p>{{ $pengaduan->tanggal_pengaduan->format('d F Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Kategori:</strong>
                            <p><span class="badge badge-info">{{ $pengaduan->kategori->nama }}</span></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <strong>Lokasi Kejadian:</strong>
                            <p>{{ $pengaduan->lokasi }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <strong>Rincian Pengaduan:</strong>
                            <p>{{ $pengaduan->rincian }}</p>
                        </div>
                    </div>

                    <!-- Supporting Photos -->
                    @if($pengaduan->foto && count($pengaduan->foto) > 0)
                        <div class="row">
                            <div class="col-12">
                                <strong>Foto Pendukung:</strong>
                                <div class="row mt-2">
                                    @foreach($pengaduan->foto as $index => $foto)
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

                    @if($pengaduan->dokumen)
                        <div class="row">
                            <div class="col-12">
                                <strong>Dokumen Pendukung:</strong>
                                <p>
                                    <a href="{{ asset('storage/'.$pengaduan->dokumen) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download"></i> Lihat Dokumen
                                    </a>
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    @if(in_array($pengaduan->status, ['baru', 'diproses']))
                        <div class="border-top pt-3 mt-3">
                            <a href="{{ route('eksekutor.tindak-lanjut.create', ['pengaduan_id' => $pengaduan->id]) }}"
                               class="btn btn-success">
                                <i class="fas fa-plus"></i> Tambah Tindak Lanjut
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Progress Pengaduan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Progress Pengaduan</h6>
                </div>
                <div class="card-body">
                    @php
                        $tindakList = $pengaduan->tindakLanjut ?? collect();
                    @endphp

                    @if($tindakList && $tindakList->count())
                            <h6 class="text-muted mb-2">Tindak Lanjut</h6>
                            @php
                                $statusBadge = ['progress' => 'info','selesai' => 'success','terhambat' => 'danger'];
                            @endphp
                            <div class="accordion" id="tindakLanjutAccordion">
                                @foreach($tindakList->sortByDesc('tanggal_update') as $tl)
                                    @php
                                        $accId = 'tl-'.$tl->id;
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
                                                                        <img src="{{ asset('storage/'.$foto) }}"
                                                                             alt="Foto {{ $index + 1 }}"
                                                                             style="height: 80px; width: 100%; object-fit: cover; cursor: pointer;"
                                                                             class="img-fluid rounded"
                                                                             onclick="showImageModal('{{ asset('storage/'.$foto) }}', 'Foto {{ $index + 1 }}')">
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

            <!-- Ulasan Pengguna -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rating & Ulasan</h6>
                </div>
                <div class="card-body">
                    @if(isset($overallRating) && $overallRating)
                        <div class="mb-3">
                            <strong>Rating Keseluruhan:</strong>
                            <span class="badge badge-primary">{{ $overallRating }}/5</span>
                            <div class="small text-muted mt-1">
                                @foreach($avgRatings as $t => $val)
                                    @if($val > 0)
                                        <span class="mr-2">{{ $tipeOptions[$t] ?? ucfirst($t) }}:
                                            <span class="badge badge-secondary">{{ $val }}/5</span>
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Form Tambah Ulasan untuk Eksekutor -->
                    <div class="mb-3 p-3 bg-light rounded">
                        <h6 class="mb-3">Tambah Ulasan Eksekutor</h6>
                        <form method="POST" action="{{ route('eksekutor.pengaduan.ulasan.store', $pengaduan) }}">
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
                                            <i class="fas fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if($pengaduan->ulasan->count())
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Jenis</th>
                                        <th>Rating</th>
                                        <th>Keterangan</th>
                                        <th>Pengguna</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengaduan->ulasan->sortByDesc('created_at') as $ul)
                                        <tr>
                                            <td>{{ $tipeOptions[$ul->tipe] ?? ucfirst($ul->tipe) }}</td>
                                            <td><span class="badge badge-primary">{{ $ul->nilai }}/5</span></td>
                                            <td>{{ $ul->keterangan ?: '-' }}</td>
                                            <td>
                                                <span class="small">{{ optional($ul->pengguna)->nama_lengkap ?? 'Pengguna' }}</span>
                                                @if($ul->pengguna_id === Auth::id())
                                                    <span class="badge badge-info badge-sm">Saya</span>
                                                @endif
                                            </td>
                                            <td>{{ $ul->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-star fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Belum ada ulasan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Informasi Pelapor -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pelapor</h6>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Nama:</strong> {{ $pengaduan->pengguna->nama_lengkap ?? $pengaduan->pengguna->username }}</p>
                    <p class="mb-1"><strong>Username:</strong> {{ $pengaduan->pengguna->username }}</p>
                    <p class="mb-1"><strong>No HP:</strong> {{ $pengaduan->pengguna->no_hp ?? '-' }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $pengaduan->pengguna->email ?? '-' }}</p>
                    <p class="mb-0"><strong>Dibuat:</strong> {{ $pengaduan->created_at->format('d F Y H:i') }}</p>
                </div>
            </div>

            <!-- Informasi Penugasan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Penugasan</h6>
                </div>
                <div class="card-body">
                    @if($pengaduan->penugasan->count())
                        @foreach($pengaduan->penugasan as $penugasan)
                            <div class="border-bottom pb-2 mb-2">
                                <p class="mb-1"><strong>Eksekutor:</strong> {{ $penugasan->eksekutor->nama_lengkap ?? $penugasan->eksekutor->username }}</p>
                                <p class="mb-0"><strong>Tanggal Penugasan:</strong> {{ $penugasan->tanggal_penugasan->format('d F Y') }}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted mb-0">Belum ada penugasan.</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    @if(in_array($pengaduan->status, ['baru', 'diproses']))
                        <a href="{{ route('eksekutor.tindak-lanjut.create', ['pengaduan_id' => $pengaduan->id]) }}"
                           class="btn btn-success btn-block mb-2">
                            <i class="fas fa-plus"></i> Tambah Tindak Lanjut
                        </a>
                    @endif
                    <a href="{{ route('eksekutor.pengaduan.index') }}" class="btn btn-secondary btn-block">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
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
@endsection

@push('scripts')
<script>
function showImageModal(imageSrc, imageTitle) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModalLabel').textContent = imageTitle;
    $('#imageModal').modal('show');
}
</script>
@endpush
