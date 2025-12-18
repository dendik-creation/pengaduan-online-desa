<?php

namespace App\Http\Controllers\global;

use App\Http\Controllers\Controller;
use App\Models\Komentar;
use App\Rules\NoSaraWords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk untuk berkomentar.');
        }

        $validated = $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,id',
            'isi' => ['required', 'string', 'min:3', new NoSaraWords('komentar')],
        ]);

        $komentar = new Komentar();
        $komentar->pengaduan_id = $validated['pengaduan_id'];
        $komentar->pengguna_id = Auth::id();
        $komentar->isi = $validated['isi'];
        $komentar->save();

        return redirect()->route('pengaduan.show', $validated['pengaduan_id'])
            ->with('success', 'Komentar berhasil dikirim.');
    }
}
