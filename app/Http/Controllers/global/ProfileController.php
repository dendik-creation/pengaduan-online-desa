<?php

namespace App\Http\Controllers\global;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $auth = Auth::user();
        if (!$auth) {
            return redirect()
                ->route("login")
                ->with("error", "Anda harus login terlebih dahulu.");
        }
        $user = User::findOrFail($auth->id);
        $title = "Profile Pengguna";
        return view("auth.profile.profile", compact("user", "title"));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            "username" => "required|string|unique:users,username," . Auth::id(),
            "nama_lengkap" => "required|string",
            "alamat" => "required|string",
            "no_hp" => "required|string",
        ]);
        $auth = Auth::user();
        if (!$auth) {
            return redirect()
                ->route("login")
                ->with("error", "Anda harus login terlebih dahulu.");
        }
        $user = User::findOrFail($auth->id);
        $user->update($validated);
        return redirect("/profile/#profile")->with(
            "success",
            "Profil berhasil diperbarui.",
        );
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            "current_password" => "required|string",
            "new_password" => "required|string|min:8|confirmed",
        ]);
        $auth = Auth::user();
        if (!$auth) {
            return redirect()
                ->route("login")
                ->with("error", "Anda harus login terlebih dahulu.");
        }
        $user = User::findOrFail($auth->id);
        if (!Hash::check($validated["current_password"], $user->password)) {
            return back()->with("error", "Password sekarang tidak sesuai.");
        }
        $user->update([
            "password" => Hash::make($validated["new_password"]),
        ]);
        return redirect("/profile/#password")->with(
            "success",
            "Password berhasil diperbarui.",
        );
    }
}
