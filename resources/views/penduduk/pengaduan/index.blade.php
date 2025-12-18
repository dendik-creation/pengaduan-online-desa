@extends('layout.app')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('landing.pengaduan.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Buat Pengaduan Baru
        </a>
    </div>

    <!-- Stats Cards Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pengaduan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Baru</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['baru'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Diproses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['diproses'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cogs fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['selesai'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTales Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('penduduk.pengaduan.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Cari</label>
                        <input type="text" class="form-control" name="q" value="{{ $filters['q'] }}" 
                               placeholder="Cari lokasi atau rincian...">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-control" name="category_id">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $filters['category_id'] == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status">
                            <option value="">Semua Status</option>
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ $filters['status'] === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" class="form-control" name="start_date" value="{{ $filters['start_date'] }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" class="form-control" name="end_date" value="{{ $filters['end_date'] }}">
                    </div>
                    <div class="col-md-1 mb-3">
                        <label class="form-label">Per Hal</label>
                        <select class="form-control" name="per_page">
                            <option value="5" {{ $filters['per_page'] == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ $filters['per_page'] == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ $filters['per_page'] == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ $filters['per_page'] == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <a href="{{ route('penduduk.pengaduan.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-sync"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTables Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengaduan Saya</h6>
        </div>
        <div class="card-body">
            @if($pengaduan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Rincian</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengaduan as $index => $item)
                            <tr>
                                <td>{{ $pengaduan->firstItem() + $index }}</td>
                                <td>{{ $item->tanggal_pengaduan->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $item->kategori->nama }}</span>
                                </td>
                                <td>{{ Str::limit($item->lokasi, 30) }}</td>
                                <td>{{ Str::limit($item->rincian, 50) }}</td>
                                <td>
                                    @switch($item->status)
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
                                        @default
                                            <span class="badge badge-secondary">{{ $item->status }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('penduduk.pengaduan.show', $item->id) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan {{ $pengaduan->firstItem() }} sampai {{ $pengaduan->lastItem() }} 
                        dari {{ $pengaduan->total() }} entri
                    </div>
                    <div>
                        {{ $pengaduan->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">Belum Ada Pengaduan</h5>
                    <p class="text-gray-500">Anda belum membuat pengaduan apapun.</p>
                    <a href="{{ route('landing.pengaduan.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat Pengaduan Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection
