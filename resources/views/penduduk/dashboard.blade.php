@extends('layout.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Penduduk</h1>
        <a href="{{ route('landing.pengaduan.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Buat Pengaduan Baru
        </a>
    </div>

    <!-- Content Row -->
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

    <!-- Content Row -->
    <div class="row">

        <!-- Riwayat Pengaduan Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Pengaduan Saya (6 Bulan Terakhir)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Distribusi Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Status Pengaduan Saya</h6>
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

    <!-- Content Row -->
    <div class="row">
        <!-- Pengaduan Terbaru Saya -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pengaduan Terbaru Saya</h6>
                </div>
                <div class="card-body">
                    @if($pengaduanTerbaru->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Kategori</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Ditangani Oleh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengaduanTerbaru as $pengaduan)
                                    <tr>
                                        <td>{{ $pengaduan->tanggal_pengaduan->format('d/m/Y') }}</td>
                                        <td>{{ $pengaduan->kategori->nama }}</td>
                                        <td>{{ $pengaduan->lokasi }}</td>
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
                                            @if($pengaduan->penugasan->isNotEmpty())
                                                {{ $pengaduan->penugasan->first()->eksekutor->nama_lengkap }}
                                            @else
                                                <span class="text-muted">Belum ditugaskan</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-3">Anda belum membuat pengaduan</p>
                            <a href="{{ route('landing.pengaduan.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Buat Pengaduan Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informasi & Statistik -->
        <div class="col-lg-4 mb-4">
            <!-- Rating Saya -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rating Rata-rata Saya</h6>
                </div>
                <div class="card-body text-center">
                    <div class="h2 mb-0 font-weight-bold text-primary">{{ number_format($ratingRataRata, 1) }}</div>
                    <div class="text-muted mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= round($ratingRataRata) ? 'text-warning' : 'text-muted' }}"></i>
                        @endfor
                    </div>
                    <hr>
                    <div class="text-xs">
                        <i class="fas fa-info-circle text-primary"></i>
                        Rating yang Anda berikan untuk layanan
                    </div>
                </div>
            </div>

            <!-- Waktu Penyelesaian -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Waktu Rata-rata Penyelesaian</h6>
                </div>
                <div class="card-body text-center">
                    <div class="h2 mb-0 font-weight-bold text-success">{{ $waktuRataRataPenyelesaian }}</div>
                    <div class="text-muted">hari</div>
                    <hr>
                    <div class="text-xs">
                        <i class="fas fa-clock text-success"></i>
                        Waktu rata-rata pengaduan Anda diselesaikan
                    </div>
                </div>
            </div>

            <!-- Statistik Komunitas -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Komunitas</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="h4 mb-0 font-weight-bold text-info">{{ $totalPengaduanKomunitas }}</div>
                        <div class="text-xs text-muted">Total Pengaduan Komunitas</div>
                    </div>
                    <div class="text-center mb-3">
                        <div class="h4 mb-0 font-weight-bold text-success">{{ $tingkatPenyelesaianKomunitas }}%</div>
                        <div class="text-xs text-muted">Tingkat Penyelesaian</div>
                    </div>
                    <hr>
                    <div class="text-xs text-center">
                        <i class="fas fa-users text-info"></i>
                        Data keseluruhan komunitas desa
                    </div>
                </div>
            </div>

            <!-- Kategori Terpopuler -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Kategori Terpopuler</h6>
                </div>
                <div class="card-body">
                    @if($kategoriPopuler->isNotEmpty())
                        @foreach($kategoriPopuler->take(3) as $kategori)
                        <h4 class="small font-weight-bold">{{ $kategori->nama }} 
                            <span class="float-right">{{ $kategori->pengaduan_count }}</span>
                        </h4>
                        <div class="progress mb-4">
                            @php
                                $max = $kategoriPopuler->first()->pengaduan_count;
                                $percentage = $max > 0 ? ($kategori->pengaduan_count / $max) * 100 : 0;
                            @endphp
                            <div class="progress-bar 
                                @if($loop->index == 0) bg-primary
                                @elseif($loop->index == 1) bg-success  
                                @else bg-info
                                @endif
                            " role="progressbar" style="width: {{ $percentage }}%"
                                aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-chart-bar fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Belum ada data kategori</p>
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
            label: "Jumlah Pengaduan",
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
                    unit: 'month'
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
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': ' + tooltipItem.yLabel + ' pengaduan';
                }
            }
        }
    }
});

// Chart untuk Status Distribusi
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
    statusLabels.push('Belum ada pengaduan');
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
                label: function(tooltipItem, chart) {
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    var label = chart.labels[tooltipItem.index];
                    var value = chart.datasets[0].data[tooltipItem.index];
                    return label + ': ' + value + ' pengaduan';
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
