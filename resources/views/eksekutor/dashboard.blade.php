@extends('layout.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Eksekutor</h1>
        <p class="text-muted">{{ Auth::user()->nama_lengkap }}</p>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Total Penugasan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Penugasan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPenugasan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Penugasan Aktif Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Penugasan Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $penugasanAktif }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Penugasan Selesai Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Penugasan Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $penugasanSelesai }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tingkat Penyelesaian Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tingkat Penyelesaian
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $tingkatPenyelesaian }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ $tingkatPenyelesaian }}%" aria-valuenow="{{ $tingkatPenyelesaian }}" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Progress Mingguan Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Progress Penyelesaian (4 Minggu Terakhir)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Pengaduan Pie Chart -->
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
                        @if($statusPengaduan->isNotEmpty())
                            @foreach($statusPengaduan as $status => $count)
                                <span class="mr-2">
                                    <i class="fas fa-circle 
                                        @if($status == 'baru') text-warning
                                        @elseif($status == 'diproses') text-primary
                                        @elseif($status == 'selesai') text-success
                                        @else text-danger
                                        @endif
                                    "></i>
                                    {{ ucfirst($status) }} ({{ $count }})
                                </span>
                            @endforeach
                        @else
                            <span class="text-muted">Belum ada data</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Penugasan Terbaru -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Penugasan Terbaru</h6>
                </div>
                <div class="card-body">
                    @if($penugasanTerbaru->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Kategori</th>
                                        <th>Pelapor</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($penugasanTerbaru as $penugasan)
                                    <tr>
                                        <td>{{ $penugasan->tanggal_penugasan->format('d/m/Y') }}</td>
                                        <td>{{ $penugasan->pengaduan->kategori->nama }}</td>
                                        <td>{{ $penugasan->pengaduan->pengguna->nama_lengkap ?? $penugasan->pengaduan->pengguna->username }}</td>
                                        <td>{{ $penugasan->pengaduan->lokasi }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($penugasan->pengaduan->status == 'baru') badge-warning
                                                @elseif($penugasan->pengaduan->status == 'diproses') badge-primary
                                                @elseif($penugasan->pengaduan->status == 'selesai') badge-success
                                                @else badge-danger
                                                @endif
                                            ">
                                                {{ ucfirst($penugasan->pengaduan->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada penugasan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistik & Kategori -->
        <div class="col-lg-4 mb-4">
            <!-- Waktu Penyelesaian -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Waktu Rata-rata Penyelesaian</h6>
                </div>
                <div class="card-body text-center">
                    <div class="h2 mb-0 font-weight-bold text-primary">{{ $waktuPenyelesaianRataRata }}</div>
                    <div class="text-muted">hari</div>
                    <hr>
                    <div class="text-xs">
                        <i class="fas fa-info-circle text-primary"></i>
                        Rata-rata waktu dari penugasan hingga selesai
                    </div>
                </div>
            </div>

            <!-- Kategori Pengaduan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Kategori yang Ditangani</h6>
                </div>
                <div class="card-body">
                    @if($pengaduanPerKategori->isNotEmpty())
                        @foreach($pengaduanPerKategori as $kategori => $jumlah)
                        <h4 class="small font-weight-bold">{{ $kategori }} 
                            <span class="float-right">{{ $jumlah }}</span>
                        </h4>
                        <div class="progress mb-4">
                            @php
                                $max = $pengaduanPerKategori->max();
                                $percentage = $max > 0 ? ($jumlah / $max) * 100 : 0;
                            @endphp
                            <div class="progress-bar 
                                @if($loop->index == 0) bg-primary
                                @elseif($loop->index == 1) bg-success  
                                @elseif($loop->index == 2) bg-info
                                @elseif($loop->index == 3) bg-warning
                                @else bg-danger
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
// Chart untuk Progress Mingguan
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['3 Minggu Lalu', '2 Minggu Lalu', 'Minggu Lalu', 'Minggu Ini'],
        datasets: [{
            label: "Pengaduan Selesai",
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
            data: {!! json_encode($progressMingguan) !!},
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
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 4
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
            caretPadding: 10
        }
    }
});

// Chart untuk Status Pengaduan
var ctx2 = document.getElementById("myPieChart");
var statusLabels = [];
var statusCounts = [];
var statusColors = [];

@if($statusPengaduan->isNotEmpty())
    @foreach($statusPengaduan as $status => $count)
        statusLabels.push('{{ ucfirst($status) }}');
        statusCounts.push({{ $count }});
        @if($status == 'baru')
            statusColors.push('#f6c23e');
        @elseif($status == 'diproses')
            statusColors.push('#4e73df');
        @elseif($status == 'selesai')
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
            caretPadding: 10
        },
        legend: {
            display: false
        },
        cutoutPercentage: 80,
    },
});
</script>
@endpush
