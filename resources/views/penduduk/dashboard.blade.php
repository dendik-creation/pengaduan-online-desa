@extends('layout.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Penduduk</h1>
        <div class="d-flex align-items-center">
            <a href="{{ route('landing.pengaduan.create') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Buat Pengaduan Baru
            </a>
        </div>
    </div>

    <!-- Content Row - Statistics Cards -->
    <div class="row">
        <!-- Total Pengaduan Saya Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pengaduan Saya</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPengaduanSaya }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengaduan Baru Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Menunggu Diproses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengaduanBaru }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengaduan Diproses Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sedang Diproses
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengaduanDiproses }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cogs fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengaduan Selesai Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengaduanSelesai }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - Performance & Rating Cards -->
    <div class="row">
        <!-- Tingkat Penyelesaian Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-line"></i> Tingkat Penyelesaian
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="display-4 text-info mb-3">{{ $tingkatPenyelesaianUser }}%</div>
                    <p class="text-muted mb-3">Dari total {{ $totalPengaduanSaya }} pengaduan Anda</p>

                    @if($tingkatPenyelesaianUser >= 80)
                        <div class="alert alert-success mb-0">
                            <i class="fas fa-thumbs-up"></i> Sebagian besar pengaduan Anda telah diselesaikan!
                        </div>
                    @elseif($tingkatPenyelesaianUser >= 50)
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i> Pengaduan Anda sedang dalam proses penyelesaian.
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-clock"></i> Pengaduan Anda akan segera diproses.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Rating Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-star"></i> Rating Pelayanan
                    </h6>
                </div>
                <div class="card-body text-center">
                    @if($ratingRataRata > 0)
                        <div class="display-4 text-warning mb-3">
                            <i class="fas fa-star"></i> {{ number_format($ratingRataRata, 1) }}/5
                        </div>
                        <p class="text-muted mb-3">Rating rata-rata yang Anda berikan</p>

                        @if($ratingRataRata >= 4)
                            <div class="alert alert-success mb-0">
                                <i class="fas fa-heart"></i> Anda puas dengan pelayanan yang diberikan!
                            </div>
                        @elseif($ratingRataRata >= 3)
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-smile"></i> Pelayanan cukup memuaskan untuk Anda.
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">
                                <i class="fas fa-meh"></i> Kami akan terus berusaha meningkatkan pelayanan.
                            </div>
                        @endif
                    @else
                        <div class="py-4">
                            <i class="fas fa-star-half-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada rating yang diberikan</p>
                            <small class="text-muted">Rating akan muncul setelah Anda memberikan ulasan</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Waktu Penyelesaian Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-clock"></i> Waktu Penyelesaian
                    </h6>
                </div>
                <div class="card-body text-center">
                    @if($waktuRataRataPenyelesaian > 0)
                        <div class="display-4 text-success mb-3">{{ $waktuRataRataPenyelesaian }}</div>
                        <p class="text-muted mb-3">Hari rata-rata penyelesaian</p>

                        @if($waktuRataRataPenyelesaian <= 7)
                            <div class="alert alert-success mb-0">
                                <i class="fas fa-rocket"></i> Pengaduan Anda diselesaikan dengan cepat!
                            </div>
                        @elseif($waktuRataRataPenyelesaian <= 14)
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-check"></i> Waktu penyelesaian dalam batas normal.
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">
                                <i class="fas fa-hourglass"></i> Penyelesaian membutuhkan waktu lebih lama.
                            </div>
                        @endif
                    @else
                        <div class="py-4">
                            <i class="fas fa-hourglass-start fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data waktu penyelesaian</p>
                            <small class="text-muted">Data akan muncul setelah ada pengaduan yang selesai</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - Charts -->
    <div class="row">
        <!-- Riwayat Pengaduan Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-area"></i> Riwayat Pengaduan Saya (6 Bulan Terakhir)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                    <div class="mt-3 text-center">
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i>
                            Grafik menunjukkan tren pengaduan yang Anda laporkan dalam 6 bulan terakhir
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Distribution Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie"></i> Status Pengaduan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @if($statusDistribusi->isNotEmpty())
                            @foreach($statusDistribusi as $status)
                                <span class="mr-2">
                                    <i class="fas fa-circle
                                        @if($status->status == 'baru') text-warning
                                        @elseif($status->status == 'diproses') text-primary
                                        @elseif($status->status == 'selesai') text-success
                                        @else text-danger
                                        @endif
                                    "></i>
                                    {{ ucfirst($status->status) }} ({{ $status->total }})
                                </span>
                            @endforeach
                        @else
                            <span class="text-muted">Belum ada pengaduan</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - Recent Activities & Quick Actions -->
    <div class="row">
        <!-- Pengaduan Terbaru Saya -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list"></i> Pengaduan Terbaru Saya
                    </h6>
                    <a href="{{ route('penduduk.pengaduan.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if($pengaduanTerbaru->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Kategori</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Eksekutor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengaduanTerbaru as $pengaduan)
                                    <tr>
                                        <td>
                                            <div class="text-sm font-weight-bold">
                                                {{ $pengaduan->tanggal_pengaduan->format('d/m/Y') }}
                                            </div>
                                            <div class="text-xs text-muted">
                                                {{ $pengaduan->tanggal_pengaduan->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-light">
                                                {{ $pengaduan->kategori->nama ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-sm">
                                                {{ Str::limit($pengaduan->lokasi, 30) }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge
                                                @if($pengaduan->status == 'baru') badge-warning
                                                @elseif($pengaduan->status == 'diproses') badge-primary
                                                @elseif($pengaduan->status == 'selesai') badge-success
                                                @else badge-danger
                                                @endif
                                            ">
                                                {{ ucfirst($pengaduan->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($pengaduan->penugasan && count($pengaduan->penugasan) > 0)
                                                <div class="text-sm">
                                                    @foreach($pengaduan->penugasan as $penugasan)
                                                        {{ $penugasan->eksekutor->nama_lengkap ?? 'Eksekutor' }}
                                                        @if(!$loop->last), @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada pengaduan</h5>
                            <p class="text-muted">Anda belum pernah membuat pengaduan. Klik tombol di bawah untuk membuat pengaduan pertama.</p>
                            <a href="{{ route('landing.pengaduan.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Buat Pengaduan Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
// Chart untuk Riwayat Pengaduan
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($labelBulan) !!},
        datasets: [{
            label: "Pengaduan Saya",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: {!! json_encode($riwayatBulanan) !!},
        }],
    },
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
        },
        scales: {
            xAxes: [{
                time: {
                    unit: 'date'
                },
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 6
                }
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    stepSize: 1
                },
                gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }],
        },
        legend: {
            display: false
        },
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                    return tooltipItem.value + ' pengaduan';
                }
            }
        }
    }
});

