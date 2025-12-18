<?php

namespace App\Http\Controllers\penduduk;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\KategoriPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get("per_page", 10);
        if (!in_array($perPage, [5, 10, 20, 50])) {
            $perPage = 10;
        }

        // Query pengaduan milik user yang login
        $query = Pengaduan::with(["kategori"])
            ->where("pengguna_id", Auth::id());

        // Search filter
        if ($search = trim($request->get("q", ""))) {
            $query->where(function ($q) use ($search) {
                $q->where("lokasi", "like", "%" . $search . "%")
                  ->orWhere("rincian", "like", "%" . $search . "%");
            });
        }

        // Category filter
        if ($categoryId = $request->get("category_id")) {
            $query->where("kategori_id", $categoryId);
        }

        // Status filter
        if ($status = $request->get("status")) {
            $query->where("status", $status);
        }

        // Date range filter
        $startDate = $request->get("start_date");
        $endDate = $request->get("end_date");
        if ($startDate && $endDate) {
            $query->whereBetween("tanggal_pengaduan", [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        } elseif ($startDate) {
            $query->where(
                "tanggal_pengaduan",
                ">=",
                Carbon::parse($startDate)->startOfDay()
            );
        } elseif ($endDate) {
            $query->where(
                "tanggal_pengaduan",
                "<=",
                Carbon::parse($endDate)->endOfDay()
            );
        }

        $pengaduan = $query
            ->orderBy("tanggal_pengaduan", "desc")
            ->paginate($perPage)
            ->withQueryString();

        // Stats untuk user yang login
        $stats = [
            "total" => Pengaduan::where("pengguna_id", Auth::id())->count(),
            "baru" => Pengaduan::where("pengguna_id", Auth::id())->where("status", "baru")->count(),
            "diproses" => Pengaduan::where("pengguna_id", Auth::id())->where("status", "diproses")->count(),
            "selesai" => Pengaduan::where("pengguna_id", Auth::id())->where("status", "selesai")->count(),
            "ditolak" => Pengaduan::where("pengguna_id", Auth::id())->where("status", "ditolak")->count(),
        ];

        $categories = KategoriPengaduan::orderBy("nama")->get();
        $statuses = [
            "baru" => "Baru",
            "diproses" => "Diproses", 
            "selesai" => "Selesai",
            "ditolak" => "Ditolak",
        ];

        return view("penduduk.pengaduan.index", [
            "pengaduan" => $pengaduan,
            "categories" => $categories,
            "stats" => $stats,
            "statuses" => $statuses,
            "filters" => [
                "q" => $search ?? "",
                "category_id" => $categoryId ?? "",
                "status" => $status ?? "",
                "start_date" => $startDate ?? "",
                "end_date" => $endDate ?? "",
                "per_page" => $perPage,
            ],
            "title" => "Pengaduan Saya"
        ]);
    }

    public function show($id)
    {
        // Validasi bahwa pengaduan milik user yang login
        $pengaduan = Pengaduan::with([
            "kategori",
            "pengguna", 
            "ulasan.pengguna",
            "tindakLanjut.eksekutor",
            "penugasan.eksekutor",
            "komentar.pengguna"
        ])
        ->where("id", $id)
        ->where("pengguna_id", Auth::id())
        ->first();

        if (!$pengaduan) {
            abort(404, "Pengaduan tidak ditemukan atau Anda tidak memiliki akses.");
        }

        // Aggregate ulasan
        $avgRatings = $pengaduan->ulasan
            ->groupBy("tipe")
            ->map(fn($grp) => round($grp->avg("nilai"), 2));
        $overall = $pengaduan->ulasan->count()
            ? round($pengaduan->ulasan->avg("nilai"), 2)
            : null;
        
        $tipeOptions = [
            "kepuasan" => "Kepuasan",
            "kualitas" => "Kualitas", 
            "kecepatan" => "Kecepatan",
        ];

        return view("penduduk.pengaduan.show", [
            "item" => $pengaduan,
            "avgRatings" => $avgRatings,
            "overallRating" => $overall,
            "tipeOptions" => $tipeOptions,
            "title" => "Detail Pengaduan #" . $pengaduan->id
        ]);
    }
}
