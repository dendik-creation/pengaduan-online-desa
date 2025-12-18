<?php

namespace App\Http\Controllers\eksekutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Penugasan;
use App\Models\KategoriPengaduan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        
        // Build query untuk pengaduan yang ditugaskan ke eksekutor ini
        $query = Pengaduan::whereHas('penugasan', function($q) use ($userId) {
            $q->where('eksekutor_id', $userId);
        })->with(['pengguna', 'kategori', 'penugasan' => function($q) use ($userId) {
            $q->where('eksekutor_id', $userId);
        }]);
        
        // Filter berdasarkan pencarian
        $filters = [
            'q' => $request->get('q', ''),
            'category_id' => $request->get('category_id', ''),
            'status' => $request->get('status', ''),
            'start_date' => $request->get('start_date', ''),
            'end_date' => $request->get('end_date', ''),
            'per_page' => $request->get('per_page', 10)
        ];
        
        if (!empty($filters['q'])) {
            $query->where(function($q) use ($filters) {
                $q->where('lokasi', 'like', '%' . $filters['q'] . '%')
                  ->orWhere('rincian', 'like', '%' . $filters['q'] . '%')
                  ->orWhereHas('pengguna', function($subq) use ($filters) {
                      $subq->where('nama_lengkap', 'like', '%' . $filters['q'] . '%')
                           ->orWhere('username', 'like', '%' . $filters['q'] . '%');
                  });
            });
        }
        
        if (!empty($filters['category_id'])) {
            $query->where('kategori_id', $filters['category_id']);
        }
        
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (!empty($filters['start_date'])) {
            $query->whereDate('tanggal_pengaduan', '>=', $filters['start_date']);
        }
        
        if (!empty($filters['end_date'])) {
            $query->whereDate('tanggal_pengaduan', '<=', $filters['end_date']);
        }
        
        // Paginate results
        $pengaduan = $query->orderBy('tanggal_pengaduan', 'desc')
                          ->paginate($filters['per_page'])
                          ->withQueryString();
        
        // Get statistics
        $stats = [
            'total' => Pengaduan::whereHas('penugasan', function($q) use ($userId) {
                $q->where('eksekutor_id', $userId);
            })->count(),
            'baru' => Pengaduan::whereHas('penugasan', function($q) use ($userId) {
                $q->where('eksekutor_id', $userId);
            })->where('status', 'baru')->count(),
            'diproses' => Pengaduan::whereHas('penugasan', function($q) use ($userId) {
                $q->where('eksekutor_id', $userId);
            })->where('status', 'diproses')->count(),
            'selesai' => Pengaduan::whereHas('penugasan', function($q) use ($userId) {
                $q->where('eksekutor_id', $userId);
            })->where('status', 'selesai')->count(),
        ];
        
        // Get categories for filter
        $categories = KategoriPengaduan::orderBy('nama')->get();
        
        // Status options
        $statuses = [
            'baru' => 'Baru',
            'diproses' => 'Diproses', 
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];
        
        $title = 'Pengaduan Saya';
        $description = 'Daftar pengaduan yang ditugaskan kepada Anda sebagai eksekutor';
        
        return view('eksekutor.pengaduan.index', compact(
            'pengaduan', 'stats', 'categories', 'statuses', 'filters', 'title', 'description'
        ));
    }

    public function show($id)
    {
        $userId = Auth::id();
        
        // Pastikan pengaduan ini ditugaskan ke eksekutor yang sedang login
        $pengaduan = Pengaduan::whereHas('penugasan', function($q) use ($userId) {
            $q->where('eksekutor_id', $userId);
        })->with([
            'pengguna',
            'kategori', 
            'penugasan' => function($q) use ($userId) {
                $q->where('eksekutor_id', $userId)->with('eksekutor');
            },
            'tindakLanjut' => function($q) {
                $q->orderBy('tanggal_update', 'desc');
            },
            'ulasan.pengguna'
        ])->findOrFail($id);
        
        $title = 'Detail Pengaduan';
        $description = 'Detail lengkap pengaduan yang ditugaskan kepada Anda';
        
        // Tipe options untuk ulasan
        $tipeOptions = [
            'kepuasan' => 'Kepuasan',
            'kualitas' => 'Kualitas',
            'kecepatan' => 'Kecepatan'
        ];
        
        // Hitung rating keseluruhan
        $overallRating = null;
        $avgRatings = [];
        
        if ($pengaduan->ulasan->count() > 0) {
            $overallRating = round($pengaduan->ulasan->avg('nilai'), 1);
            
            foreach ($tipeOptions as $tipe => $label) {
                $avgRatings[$tipe] = round($pengaduan->ulasan->where('tipe', $tipe)->avg('nilai') ?? 0, 1);
            }
        }
        
        return view('eksekutor.pengaduan.show', compact(
            'pengaduan', 'title', 'description', 'tipeOptions', 'overallRating', 'avgRatings'
        ));
    }
}
