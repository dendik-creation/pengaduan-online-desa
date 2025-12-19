@extends('layout.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
        <div class="text-muted">
            <i class="fas fa-calendar-alt"></i> {{ date('d F Y') }}
        </div>
    </div>

    <!-- Content Row - Main Statistics -->
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tingkat Penyelesaian
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

    <!-- Content Row - Charts -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Trend Pengaduan (12 Bulan Terakhir)</h6>
                </div>
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
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Status Pengaduan</h6>
                </div>
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

    <!-- Content Row - Performance Summary & Rating -->
    <div class="row">
        <!-- Ringkasan Performa Sistem -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ringkasan Performa Sistem</h6>
                </div>
                <div class="card-body">
                    <!-- Key Performance Indicators -->
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <div class="border rounded p-3 mb-3">
                                <i class="fas fa-tachometer-alt fa-2x text-info mb-2"></i>
                                <h6 class="font-weight-bold">Efisiensi</h6>
                                <h4 class="text-info">{{ $persentasePenyelesaian }}%</h4>
                                <small class="text-muted">Pengaduan selesai/total bulan ini</small>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="border rounded p-3 mb-3">
                                <i class="fas fa-clock fa-2x text-success mb-2"></i>
                                <h6 class="font-weight-bold">Kecepatan</h6>
                                <h4 class="text-success">{{ $waktuRataRataPenyelesaian }}</h4>
                                <small class="text-muted">Rata-rata hari penyelesaian</small>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="border rounded p-3 mb-3">
                                <i class="fas fa-users-cog fa-2x text-primary mb-2"></i>
                                <h6 class="font-weight-bold">SDM</h6>
                                <h4 class="text-primary">{{ $totalEksekutor }}</h4>
                                <small class="text-muted">Jumlah eksekutor terdaftar</small>
                            </div>
                        </div>
                    </div>

                        <!-- Informasi Sumber Data -->
                        <div class="mt-3 p-3 bg-light rounded">
                            <h6 class="font-weight-bold"><i class="fas fa-info-circle text-info"></i> Informasi Data:</h6>
                            <ul class="mb-0 small">
                                <li><strong>Efisiensi ({{ $persentasePenyelesaian }}%)</strong> - Persentase pengaduan yang selesai dari total pengaduan bulan ini</li>
                                <li><strong>Kecepatan ({{ $waktuRataRataPenyelesaian }} hari)</strong> - Rata-rata waktu penyelesaian dari semua pengaduan yang sudah selesai</li>
                                <li><strong>SDM ({{ $totalEksekutor }} orang)</strong> - Jumlah eksekutor aktif yang siap menangani pengaduan</li>
                            </ul>
                        </div>
                </div>
            </div>
        </div>

        <!-- Rating Pelayanan Berdasarkan Kategori -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Evaluasi Rating Pelayanan</h6>
                </div>
                <div class="card-body">
                    <!-- Rating Keseluruhan -->
                    <div class="text-center mb-4 p-3 bg-light rounded">
                        <div class="display-4 text-primary mb-2">
                            <i class="fas fa-star"></i> {{ number_format($ratingRataRata, 1) }}/5.0
                        </div>
                        <p class="mb-0 font-weight-bold">Rating Keseluruhan</p>
                        <small class="text-muted">Berdasarkan {{ \App\Models\Ulasan::count() }} ulasan dari pengaduan selesai</small>
                    </div>

                    <!-- Rating per Kategori -->
                    <div class="mb-4">
                        <h6 class="font-weight-bold mb-3">Rating per Aspek Pelayanan:</h6>
                        <!-- Kepuasan -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-sm font-weight-bold">
                                    <i class="fas fa-smile text-success"></i> Kepuasan Pelayanan
                                </span>
                                <span class="font-weight-bold">{{ number_format($ratingKepuasan, 1) }}/5
                                    <small class="text-muted">({{ \App\Models\Ulasan::where('tipe', 'kepuasan')->count() }})</small>
                                </span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: {{ ($ratingKepuasan / 5) * 100 }}%"></div>
                            </div>
                        </div>

                        <!-- Kualitas -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-sm font-weight-bold">
                                    <i class="fas fa-award text-primary"></i> Kualitas Penanganan
                                </span>
                                <span class="font-weight-bold">{{ number_format($ratingKualitas, 1) }}/5
                                    <small class="text-muted">({{ \App\Models\Ulasan::where('tipe', 'kualitas')->count() }})</small>
                                </span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar"
                                     style="width: {{ ($ratingKualitas / 5) * 100 }}%"></div>
                            </div>
                        </div>

                        <!-- Kecepatan -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-sm font-weight-bold">
                                    <i class="fas fa-tachometer-alt text-info"></i> Kecepatan Respon
                                </span>
                                <span class="font-weight-bold">{{ number_format($ratingKecepatan, 1) }}/5
                                    <small class="text-muted">({{ \App\Models\Ulasan::where('tipe', 'kecepatan')->count() }})</small>
                                </span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info" role="progressbar"
                                     style="width: {{ ($ratingKecepatan / 5) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Sumber -->
                    <div class="mt-3">
                        <small class="text-muted">
                            Data ulasan diambil dari pengaduan yang telah diselesaikan oleh eksekutor
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - Additional Information -->
    <div class="row">
        <!-- Kategori Pengaduan Populer -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Kategori Pengaduan Terpopuler</h6>
                </div>
                <div class="card-body">
                    @if($kategoriPopuler->count() > 0)
                        @foreach($kategoriPopuler as $index => $kategori)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="font-weight-bold">{{ $kategori->nama }}</span>
                                <span class="badge badge-primary">{{ $kategori->pengaduan_count }}</span>
                            </div>
                            <div class="progress">
                                @php
                                    $maxCount = $kategoriPopuler->first()->pengaduan_count ?? 1;
                                    $percentage = $maxCount > 0 ? ($kategori->pengaduan_count / $maxCount) * 100 : 0;
                                    $colors = ['bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-secondary'];
                                    $colorClass = $colors[$index % count($colors)];
                                @endphp
                                <div class="progress-bar {{ $colorClass }}" role="progressbar"
                                     style="width: {{ $percentage }}%"
                                     aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                Data menunjukkan kategori pengaduan yang paling sering dilaporkan masyarakat
                            </small>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data kategori pengaduan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pengaduan Terbaru -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pengaduan Terbaru</h6>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @if($pengaduanTerbaru->count() > 0)
                        @foreach($pengaduanTerbaru as $pengaduan)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ Str::limit($pengaduan->rincian, 60) }}</h6>
                                    <div class="small text-muted mb-2">
                                        <i class="fas fa-user"></i> {{ $pengaduan->pengguna->nama_lengkap ?? 'Anonim' }}
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-tag"></i> {{ $pengaduan->kategori->nama ?? '-' }}
                                    </div>
                                    <div class="small text-muted">
                                        <i class="fas fa-map-marker-alt"></i> {{ Str::limit($pengaduan->lokasi, 30) }}
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-clock"></i> {{ $pengaduan->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <div class="ml-2">
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

                        <div class="text-center mt-3">
                            <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Lihat Semua Pengaduan
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada pengaduan masuk.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
// Chart untuk Trend Pengaduan
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
                    unit: 'date'
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
                    return tooltipItem.value + ' pengaduan';
                }
            }
        }
    }
});

// Chart untuk Status Pengaduan
var ctx2 = document.getElementById("myPieChart");
var statusLabels = [];
var statusCounts = [];
var statusColors = [];

@if($statusData->isNotEmpty())
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
