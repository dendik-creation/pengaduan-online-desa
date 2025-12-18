@extends('landing.layout')

@section('title', 'Detail Pengaduan - Pengaduan Online Desa')
@section('description', 'Detail lengkap pengaduan masyarakat desa')
@section('keywords', 'detail, pengaduan, desa, online')
@section('body-class', 'starter-page-page')

@section('content')
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container">
            <h1>Detail Pengaduan</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">Beranda</a></li>
                    <li><a href="{{ route('landing.pengaduan.index') }}">Data Pengaduan</a></li>
                    <li class="current">Detail Pengaduan</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <div class="container" data-aos="fade-up">
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

        <div class="row g-4 mt-5">
            <div class="col-lg-8">
                <!-- Detail Pengaduan Card -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <span
                                    class="badge bg-{{ $badgeMap[$item->status] ?? 'secondary' }}">{{ $statusLabelMap[$item->status] ?? $item->status }}</span>
                                @auth
                                    @if (Auth::id() === $item->pengguna_id && $item->status === 'baru')
                                        <a href="{{ route('landing.pengaduan.edit', $item->id) }}"
                                            class="btn btn-primary btn-sm ms-2">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </a>
                                    @endif
                                @endauth
                            </div>
                            <small class="text-muted">{{ $item->tanggal_pengaduan->translatedFormat('d F Y') }}</small>
                        </div>
                        <h3 class="card-title">{{ $item->lokasi }}</h3>
                        <p class="text-muted mb-3">Kategori: <span
                                class="badge bg-light text-dark">{{ optional($item->kategori)->nama ?? '-' }}</span></p>
                        <h5>Rincian Pengaduan</h5>
                        <p class="mb-3">{{ $item->rincian }}</p>

                        <!-- Supporting Photos -->
                        @if ($item->foto && count($item->foto) > 0)
                            <div class="mb-3">
                                <h6>Foto Pendukung</h6>
                                <div class="row g-2">
                                    @foreach ($item->foto as $index => $foto)
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <div class="border rounded p-1">
                                                <img src="{{ asset('storage/' . $foto) }}" class="img-fluid rounded"
                                                    alt="Foto {{ $index + 1 }}"
                                                    style="height: 120px; width: 100%; object-fit: cover; cursor: pointer;"
                                                    onclick="showImageModal('{{ asset('storage/' . $foto) }}', 'Foto {{ $index + 1 }}')">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Progres Pengaduan Card -->
                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Progres Pengaduan</h5>
                        @php
                            // Koleksi progres tindak lanjut
                            $tindakList =
                                method_exists($item, 'tindakLanjut') || property_exists($item, 'tindakLanjut')
                                    ? $item->tindakLanjut ?? collect()
                                    : collect();
                        @endphp
                        @if ($tindakList && $tindakList->count())
                            <div class="timeline">
                                <h6 class="text-muted mb-2">Tindak Lanjut Eksekutor</h6>
                                @php
                                    $statusBadge = [
                                        'progress' => 'info',
                                        'selesai' => 'success',
                                        'terhambat' => 'danger',
                                    ];
                                @endphp
                                <div class="accordion" id="tindakLanjutAccordion">
                                    @foreach ($tindakList->sortByDesc('tanggal_update') as $tl)
                                        @php
                                            $accId = 'tl-' . $tl->id;
                                            $tglUpdate =
                                                $tl->tanggal_update instanceof \Illuminate\Support\Carbon
                                                    ? $tl->tanggal_update->translatedFormat('d F Y')
                                                    : \Illuminate\Support\Carbon::parse(
                                                        $tl->tanggal_update,
                                                    )->translatedFormat('d F Y');
                                        @endphp
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading-{{ $accId }}">
                                                <button class="accordion-button collapsed py-2" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-{{ $accId }}" aria-expanded="false"
                                                    aria-controls="collapse-{{ $accId }}">
                                                    <span class="me-3 fw-semibold">{{ $tglUpdate }}</span>
                                                    <span
                                                        class="badge bg-{{ $statusBadge[$tl->status] ?? 'secondary' }} me-2 text-capitalize">{{ $tl->status }}</span>
                                                    <small class="text-muted">Dibuat:
                                                        {{ optional($tl->created_at)->translatedFormat('d F Y H:i') }}</small>
                                                </button>
                                            </h2>
                                            <div id="collapse-{{ $accId }}" class="accordion-collapse collapse"
                                                aria-labelledby="heading-{{ $accId }}"
                                                data-bs-parent="#tindakLanjutAccordion">
                                                <div class="accordion-body py-3">
                                                    <p class="mb-1"><strong>Catatan:</strong> {{ $tl->catatan }}</p>
                                                    <p class="mb-1"><strong>Tanggal Update:</strong> {{ $tglUpdate }}
                                                    </p>
                                                    @if ($tl->foto && count($tl->foto) > 0)
                                                        <div class="mt-2">
                                                            <strong>Foto Bukti:</strong><br>
                                                            <div class="row g-2 mt-1">
                                                                @foreach($tl->foto as $index => $foto)
                                                                    <div class="col-6 col-md-4">
                                                                        <div class="border rounded p-1">
                                                                            <img src="{{ asset('storage/' . $foto) }}"
                                                                                alt="Foto {{ $index + 1 }}"
                                                                                style="height: 100px; width: 100%; object-fit: cover; cursor: pointer;"
                                                                                class="img-fluid rounded"
                                                                                onclick="showImageModal('{{ asset('storage/' . $foto) }}', 'Foto {{ $index + 1 }}')">
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
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada progres yang dilaporkan.</p>
                        @endif
                    </div>
                </div>

                <!-- Ulasan Section -->
                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Ulasan Pengguna</h5>
                        @if (isset($overallRating))
                            <div class="mb-3">
                                <strong>Rating Keseluruhan:</strong>
                                @if ($overallRating)
                                    <span class="badge bg-primary">{{ $overallRating }}/5</span>
                                @endif
                                <div class="small text-muted">
                                    @foreach ($avgRatings as $t => $val)
                                        <span class="me-2">{{ $tipeOptions[$t] ?? ucfirst($t) }}: <span
                                                class="badge bg-secondary">{{ $val }}/5</span></span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @auth
                            <!-- Form Ulasan -->
                            <div class="card mb-3 border-0 bg-light">
                                <div class="card-body p-3">
                                    <h6 class="card-title mb-2">Berikan Ulasan</h6>
                                    <form method="POST" action="{{ route('landing.pengaduan.ulasan.store', $item->id) }}"
                                        class="row g-2 align-items-end">
                                        @csrf
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <label class="form-label mb-0 small">Jenis</label>
                                            <select name="tipe" class="form-select form-select-sm" required>
                                                @foreach ($tipeOptions as $k => $lbl)
                                                    <option value="{{ $k }}">{{ $lbl }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-2">
                                            <label class="form-label mb-0 small">Nilai</label>
                                            <select name="nilai" class="form-select form-select-sm" required>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <label class="form-label mb-0 small">Keterangan</label>
                                            <input type="text" name="keterangan" class="form-control form-control-sm"
                                                placeholder="(Opsional)" value="{{ old('keterangan') }}">
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <button type="submit" class="btn btn-primary btn-sm w-100">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Ulasan Saya -->
                            @php
                                $myReviews = $item->ulasan->where('pengguna_id', Auth::id());
                            @endphp
                            @if ($myReviews->count())
                                <div class="card mb-3 border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0"><i class="bi bi-person-fill me-1"></i>Ulasan Saya</h6>
                                    </div>
                                    <div class="card-body p-2">
                                        @foreach ($myReviews->sortByDesc('created_at') as $ul)
                                            <div class="border-bottom pb-2 mb-2 {{ $loop->last ? '' : '' }}">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge bg-primary">{{ $tipeOptions[$ul->tipe] ?? ucfirst($ul->tipe) }}</span>
                                                    <div class="d-flex align-items-center">
                                                        <span class="badge bg-warning text-dark me-2">{{ $ul->nilai }}/5 ★</span>
                                                        <small class="text-muted">{{ $ul->created_at?->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                                @if ($ul->keterangan)
                                                    <div class="mt-1 small">{{ $ul->keterangan }}</div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-info py-2">
                                <i class="bi bi-info-circle me-1"></i>
                                Masuk untuk memberikan ulasan. <a href="/login?from_url=/pengaduan/{{ $item->id }}" class="alert-link">Login</a>
                            </div>
                        @endauth

                        <!-- Ulasan Pengguna Lain -->
                        @php
                            $otherReviews = Auth::check()
                                ? $item->ulasan->where('pengguna_id', '!=', Auth::id())
                                : $item->ulasan;
                        @endphp
                        @if ($otherReviews->count())
                            <div class="card border-secondary">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="bi bi-people-fill me-1"></i>Ulasan Pengguna Lain ({{ $otherReviews->count() }})</h6>
                                </div>
                                <div class="card-body p-2">
                                    @foreach ($otherReviews->sortByDesc('created_at') as $ul)
                                        <div class="border-bottom pb-2 mb-2 {{ $loop->last ? '' : '' }}">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center mb-1">
                                                        <span class="badge bg-secondary me-2">{{ $tipeOptions[$ul->tipe] ?? ucfirst($ul->tipe) }}</span>
                                                        <span class="badge bg-warning text-dark">{{ $ul->nilai }}/5 ★</span>
                                                    </div>
                                                    <div class="small fw-semibold text-primary">
                                                        {{ optional($ul->pengguna)->nama_lengkap ?? (optional($ul->pengguna)->username ?? 'Pengguna') }}
                                                    </div>
                                                    @if ($ul->keterangan)
                                                        <div class="mt-1 small">{{ $ul->keterangan }}</div>
                                                    @endif
                                                </div>
                                                <small class="text-muted">{{ $ul->created_at?->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="card border-secondary">
                                <div class="card-body text-center text-muted py-3">
                                    <i class="bi bi-chat-quote fs-1"></i>
                                    <p class="mb-0 mt-2">Belum ada ulasan dari pengguna lain</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Informasi Pelapor Card -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Pelapor</h5>
                        <p class="mb-1"><strong>Nama:</strong>
                            {{ optional($item->pengguna)->nama_lengkap ?? (optional($item->pengguna)->username ?? '-') }}</p>
                        <p class="mb-1"><strong>No HP:</strong> {{ optional($item->pengguna)->no_hp ?? '-' }}</p>
                        <p class="mb-1"><strong>Dibuat:</strong>
                            {{ optional($item->created_at)->translatedFormat('d F Y H:i') }}</p>
                    </div>
                </div>

                <!-- Penugasan & Eksekutor Card -->
                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Penugasan & Eksekutor</h5>
                        @php
                            $penugasanList =
                                method_exists($item, 'penugasan') || property_exists($item, 'penugasan')
                                    ? $item->penugasan ?? collect()
                                    : collect();
                        @endphp
                        @if ($penugasanList && $penugasanList->count())
                            <ul class="list-group">
                                @foreach ($penugasanList as $pg)
                                    <li class="list-group-item">
                                        <div class="fw-bold">
                                            {{ optional($pg->eksekutor)->nama_lengkap ?? (optional($pg->eksekutor)->username ?? 'Eksekutor') }}
                                        </div>
                                        <div class="small text-muted">
                                            Ditugaskan: {{ $pg->tanggal_penugasan->translatedFormat('d F Y') }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted mb-0">Belum ada penugasan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

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

@section('extra-js')
    <script>
        function showImageModal(imageSrc, imageTitle) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModalLabel').textContent = imageTitle;

            const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        }
    </script>
@endsection
