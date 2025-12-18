<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\KategoriPengaduan;
use App\Models\Penugasan;
use App\Models\User;
use App\Rules\NoSaraWords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get("per_page", 10);
        if (!in_array($perPage, [5, 10, 20, 50])) {
            $perPage = 10;
        }

        $query = Pengaduan::with(['pengguna', 'kategori', 'penugasan.eksekutor']);

        // Search filter
        if ($search = trim($request->get("q", ""))) {
            $query->where(function ($q) use ($search) {
                $q->where("lokasi", "like", "%" . $search . "%")
                  ->orWhere("rincian", "like", "%" . $search . "%")
                  ->orWhereHas('pengguna', function($qq) use ($search) {
                      $qq->where('nama_lengkap', 'like', "%$search%")
                         ->orWhere('username', 'like', "%$search%");
                  })
                  ->orWhereHas('kategori', function($qq) use ($search) {
                      $qq->where('nama', 'like', "%$search%");
                  });
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
                \Carbon\Carbon::parse($startDate)->startOfDay(),
                \Carbon\Carbon::parse($endDate)->endOfDay(),
            ]);
        } elseif ($startDate) {
            $query->where(
                "tanggal_pengaduan",
                ">=",
                \Carbon\Carbon::parse($startDate)->startOfDay()
            );
        } elseif ($endDate) {
            $query->where(
                "tanggal_pengaduan",
                "<=",
                \Carbon\Carbon::parse($endDate)->endOfDay()
            );
        }

        $pengaduan = $query
            ->orderBy("tanggal_pengaduan", "desc")
            ->paginate($perPage)
            ->withQueryString();

        // Stats untuk semua pengaduan
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

        $title = 'Data Pengaduan';
        $description = 'Daftar pengaduan penduduk untuk ditindaklanjuti.';

        return view('admin.pengaduan.index', [
            'pengaduan' => $pengaduan,
            'categories' => $categories,
            'stats' => $stats,
            'statuses' => $statuses,
            'filters' => [
                'q' => $search ?? "",
                'category_id' => $categoryId ?? "",
                'status' => $status ?? "",
                'start_date' => $startDate ?? "",
                'end_date' => $endDate ?? "",
                'per_page' => $perPage,
            ],
            'title' => $title,
            'description' => $description
        ]);
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load([
            'pengguna',
            'kategori',
            'penugasan.eksekutor',
            'ulasan.pengguna',
            'tindakLanjut.eksekutor'
        ]);
        
        // Aggregate ulasan
        $avgRatings = $pengaduan->ulasan
            ->groupBy("tipe")
            ->map(fn($grp) => round($grp->avg("nilai"), 2));
        $overallRating = $pengaduan->ulasan->count()
            ? round($pengaduan->ulasan->avg("nilai"), 2)
            : null;
        $tipeOptions = [
            "kepuasan" => "Kepuasan",
            "kualitas" => "Kualitas",
            "kecepatan" => "Kecepatan",
        ];
        
        $title = 'Detail Pengaduan';
        $description = 'Informasi lengkap pengaduan dan tindak lanjut.';
        $statuses = ['baru','diproses','selesai','ditolak'];
        $eksekutorList = User::where('role', 'eksekutor')->orderBy('nama_lengkap')->get();
        
        return view('admin.pengaduan.show', compact(
            'pengaduan','title','description','statuses','eksekutorList',
            'avgRatings','overallRating','tipeOptions'
        ));
    }

    public function edit(Pengaduan $pengaduan)
    {
        $title = 'Edit Pengaduan';
        $kategoriList = KategoriPengaduan::orderBy('nama')->get();
        return view('admin.pengaduan.edit', compact('pengaduan','title','kategoriList'));
    }

    public function update(Pengaduan $pengaduan, Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_pengaduan,id',
            'tanggal_pengaduan' => 'required|date',
            'lokasi' => ['required', 'string', 'max:255', new NoSaraWords('lokasi')],
            'rincian' => ['required', 'string', new NoSaraWords('rincian pengaduan')],
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('dokumen')) {
            if ($pengaduan->dokumen) {
                Storage::delete($pengaduan->dokumen);
            }
            $path = $request->file('dokumen')->store('pengaduan');
            $validated['dokumen'] = $path;
        }

        $pengaduan->update($validated);
        return redirect()->route('admin.pengaduan.show', $pengaduan->id)->with('success','Pengaduan berhasil diperbarui.');
    }

    public function destroy(Pengaduan $pengaduan)
    {
        if ($pengaduan->dokumen) {
            Storage::delete($pengaduan->dokumen);
        }
        $pengaduan->delete();
        return redirect()->route('admin.pengaduan.index')->with('success','Pengaduan berhasil dihapus.');
    }

    public function updateStatus(Pengaduan $pengaduan, Request $request)
    {
        $validated = $request->validate([
            'status_baru' => 'required|in:baru,diproses,selesai,ditolak',
        ]);
        $statusBaru = $validated['status_baru'];
        $statusLama = $pengaduan->status;
        if ($statusBaru === $statusLama) {
            return back()->with('info','Status tidak berubah.');
        }
        // Simple transition rule example (could be expanded)
        $allowed = [
            'baru' => ['diproses','ditolak'],
            'diproses' => ['selesai','ditolak'],
            'selesai' => [],
            'ditolak' => [],
        ];
        if (!in_array($statusBaru, $allowed[$statusLama])) {
            return back()->with('error','Transisi status tidak diizinkan.');
        }
        $pengaduan->update(['status' => $statusBaru]);
        return back()->with('success','Status pengaduan berhasil diperbarui.');
    }

    public function assignEksekutor(Pengaduan $pengaduan, Request $request)
    {
        $validated = $request->validate([
            'eksekutor_id' => 'required|exists:users,id',
            'tanggal_penugasan' => 'required|date',
        ]);
        
        // Pastikan user yang dipilih adalah eksekutor
        $eksekutor = User::where('id', $validated['eksekutor_id'])->where('role', 'eksekutor')->first();
        if (!$eksekutor) {
            return back()->with('error', 'User yang dipilih bukan eksekutor.');
        }
        
        // prevent duplicate eksekutor assignment for same pengaduan (optional rule)
        $exists = Penugasan::where('pengaduan_id',$pengaduan->id)
            ->where('eksekutor_id',$validated['eksekutor_id'])
            ->exists();
        if ($exists) {
            return back()->with('error','Eksekutor sudah ditugaskan untuk pengaduan ini.');
        }
        Penugasan::create([
            'pengaduan_id' => $pengaduan->id,
            'eksekutor_id' => $validated['eksekutor_id'],
            'admin_id' => Auth::id(),
            'tanggal_penugasan' => $validated['tanggal_penugasan'],
        ]);
        // optionally auto move status to diproses if still baru
        if ($pengaduan->status === 'baru') {
            $pengaduan->update(['status' => 'diproses']);
        }
        return back()->with('success','Eksekutor berhasil ditugaskan.');
    }
}
