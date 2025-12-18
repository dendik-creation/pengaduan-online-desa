@extends('landing.layout')

@section('title', 'Data Pengaduan - Pengaduan Online Desa')
@section('description', 'Daftar pengaduan masyarakat desa')
@section('keywords', 'data, pengaduan, desa, online, list')
@section('body-class', 'starter-page-page')

@section('extra-css')
@endsection

@section('content')
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container">
            <h1>Data Pengaduan Masyarakat</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">Beranda</a></li>
                    <li class="current">Data Pengaduan</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <div class="container section-title mt-5" data-aos="fade-up">
        <h2>Statistik Pengaduan</h2>
        <p>Ringkasan data pengaduan masyarakat desa</p>
    </div>

    <!-- Stats Section -->
    <section class="stats section">
        <div class="container" data-aos="fade-up">
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <div class="card text-white bg-primary bg-gradient h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-file-earmark-text fs-1 mb-2"></i>
                            <div class="h2 fw-bold mb-0">{{ $stats['total'] ?? 0 }}</div>
                            <div class="small">Total Pengaduan</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-white bg-warning bg-gradient h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-clock-history fs-1 mb-2"></i>
                            <div class="h2 fw-bold mb-0">{{ $stats['baru'] ?? 0 }}</div>
                            <div class="small">Baru</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-white bg-info bg-gradient h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-gear fs-1 mb-2"></i>
                            <div class="h2 fw-bold mb-0">{{ $stats['diproses'] ?? 0 }}</div>
                            <div class="small">Diproses</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-white bg-success bg-gradient h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-check-circle fs-1 mb-2"></i>
                            <div class="h2 fw-bold mb-0">{{ $stats['selesai'] ?? 0 }}</div>
                            <div class="small">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Stats Section -->

    <!-- Filter Section -->
    <section class="section">
        <div class="container" data-aos="fade-up">
            <div class="flex w-100 justify-end mb-3">
                <a href="{{ route('landing.pengaduan.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Buat Pengaduan Baru
                </a>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('landing.pengaduan.index') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select" name="category_id">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" @selected($filters['category_id'] == $cat->id)>{{ $cat->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="">Semua Status</option>
                                    @foreach ($statuses as $key => $label)
                                        <option value="{{ $key }}" @selected($filters['status'] === $key)>{{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Dari Tanggal</label>
                                <input type="date" class="form-control" name="start_date"
                                    value="{{ $filters['start_date'] }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Sampai Tanggal</label>
                                <input type="date" class="form-control" name="end_date"
                                    value="{{ $filters['end_date'] }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Pencarian</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q"
                                        placeholder="Nama pelapor, rincian, atau lokasi" value="{{ $filters['q'] }}">
                                    <button class="btn btn-outline-primary" type="submit"><i
                                            class="bi bi-search"></i></button>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    <div>
                                        <select class="form-select" name="per_page" style="max-width:140px">
                                            @foreach ([5, 10, 20, 50, 100] as $pp)
                                                <option value="{{ $pp }}" @selected($filters['per_page'] == $pp)>
                                                    {{ $pp }} / page</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <a href="{{ route('landing.pengaduan.index') }}"
                                        class="btn btn-outline-secondary">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Complaints List Section -->
    <section class="section">
        <div class="container" data-aos="fade-up">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="text-muted small">
                    Menampilkan {{ $pengaduan->firstItem() ?? 0 }}–{{ $pengaduan->lastItem() ?? 0 }} dari
                    {{ $pengaduan->total() }} data
                </div>
                <div class="text-muted small">
                    Total keseluruhan: {{ $stats['total'] ?? 0 }}
                </div>
            </div>
            <div class="row">
                @forelse($pengaduan as $item)
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
                    <div class="col-12">
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span
                                        class="badge bg-{{ $badgeMap[$item->status] ?? 'secondary' }}">{{ $statusLabelMap[$item->status] ?? $item->status }}</span>
                                    <small class="text-muted">{{ $item->tanggal_pengaduan->format('d M Y') }}</small>
                                </div>
                                <h5 class="card-title mb-1">{{ $item->lokasi }}</h5>
                                <p class="card-text text-muted mb-2">
                                    {{ \Illuminate\Support\Str::limit($item->rincian, 180) }}</p>
                                @php
                                    $avg = $item->ulasan->count() ? round($item->ulasan->avg('nilai'), 1) : null;
                                @endphp
                                @if ($avg)
                                    <div class="mb-2"><span class="badge bg-primary">Rating
                                            {{ $avg }}/5</span></div>
                                @endif
                                <div class="d-flex justify-content-between align-items-center small text-muted">
                                    <div>
                                        <span
                                            class="badge bg-light text-dark">{{ $item->kategori->nama ?? 'Kategori' }}</span>
                                        @if ($item->pengguna)
                                            <span class="ms-2">oleh:
                                                {{ $item->pengguna->nama_lengkap ?? $item->pengguna->username }}</span>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-1">
                                        @if (Auth::user()?->id == $item->pengguna_id)
                                            <a href="{{ route('landing.pengaduan.edit', $item) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            @endif
                                            <a href="{{ route('landing.pengaduan.show', $item) }}"
                                                class="btn btn-secondary btn-sm">
                                                <i class="bi bi-eye"></i> Lihat
                                            </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info mb-0">Tidak ada pengaduan ditemukan untuk filter yang diberikan.</div>
                    </div>
                @endforelse

                <div class="col-12 mt-4">
                    {{ $pengaduan->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </section>


    <script>
        (function() {
            const form = document.querySelector('form[action="{{ route('landing.pengaduan.index') }}"]');
            if (!form) return;
            const perPage = form.querySelector('select[name="per_page"]');
            if (perPage) {
                perPage.addEventListener('change', function() {
                    form.submit();
                });
            }
        })();
    </script>
@endsection
