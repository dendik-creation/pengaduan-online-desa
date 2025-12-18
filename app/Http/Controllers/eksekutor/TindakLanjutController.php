<?php

namespace App\Http\Controllers\eksekutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TindakLanjut;
use App\Models\Pengaduan;
use App\Rules\NoSaraWords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TindakLanjutController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Build query untuk tindak lanjut yang dibuat oleh eksekutor ini
        $query = TindakLanjut::where("eksekutor_id", $userId)->with([
            "pengaduan.kategori",
            "pengaduan.pengguna",
        ]);

        // Filter berdasarkan pencarian
        $filters = [
            "q" => $request->get("q", ""),
            "status" => $request->get("status", ""),
            "start_date" => $request->get("start_date", ""),
            "end_date" => $request->get("end_date", ""),
            "per_page" => $request->get("per_page", 10),
        ];

        if (!empty($filters["q"])) {
            $query->where(function ($q) use ($filters) {
                $q->where(
                    "catatan",
                    "like",
                    "%" . $filters["q"] . "%",
                )->orWhereHas("pengaduan", function ($subq) use ($filters) {
                    $subq
                        ->where("lokasi", "like", "%" . $filters["q"] . "%")
                        ->orWhere("rincian", "like", "%" . $filters["q"] . "%");
                });
            });
        }

        if (!empty($filters["status"])) {
            $query->where("status", $filters["status"]);
        }

        if (!empty($filters["start_date"])) {
            $query->whereDate("tanggal_update", ">=", $filters["start_date"]);
        }

        if (!empty($filters["end_date"])) {
            $query->whereDate("tanggal_update", "<=", $filters["end_date"]);
        }

        // Paginate results
        $tindakLanjut = $query
            ->orderBy("tanggal_update", "desc")
            ->paginate($filters["per_page"])
            ->withQueryString();

        // Get statistics
        $stats = [
            "total" => TindakLanjut::where("eksekutor_id", $userId)->count(),
            "progress" => TindakLanjut::where("eksekutor_id", $userId)
                ->where("status", "progress")
                ->count(),
            "selesai" => TindakLanjut::where("eksekutor_id", $userId)
                ->where("status", "selesai")
                ->count(),
            "terhambat" => TindakLanjut::where("eksekutor_id", $userId)
                ->where("status", "terhambat")
                ->count(),
        ];

        // Status options
        $statuses = [
            "progress" => "Progress",
            "selesai" => "Selesai",
            "terhambat" => "Terhambat",
        ];

        $title = "Tindak Lanjut Saya";
        $description = "Daftar tindak lanjut yang telah Anda buat";

        return view(
            "eksekutor.tindak-lanjut.index",
            compact(
                "tindakLanjut",
                "stats",
                "statuses",
                "filters",
                "title",
                "description",
            ),
        );
    }

    public function create(Request $request)
    {
        $pengaduanId = $request->get("pengaduan_id");
        $userId = Auth::id();

        // Validasi bahwa pengaduan ini ditugaskan ke eksekutor yang sedang login
        $pengaduan = Pengaduan::whereHas("penugasan", function ($q) use (
            $userId,
        ) {
            $q->where("eksekutor_id", $userId);
        })
            ->with(["kategori", "pengguna"])
            ->findOrFail($pengaduanId);

        $title = "Tambah Tindak Lanjut";
        $description = "Buat laporan tindak lanjut untuk pengaduan";

        return view(
            "eksekutor.tindak-lanjut.create",
            compact("pengaduan", "title", "description"),
        );
    }

    public function store(Request $request)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            "pengaduan_id" => "required|exists:pengaduan,id",
            "catatan" => [
                "required",
                "string",
                "max:1000",
                new NoSaraWords("catatan tindak lanjut"),
            ],
            "status" => "required|in:progress,selesai,terhambat",
            "tanggal_update" => "required|date",
            "foto.*" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
        ]);

        // Validasi bahwa pengaduan ini ditugaskan ke eksekutor yang sedang login
        $pengaduan = Pengaduan::whereHas("penugasan", function ($q) use (
            $userId,
        ) {
            $q->where("eksekutor_id", $userId);
        })->findOrFail($request->pengaduan_id);

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
                    $path = $file->storeAs(
                        "tindak_lanjut",
                        $filename,
                        "public",
                    );
                    $fotoPaths[] = $path;
                }
            }
        }

        // Create tindak lanjut
        $tindakLanjut = TindakLanjut::create([
            "pengaduan_id" => $validated["pengaduan_id"],
            "eksekutor_id" => $userId,
            "catatan" => $validated["catatan"],
            "status" => $validated["status"],
            "tanggal_update" => $validated["tanggal_update"],
            "foto" => $fotoPaths,
        ]);

        // Update status pengaduan jika tindak lanjut selesai
        if ($validated["status"] === "selesai") {
            $pengaduan->update(["status" => "selesai"]);
        } elseif ($pengaduan->status === "baru") {
            $pengaduan->update(["status" => "diproses"]);
        }

        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                "success" => true,
                "message" => "Tindak lanjut berhasil ditambahkan.",
                "redirect" => route(
                    "eksekutor.pengaduan.show",
                    $validated["pengaduan_id"],
                ),
            ]);
        }

        return redirect()
            ->route("eksekutor.pengaduan.show", $validated["pengaduan_id"])
            ->with("success", "Tindak lanjut berhasil ditambahkan.");
    }

    public function show($id)
    {
        $userId = Auth::id();

        $tindakLanjut = TindakLanjut::where("eksekutor_id", $userId)
            ->with(["pengaduan.kategori", "pengaduan.pengguna", "eksekutor"])
            ->findOrFail($id);

        $title = "Detail Tindak Lanjut";
        $description = "Detail lengkap laporan tindak lanjut";

        return view(
            "eksekutor.tindak-lanjut.show",
            compact("tindakLanjut", "title", "description"),
        );
    }

    public function edit($id)
    {
        $userId = Auth::id();

        $tindakLanjut = TindakLanjut::where("eksekutor_id", $userId)
            ->with(["pengaduan.kategori", "pengaduan.pengguna"])
            ->findOrFail($id);

        $title = "Edit Tindak Lanjut";
        $description = "Edit laporan tindak lanjut";

        return view(
            "eksekutor.tindak-lanjut.edit",
            compact("tindakLanjut", "title", "description"),
        );
    }

    public function update(Request $request, $id)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            "catatan" => [
                "required",
                "string",
                "max:1000",
                new NoSaraWords("catatan tindak lanjut"),
            ],
            "status" => "required|in:progress,selesai,terhambat",
            "tanggal_update" => "required|date",
            "foto.*" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
            "existing_photos" => "nullable|string", // JSON string of existing photos to keep
        ]);

        $tindakLanjut = TindakLanjut::where(
            "eksekutor_id",
            $userId,
        )->findOrFail($id);

        // Handle photo management
        $fotoPaths = [];
        $oldPhotos = $tindakLanjut->foto ?? [];

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
                    $path = $file->storeAs(
                        "tindak_lanjut",
                        $filename,
                        "public",
                    );
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

        // Update tindak lanjut
        $tindakLanjut->update([
            "catatan" => $validated["catatan"],
            "status" => $validated["status"],
            "tanggal_update" => $validated["tanggal_update"],
            "foto" => $fotoPaths,
        ]);

        // Update status pengaduan jika diperlukan
        $pengaduan = $tindakLanjut->pengaduan;
        if ($validated["status"] === "selesai") {
            $pengaduan->update(["status" => "selesai"]);
        } elseif ($pengaduan->status === "baru") {
            $pengaduan->update(["status" => "diproses"]);
        }

        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                "success" => true,
                "message" => "Tindak lanjut berhasil diperbarui.",
                "redirect" => route(
                    "eksekutor.tindak-lanjut.show",
                    $tindakLanjut->id,
                ),
            ]);
        }

        return redirect()
            ->route("eksekutor.tindak-lanjut.show", $tindakLanjut->id)
            ->with("success", "Tindak lanjut berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $userId = Auth::id();

        $tindakLanjut = TindakLanjut::where(
            "eksekutor_id",
            $userId,
        )->findOrFail($id);

        // Delete photos
        if ($tindakLanjut->foto) {
            foreach ($tindakLanjut->foto as $photo) {
                Storage::disk("public")->delete($photo);
            }
        }

        $pengaduanId = $tindakLanjut->pengaduan_id;
        $tindakLanjut->delete();

        return redirect()
            ->route("eksekutor.pengaduan.show", $pengaduanId)
            ->with("success", "Tindak lanjut berhasil dihapus.");
    }
}