// Chart untuk Status Distribution
var ctx2 = document.getElementById("myPieChart");
var statusLabels = [];
var statusCounts = [];
var statusColors = [];

@if($statusDistribusi->isNotEmpty())
    @foreach($statusDistribusi as $status)
        statusLabels.push('{{ ucfirst($status->status) }}');
        statusCounts.push({{ $status->total }});
        @if($status->status == 'baru')
            statusColors.push('#f6c23e');
        @elseif($status->status == 'diproses')
            statusColors.push('#4e73df');
        @elseif($status->status == 'selesai')
            statusColors.push('#1cc88a');
        @else
            statusColors.push('#e74a3b');
        @endif
    @endforeach
@else
    statusLabels.push('Belum ada data');
    statusCounts.push(1);
    statusColors.push('#e3e6f0');
@endif

var myPieChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: statusLabels,
        datasets: [{
            data: statusCounts,
            backgroundColor: statusColors,
            hoverBackgroundColor: statusColors,
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var meta = dataset._meta[Object.keys(dataset._meta)[0]];
                    var total = meta.total;
                    var currentValue = dataset.data[tooltipItem.index];
                    var percentage = parseFloat((currentValue/total*100).toFixed(1));
                    return currentValue + ' (' + percentage + '%)';
                }
            }
        },
        legend: {
            display: false
        },
        cutoutPercentage: 80,
    },
});
</script>
@endpush
