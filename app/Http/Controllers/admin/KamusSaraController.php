<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\KamusSara;
use App\Helpers\SaraChecker;
use Illuminate\Http\Request;

class KamusSaraController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $title = 'Master Kamus SARA';
        $description = 'Kumpulan kata-kata SARA dan tingkatannya.';

        $kamus = KamusSara::when($search, function ($query, $search) {
                $query->where('kata', 'like', "%$search%");
            })
            ->orderBy('kata')
            ->paginate(config('custom.pagination.size'));

        return view('admin.kamus_sara.index', compact('kamus', 'search', 'title', 'description'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kata' => 'required|string|max:255|unique:kamus_sara,kata',
        ], [
            'kata.unique' => 'Kata SARA sudah ada dalam kamus',
        ]);

        KamusSara::create($validated);
        
        // Clear cache setelah menambah kata SARA baru
        SaraChecker::clearCache();

        return redirect()->route('kamus-sara.index')->with('success', 'Kata SARA berhasil ditambahkan.');
    }

    public function update($id, Request $request)
    {
        $item = KamusSara::findOrFail($id);

        $validated = $request->validate([
            'kata' => 'required|string|max:255|unique:kamus_sara,kata,' . $item->id,
        ], [
            'kata.unique' => 'Kata SARA sudah ada dalam kamus',
        ]);

        $item->update($validated);
        
        // Clear cache setelah mengupdate kata SARA
        SaraChecker::clearCache();

        return redirect()->route('kamus-sara.index')->with('success', 'Kata SARA berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = KamusSara::findOrFail($id);
        $item->delete();
        
        // Clear cache setelah menghapus kata SARA
        SaraChecker::clearCache();

        return redirect()->route('kamus-sara.index')->with('success', 'Kata SARA berhasil dihapus.');
    }
}
