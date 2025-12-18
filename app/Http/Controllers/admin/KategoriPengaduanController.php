<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPengaduan;
use Illuminate\Http\Request;

class KategoriPengaduanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $title = 'Master Kategori Pengaduan';
        $description = 'Daftar seluruh kategori pengaduan yang tersedia.';

        $kategori = KategoriPengaduan::when($search, function ($query, $search) {
                $query->where('nama', 'like', "%$search%")
                      ->orWhere('deskripsi', 'like', "%$search%");
            })
            ->orderBy('nama')
            ->paginate(config('custom.pagination.size'));

        return view('admin.kategori_pengaduan.index', compact('kategori', 'search', 'title', 'description'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_pengaduan,nama',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriPengaduan::create($validated);

        return redirect()->route('kategori-pengaduan.index')->with('success', 'Kategori pengaduan berhasil ditambahkan.');
    }

    public function update($id, Request $request)
    {
        $kategori = KategoriPengaduan::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_pengaduan,nama,' . $kategori->id,
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori-pengaduan.index')->with('success', 'Kategori pengaduan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = KategoriPengaduan::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori-pengaduan.index')->with('success', 'Kategori pengaduan berhasil dihapus.');
    }
}
