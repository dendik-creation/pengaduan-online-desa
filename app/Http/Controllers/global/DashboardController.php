<?php

namespace App\Http\Controllers\global;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\User;
use App\Models\KategoriPengaduan;
use App\Models\Ulasan;
use App\Models\Penugasan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        // Total statistics
        $totalPengaduan = Pengaduan::count();
        $totalPenduduk = User::where('role', 'penduduk')->count();
        $totalKategori = KategoriPengaduan::count();
        $pengaduanMenunggu = Pengaduan::where('status', 'baru')->count();

        // Pengaduan per bulan untuk chart (12 bulan terakhir)
        $pengaduanPerBulan = [];
        $bulanLabels = [];

        for ($i = 11; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $bulanLabels[] = $bulan->format('M Y');
            $pengaduanPerBulan[] = Pengaduan::whereYear('tanggal_pengaduan', $bulan->year)->whereMonth('tanggal_pengaduan', $bulan->month)->count();
        }

        // Status pengaduan untuk pie chart
        $statusData = Pengaduan::select('status', DB::raw('count(*) as total'))->groupBy('status')->get();

        // Kategori pengaduan terpopuler
        $kategoriPopuler = KategoriPengaduan::withCount('pengaduan')->orderBy('pengaduan_count', 'desc')->take(5)->get();

        // Rating rata-rata dari ulasan
        $ratingRataRata = Ulasan::avg('nilai') ?? 0;

        // Pengaduan terbaru
        $pengaduanTerbaru = Pengaduan::with(['pengguna', 'kategori'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Persentase penyelesaian pengaduan bulan ini
        $pengaduanBulanIni = Pengaduan::whereMonth('tanggal_pengaduan', Carbon::now()->month)
            ->whereYear('tanggal_pengaduan', Carbon::now()->year)
            ->count();

        $pengaduanSelesaiBulanIni = Pengaduan::whereMonth('tanggal_pengaduan', Carbon::now()->month)
            ->whereYear('tanggal_pengaduan', Carbon::now()->year)
            ->where('status', 'selesai')
            ->count();

        $persentasePenyelesaian = $pengaduanBulanIni > 0 ? round(($pengaduanSelesaiBulanIni / $pengaduanBulanIni) * 100) : 0;
        $title = 'Admin | Dashboard';

        return view('admin.dashboard', compact('title', 'totalPengaduan', 'totalPenduduk', 'totalKategori', 'pengaduanMenunggu', 'pengaduanPerBulan', 'bulanLabels', 'statusData', 'kategoriPopuler', 'ratingRataRata', 'pengaduanTerbaru', 'persentasePenyelesaian'));
    }

    public function pendudukDashboard()
    {
        $userId = Auth::id();
        
        // Total pengaduan yang dibuat user ini
        $totalPengaduanSaya = Pengaduan::where('pengguna_id', $userId)->count();
        
        // Pengaduan berdasarkan status
        $pengaduanBaru = Pengaduan::where('pengguna_id', $userId)->where('status', 'baru')->count();
        $pengaduanDiproses = Pengaduan::where('pengguna_id', $userId)->where('status', 'diproses')->count();
        $pengaduanSelesai = Pengaduan::where('pengguna_id', $userId)->where('status', 'selesai')->count();
        
        // Pengaduan terbaru milik user
        $pengaduanTerbaru = Pengaduan::where('pengguna_id', $userId)
            ->with(['kategori', 'penugasan.eksekutor'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Statistik komunitas untuk memberikan konteks
        $totalPengaduanKomunitas = Pengaduan::count();
        $pengaduanSelesaiKomunitas = Pengaduan::where('status', 'selesai')->count();
        $tingkatPenyelesaianKomunitas = $totalPengaduanKomunitas > 0 ? 
            round(($pengaduanSelesaiKomunitas / $totalPengaduanKomunitas) * 100) : 0;
        
        // Kategori pengaduan terpopuler di komunitas
        $kategoriPopuler = KategoriPengaduan::withCount('pengaduan')
            ->orderBy('pengaduan_count', 'desc')
            ->take(5)
            ->get();
        
        // Riwayat pengaduan user per bulan (6 bulan terakhir)
        $riwayatBulanan = [];
        $labelBulan = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $labelBulan[] = $bulan->format('M Y');
            $riwayatBulanan[] = Pengaduan::where('pengguna_id', $userId)
                ->whereYear('tanggal_pengaduan', $bulan->year)
                ->whereMonth('tanggal_pengaduan', $bulan->month)
                ->count();
        }
        
        // Status terkini pengaduan user
        $statusDistribusi = Pengaduan::where('pengguna_id', $userId)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
        
        // Rata-rata rating yang diberikan user
        $ratingRataRata = Ulasan::whereHas('pengaduan', function($query) use ($userId) {
            $query->where('pengguna_id', $userId);
        })->avg('nilai') ?? 0;
        
        // Waktu rata-rata penyelesaian pengaduan user
        $waktuRataRataPenyelesaian = $this->getUserAverageCompletionTime($userId);
        
        $title = 'Penduduk | Dashboard';
        
        return view('penduduk.dashboard', compact(
            'title',
            'totalPengaduanSaya',
            'pengaduanBaru',
            'pengaduanDiproses', 
            'pengaduanSelesai',
            'pengaduanTerbaru',
            'totalPengaduanKomunitas',
            'tingkatPenyelesaianKomunitas',
            'kategoriPopuler',
            'riwayatBulanan',
            'labelBulan',
            'statusDistribusi',
            'ratingRataRata',
            'waktuRataRataPenyelesaian'
        ));
    }

    public function eksekutorDashboard()
    {
        $userId = Auth::id();
        
        // Total penugasan untuk eksekutor ini (User dengan role eksekutor)
        $totalPenugasan = Penugasan::where('eksekutor_id', $userId)->count();
        
        // Penugasan aktif (pengaduan yang belum selesai)
        $penugasanAktif = Penugasan::where('eksekutor_id', $userId)
            ->whereHas('pengaduan', function($query) {
                $query->whereIn('status', ['baru', 'diproses']);
            })->count();
        
        // Penugasan selesai
        $penugasanSelesai = Penugasan::where('eksekutor_id', $userId)
            ->whereHas('pengaduan', function($query) {
                $query->where('status', 'selesai');
            })->count();
        
        // Tingkat penyelesaian
        $tingkatPenyelesaian = $totalPenugasan > 0 ? round(($penugasanSelesai / $totalPenugasan) * 100) : 0;
        
        // Penugasan terbaru untuk eksekutor ini
        $penugasanTerbaru = Penugasan::where('eksekutor_id', $userId)
            ->with(['pengaduan.kategori', 'pengaduan.pengguna'])
            ->orderBy('tanggal_penugasan', 'desc')
            ->take(5)
            ->get();
        
        // Status pengaduan yang ditangani eksekutor
        $statusPengaduan = Penugasan::where('eksekutor_id', $userId)
            ->with('pengaduan')
            ->get()
            ->groupBy('pengaduan.status')
            ->map(function($group) {
                return $group->count();
            });
        
        // Pengaduan per kategori yang ditangani
        $pengaduanPerKategori = Penugasan::where('eksekutor_id', $userId)
            ->with(['pengaduan.kategori'])
            ->get()
            ->groupBy('pengaduan.kategori.nama')
            ->map(function($group) {
                return $group->count();
            })->take(5);
        
        // Rata-rata waktu penyelesaian (dalam hari)
        $waktuPenyelesaianRataRata = $this->getAverageCompletionTime($userId);
        
        // Progress mingguan (4 minggu terakhir)
        $progressMingguan = $this->getWeeklyProgress($userId);
        
        $title = 'Eksekutor | Dashboard';
        
        return view('eksekutor.dashboard', compact(
            'title', 
            'totalPenugasan', 
            'penugasanAktif', 
            'penugasanSelesai', 
            'tingkatPenyelesaian',
            'penugasanTerbaru',
            'statusPengaduan',
            'pengaduanPerKategori',
            'waktuPenyelesaianRataRata',
            'progressMingguan'
        ));
    }
    
    /**
     * Calculate average completion time for eksekutor (User ID)
     */
    private function getAverageCompletionTime($userId)
    {
        $completedTasks = Penugasan::where('eksekutor_id', $userId)
            ->whereHas('pengaduan', function($query) {
                $query->where('status', 'selesai');
            })
            ->with('pengaduan')
            ->get();
        
        if ($completedTasks->isEmpty()) return 0;
        
        $totalDays = 0;
        foreach ($completedTasks as $task) {
            $startDate = Carbon::parse($task->tanggal_penugasan);
            $endDate = Carbon::parse($task->pengaduan->updated_at);
            $totalDays += $startDate->diffInDays($endDate);
        }
        
        return round($totalDays / $completedTasks->count(), 1);
    }
    
    /**
     * Get weekly progress for eksekutor (User ID)
     */
    private function getWeeklyProgress($userId)
    {
        $progress = [];
        for ($i = 3; $i >= 0; $i--) {
            $weekStart = Carbon::now()->subWeeks($i)->startOfWeek();
            $weekEnd = Carbon::now()->subWeeks($i)->endOfWeek();
            
            $completed = Penugasan::where('eksekutor_id', $userId)
                ->whereHas('pengaduan', function($query) use ($weekStart, $weekEnd) {
                    $query->where('status', 'selesai')
                          ->whereBetween('updated_at', [$weekStart, $weekEnd]);
                })->count();
            
            $progress[] = $completed;
        }
        
        return $progress;
    }
    
    /**
     * Calculate average completion time for user's complaints
     */
    private function getUserAverageCompletionTime($userId)
    {
        $completedComplaints = Pengaduan::where('pengguna_id', $userId)
            ->where('status', 'selesai')
            ->get();
        
        if ($completedComplaints->isEmpty()) return 0;
        
        $totalDays = 0;
        foreach ($completedComplaints as $complaint) {
            $startDate = Carbon::parse($complaint->tanggal_pengaduan);
            $endDate = Carbon::parse($complaint->updated_at);
            $totalDays += $startDate->diffInDays($endDate);
        }
        
        return round($totalDays / $completedComplaints->count(), 1);
    }
}
