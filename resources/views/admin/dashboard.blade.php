@extends('layout.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
    </div>


    <!-- Content Row -->
    <div class="row">

        <!-- Total Pengaduan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pengaduan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalPengaduan) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Penduduk Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Penduduk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalPenduduk) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tingkat Penyelesaian (Bulan Ini)
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $persentasePenyelesaian }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $persentasePenyelesaian }}%"
                                            aria-valuenow="{{ $persentasePenyelesaian }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengaduan Menunggu Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pengaduan Menunggu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($pengaduanMenunggu) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Perkembangan Pengaduan (12 Bulan Terakhir)</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Opsi Chart:</div>
                            <a class="dropdown-item" href="#">Lihat Detail</a>
                            <a class="dropdown-item" href="#">Export Data</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Refresh</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Status Pengaduan</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Opsi Chart:</div>
                            <a class="dropdown-item" href="#">Lihat Detail</a>
                            <a class="dropdown-item" href="#">Export Data</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Refresh</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach($statusData as $status)
                        <span class="mr-2">
                            <i class="fas fa-circle 
                                @if($status->status == 'baru') text-warning
                                @elseif($status->status == 'diproses') text-primary
                                @elseif($status->status == 'selesai') text-success
                                @else text-danger
                                @endif"></i> 
                            {{ ucfirst($status->status) }} ({{ $status->total }})
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-6 mb-4">

            <!-- Kategori Pengaduan Populer -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Kategori Pengaduan Terpopuler</h6>
                </div>
                <div class="card-body">
                    @foreach($kategoriPopuler as $kategori)
                    <h4 class="small font-weight-bold">{{ $kategori->nama }} 
                        <span class="float-right">{{ $kategori->pengaduan_count }} pengaduan</span>
                    </h4>
                    <div class="progress mb-4">
                        @php
                            $percentage = $totalPengaduan > 0 ? ($kategori->pengaduan_count / $totalPengaduan) * 100 : 0;
                            $colorClass = 'bg-primary';
                            if($percentage >= 80) $colorClass = 'bg-danger';
                            elseif($percentage >= 60) $colorClass = 'bg-warning';
                            elseif($percentage >= 40) $colorClass = 'bg-info';
                            elseif($percentage >= 20) $colorClass = 'bg-success';
                        @endphp
                        <div class="progress-bar {{ $colorClass }}" role="progressbar" 
                            style="width: {{ $percentage }}%" 
                            aria-valuenow="{{ $percentage }}" 
                            aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    @endforeach
                    
                    @if($kategoriPopuler->count() == 0)
                        <p class="text-muted">Belum ada data kategori pengaduan.</p>
                    @endif
                </div>
            </div>

            <!-- Ringkasan Sistem -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ringkasan Performa Sistem</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <i class="fas fa-users fa-2x text-primary mb-2"></i>
                                    <h6 class="font-weight-bold">Total Kategori</h6>
                                    <p class="mb-0">{{ $totalKategori }} kategori</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <i class="fas fa-star fa-2x text-warning mb-2"></i>
                                    <h6 class="font-weight-bold">Rating Rata-rata</h6>
                                    <p class="mb-0">{{ number_format($ratingRataRata, 1) }}/5.0</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kesimpulan Performa -->
                    <div class="mt-3">
                        <h6 class="font-weight-bold text-dark">Kesimpulan Performa:</h6>
                        @php
                            $tingkatPenyelesaian = $persentasePenyelesaian;
                            $ratingBagus = $ratingRataRata >= 4;
                            $pengaduanMenungguSedikit = $pengaduanMenunggu < ($totalPengaduan * 0.2);
                        @endphp
                        
                        @if($tingkatPenyelesaian >= 80 && $ratingBagus && $pengaduanMenungguSedikit)
                            <div class="alert alert-success mb-2">
                                <i class="fas fa-check-circle"></i> 
                                <strong>Performa Sangat Baik!</strong> Sistem berjalan dengan efisien dengan tingkat penyelesaian {{ $tingkatPenyelesaian }}% dan rating {{ number_format($ratingRataRata, 1) }}/5.
                            </div>
                        @elseif($tingkatPenyelesaian >= 60)
                            <div class="alert alert-warning mb-2">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Performa Cukup Baik.</strong> Tingkat penyelesaian {{ $tingkatPenyelesaian }}% masih bisa ditingkatkan.
                            </div>
                        @else
                            <div class="alert alert-danger mb-2">
                                <i class="fas fa-times-circle"></i>
                                <strong>Performa Perlu Perbaikan.</strong> Tingkat penyelesaian hanya {{ $tingkatPenyelesaian }}%, perlu peningkatan pelayanan.
                            </div>
                        @endif
                        
                        <small class="text-muted">
                            Dashboard ini menampilkan data real-time dari sistem pengaduan online desa untuk membantu monitoring dan evaluasi pelayanan publik.
                        </small>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-6 mb-4">

            <!-- Rating Pelayanan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rating Pelayanan</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="display-4 text-primary mb-3">
                            <i class="fas fa-star"></i> {{ number_format($ratingRataRata, 1) }}/5
                        </div>
                    </div>
                    <p>Rating rata-rata pelayanan sistem pengaduan online berdasarkan ulasan masyarakat. 
                       Rating yang tinggi menunjukkan kepuasan masyarakat terhadap pelayanan yang diberikan.</p>
                    
                    @if($ratingRataRata >= 4)
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle"></i> Pelayanan sangat baik! Pertahankan kualitas pelayanan.
                        </div>
                    @elseif($ratingRataRata >= 3)
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> Pelayanan cukup baik, masih bisa ditingkatkan.
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-times-circle"></i> Pelayanan perlu perbaikan segera.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pengaduan Terbaru -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pengaduan Terbaru</h6>
                </div>
                <div class="card-body">
                    @if($pengaduanTerbaru->count() > 0)
                        @foreach($pengaduanTerbaru as $pengaduan)
                        <div class="border-bottom pb-2 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ Str::limit($pengaduan->rincian, 50) }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-user"></i> {{ $pengaduan->pengguna->nama_lengkap ?? 'User' }} - 
                                        <i class="fas fa-tag"></i> {{ $pengaduan->kategori->nama ?? 'Kategori' }}
                                    </small>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> {{ $pengaduan->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div>
                                    <span class="badge 
                                        @if($pengaduan->status == 'baru') badge-warning
                                        @elseif($pengaduan->status == 'diproses') badge-primary
                                        @elseif($pengaduan->status == 'selesai') badge-success
                                        @else badge-danger
                                        @endif
                                    ">
                                        {{ ucfirst($pengaduan->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="text-center">
                            <a href="#" class="btn btn-sm btn-primary">Lihat Semua Pengaduan</a>
                        </div>
                    @else
                        <p class="text-muted text-center">Belum ada pengaduan.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>
// Data untuk Area Chart (Perkembangan Pengaduan)
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($bulanLabels) !!},
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
            data: {!! json_encode($pengaduanPerBulan) !!},
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
                    maxTicksLimit: 7
                }
            }],
            yAxes: [{
                ticks: {
                    maxTicksLimit: 5,
                    padding: 10,
                    callback: function(value, index, values) {
                        return value;
                    }
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

// Data untuk Pie Chart (Status Pengaduan)
var ctx2 = document.getElementById("myPieChart");
var statusLabels = [];
var statusCounts = [];
var statusColors = [];

@foreach($statusData as $status)
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
                    var value = chart.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                    var total = chart.datasets[tooltipItem.datasetIndex].data.reduce((a, b) => a + b, 0);
                    var percentage = Math.round((value / total) * 100);
                    return label + ': ' + value + ' (' + percentage + '%)';
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
