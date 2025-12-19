<?php

namespace App\Http\Controllers\global;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\KategoriPengaduan;
use App\Models\Ulasan;
use App\Rules\NoSaraWords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get("per_page", 10);
        if (!in_array($perPage, [5, 10, 20, 50, 100])) {
            $perPage = 10;
        }

        $query = Pengaduan::with(["kategori", "pengguna"]);

        // Search filter
        if ($search = trim($request->get("q", ""))) {
            $query->where(function ($q) use ($search) {
                $q->where("lokasi", "like", "%" . $search . "%")
                    ->orWhere("rincian", "like", "%" . $search . "%")
                    ->orWhereHas("pengguna", function ($q2) use ($search) {
                        $q2->where("nama_lengkap", "like", "%" . $search . "%");
                    });
            });
        }

        // Category filter
        if ($categoryId = $request->get("category_id")) {
            $query->where("kategori_id", $categoryId);
        }

        // Status filter (optional)
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
                Carbon::parse($startDate)->startOfDay(),
            );
        } elseif ($endDate) {
            $query->where(
                "tanggal_pengaduan",
                "<=",
                Carbon::parse($endDate)->endOfDay(),
            );
        }

        $pengaduan = $query
            ->orderBy("tanggal_pengaduan", "desc")
            ->paginate($perPage)
            ->withQueryString();

        $stats = [
            "total" => Pengaduan::count(),
            "baru" => Pengaduan::where("status", "baru")->count(),
            "diproses" => Pengaduan::where("status", "diproses")->count(),
            "selesai" => Pengaduan::where("status", "selesai")->count(),
            "ditolak" => Pengaduan::where("status", "ditolak")->count(),
        ];

        $categories = KategoriPengaduan::orderBy("nama")->get();
        $statuses = [
            "baru" => "Baru",
            "diproses" => "Diproses",
            "selesai" => "Selesai",
            "ditolak" => "Ditolak",
        ];

        return view("landing.pengaduan.index", [
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
        ]);
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load([
            "kategori",
            "pengguna",
            "ulasan.pengguna",
            "tindakLanjut.eksekutor",
            "penugasan.eksekutor",
        ]);
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
        // Detect existing ulasan by current user (one per tipe)
        $existingByUser = [];
        if (Auth::check()) {
            $existingByUser = $pengaduan->ulasan
                ->where("pengguna_id", Auth::id())
                ->keyBy("tipe");
        }
        return view("landing.pengaduan.show", [
            "item" => $pengaduan,
            "avgRatings" => $avgRatings,
            "overallRating" => $overall,
            "tipeOptions" => $tipeOptions,
            "existingByUser" => $existingByUser,
        ]);
    }

    public function create()
    {
        // validate auth
        $auth = Auth::user();
        if (!$auth) {
            return redirect("/login?from_url=pengaduan/create")->with(
                "error",
                "Anda harus login untuk membuat pengaduan",
            );
        }
        if ($auth->role != "penduduk") {
            return redirect("/pengaduan")->with(
                "error",
                "Hanya penduduk yang dapat membuat pengaduan",
            );
        }
        $categories = KategoriPengaduan::select("id", "nama")->get();
        return view("landing.pengaduan.create", [
            "categories" => $categories,
        ]);
    }

    public function store(Request $request)
    {
        // Validate auth
        $auth = Auth::user();
        if (!$auth) {
            return redirect("/login?from_url=pengaduan/create")->with(
                "error",
                "Anda harus login untuk membuat pengaduan",
            );
        }

        $validated = $request->validate([
            "kategori_id" => "required|exists:kategori_pengaduan,id",
            "tanggal_pengaduan" => "required|date",
            "lokasi" => [
                "required",
                "string",
                "max:255",
                new NoSaraWords("lokasi kejadian"),
            ],
            "rincian" => [
                "required",
                "string",
                new NoSaraWords("rincian pengaduan"),
            ],
            "foto.*" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
        ]);

        // Handle multiple photo uploads
        $fotoPaths = [];
        if ($request->hasFile("foto")) {
            foreach ($request->file("foto") as $file) {
                if ($file->isValid()) {
                    $filename =
                        time() .
                        "_" .
                        uniqid() .
                        "." .
                        $file->getClientOriginalExtension();
                    $path = $file->storeAs("pengaduan", $filename, "public");
                    $fotoPaths[] = $path;
                }
            }
        }

        // Create pengaduan
        $pengaduan = Pengaduan::create([
            "pengguna_id" => Auth::id(),
            "kategori_id" => $validated["kategori_id"],
            "tanggal_pengaduan" => $validated["tanggal_pengaduan"],
            "lokasi" => $validated["lokasi"],
            "rincian" => $validated["rincian"],
            "foto" => $fotoPaths,
        ]);

        return redirect()
            ->route("landing.pengaduan.show", $pengaduan->id)
            ->with("success", "Pengaduan berhasil dibuat!");
    }

    public function edit(Pengaduan $pengaduan)
    {
        // Validate auth and ownership
        $auth = Auth::user();
        if (!$auth) {
            return redirect(
                "/login?from_url=pengaduan/{$pengaduan->id}/edit",
            )->with("error", "Anda harus login untuk mengedit pengaduan");
        }

        // Check if user owns this pengaduan
        if ($pengaduan->pengguna_id !== Auth::id()) {
            return redirect()
                ->route("landing.pengaduan.show", $pengaduan->id)
                ->with(
                    "error",
                    "Anda tidak memiliki izin untuk mengedit pengaduan ini.",
                );
        }

        $categories = KategoriPengaduan::select("id", "nama")->get();
        return view("landing.pengaduan.edit", [
            "pengaduan" => $pengaduan,
            "categories" => $categories,
        ]);
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        // Validate auth and ownership
        $auth = Auth::user();
        if (!$auth) {
            return redirect(
                "/login?from_url=pengaduan/{$pengaduan->id}/edit",
            )->with("error", "Anda harus login untuk mengedit pengaduan");
        }

        // Check if user owns this pengaduan
        if ($pengaduan->pengguna_id !== Auth::id()) {
            return redirect()
                ->route("landing.pengaduan.show", $pengaduan->id)
                ->with(
                    "error",
                    "Anda tidak memiliki izin untuk mengedit pengaduan ini.",
                );
        }

        // Check if pengaduan can be edited (only if status is 'baru')
        if ($pengaduan->status !== "baru") {
            return redirect()
                ->route("landing.pengaduan.show", $pengaduan->id)
                ->with(
                    "error",
                    "Pengaduan yang sudah diproses tidak dapat diedit.",
                );
        }

        $validated = $request->validate([
            "kategori_id" => "required|exists:kategori_pengaduan,id",
            "tanggal_pengaduan" => "required|date",
            "lokasi" => [
                "required",
                "string",
                "max:255",
                new NoSaraWords("lokasi"),
            ],
            "rincian" => [
                "required",
                "string",
                new NoSaraWords("rincian pengaduan"),
            ],
            "foto.*" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
            "existing_photos" => "nullable|string", // JSON string of existing photos to keep
        ]);

        // Handle photo management
        $fotoPaths = [];
        $oldPhotos = $pengaduan->foto ?? [];

        // Keep existing photos that user wants to retain
        if (
            $request->has("existing_photos") &&
            !empty($request->existing_photos)
        ) {
            $existingPhotos = json_decode($request->existing_photos, true);
            if (is_array($existingPhotos)) {
                $fotoPaths = array_intersect($existingPhotos, $oldPhotos);
            }
        }

        // Handle new photo uploads
        if ($request->hasFile("foto")) {
            foreach ($request->file("foto") as $file) {
                if ($file->isValid()) {
                    $filename =
                        time() .
                        "_" .
                        uniqid() .
                        "." .
                        $file->getClientOriginalExtension();
                    $path = $file->storeAs("pengaduan", $filename, "public");
                    $fotoPaths[] = $path;
                }
            }
        }

        // Delete photos that are no longer needed
        $photosToDelete = array_diff($oldPhotos, $fotoPaths);
        foreach ($photosToDelete as $photoPath) {
            if (Storage::disk("public")->exists($photoPath)) {
                Storage::disk("public")->delete($photoPath);
            }
        }

        // Update pengaduan
        $pengaduan->update([
            "kategori_id" => $validated["kategori_id"],
            "tanggal_pengaduan" => $validated["tanggal_pengaduan"],
            "lokasi" => $validated["lokasi"],
            "rincian" => $validated["rincian"],
            "foto" => $fotoPaths,
        ]);

        return redirect()
            ->route("landing.pengaduan.show", $pengaduan->id)
            ->with("success", "Pengaduan berhasil diperbarui!");
    }

    public function storeUlasan(Pengaduan $pengaduan, Request $request)
    {
        $validated = $request->validate([
            "tipe" => "required|in:kepuasan,kualitas,kecepatan",
            "nilai" => "required|integer|min:1|max:5",
            "keterangan" => [
                "nullable",
                "string",
                "max:1000",
                new NoSaraWords("keterangan ulasan"),
            ],
        ]);

        // Update or create ulasan per (pengaduan, pengguna, tipe)
        $ulasan = Ulasan::where("pengaduan_id", $pengaduan->id)
            ->where("pengguna_id", Auth::id())
            ->where("tipe", $validated["tipe"])
            ->first();

        if ($ulasan) {
            $ulasan->update(
                $validated + [
                    "pengaduan_id" => $pengaduan->id,
                    "pengguna_id" => Auth::id(),
                ],
            );
            $msg = "Ulasan berhasil diperbarui.";
        } else {
            Ulasan::create(
                $validated + [
                    "pengaduan_id" => $pengaduan->id,
                    "pengguna_id" => Auth::id(),
                ],
            );
            $msg = "Ulasan berhasil ditambahkan.";
        }

        // Determine redirect route based on current route
        $routeName = $request->route()->getName();

        if (str_starts_with($routeName, "admin.")) {
            $redirectRoute = "admin.pengaduan.show";
        } elseif (str_starts_with($routeName, "eksekutor.")) {
            $redirectRoute = "eksekutor.pengaduan.show";
        } elseif (str_starts_with($routeName, "penduduk.")) {
            $redirectRoute = "penduduk.pengaduan.show";
        } else {
            $redirectRoute = "landing.pengaduan.show";
        }

        return redirect()
            ->route($redirectRoute, $pengaduan->id)
            ->with("success", $msg);
    }
}
