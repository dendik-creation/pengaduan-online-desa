@extends('layout.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/eksekutor/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tindak Lanjut</li>
                </ol>
            </nav>
            <p class="text-muted mb-0">{{ $description }}</p>
        </div>
    </div>

    @include('partials.toaster')

    <!-- Stats Cards Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Tindak Lanjut</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
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
                                Progress</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['progress'] ?? 0 }}</div>
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

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Terhambat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['terhambat'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('eksekutor.tindak-lanjut.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Cari</label>
                        <input type="text" class="form-control" name="q" value="{{ $filters['q'] }}"
                               placeholder="Cari catatan, lokasi pengaduan...">
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
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Per Hal</label>
                        <select class="form-control" name="per_page">
                            <option value="5" {{ $filters['per_page'] == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ $filters['per_page'] == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ $filters['per_page'] == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ $filters['per_page'] == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                    <div class="col-md-1 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary btn-sm mr-1">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('eksekutor.tindak-lanjut.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-sync"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTables Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Tindak Lanjut</h6>
        </div>
        <div class="card-body">
            @if($tindakLanjut->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Update</th>
                                <th>Pengaduan</th>
                                <th>Catatan</th>
                                <th>Status</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tindakLanjut as $index => $item)
                            <tr>
                                <td>{{ $tindakLanjut->firstItem() + $index }}</td>
                                <td>{{ $item->tanggal_update->format('d/m/Y') }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ Str::limit($item->pengaduan->lokasi, 30) }}</div>
                                    <div class="small text-muted">{{ $item->pengaduan->kategori->nama }}</div>
                                    <div class="small">Oleh: {{ $item->pengaduan->pengguna->nama_lengkap ?? $item->pengaduan->pengguna->username }}</div>
                                </td>
                                <td>{{ Str::limit($item->catatan, 60) }}</td>
                                <td>
                                    @switch($item->status)
                                        @case('progress')
                                            <span class="badge badge-info">Progress</span>
                                            @break
                                        @case('selesai')
                                            <span class="badge badge-success">Selesai</span>
                                            @break
                                        @case('terhambat')
                                            <span class="badge badge-danger">Terhambat</span>
                                            @break
                                        @default
                                            <span class="badge badge-secondary">{{ $item->status }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    @if($item->foto && count($item->foto) > 0)
                                        <span class="badge badge-primary">{{ count($item->foto) }} foto</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('eksekutor.tindak-lanjut.show', $item->id) }}"
                                       class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('eksekutor.tindak-lanjut.edit', $item->id) }}"
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus"
                                            onclick="deleteTindakLanjut({{ $item->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan {{ $tindakLanjut->firstItem() }} sampai {{ $tindakLanjut->lastItem() }}
                        dari {{ $tindakLanjut->total() }} entri
                    </div>
                    <div>
                        {{ $tindakLanjut->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">Tidak Ada Tindak Lanjut</h5>
                    <p class="text-gray-500">Belum ada tindak lanjut yang dibuat.</p>
                    <a href="{{ route('eksekutor.pengaduan.index') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Lihat Pengaduan
                    </a>
                </div>
            @endif
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
function deleteTindakLanjut(id) {
    document.getElementById('deleteTindakLanjutModalForm').action = '/eksekutor/tindak-lanjut/' + id;
    $('#deleteTindakLanjutModal').modal('show');
}
</script>
@endpush
