<?php

namespace App\Http\Controllers\global;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function loginView(Request $request)
    {
        $from_url = $request->query("from_url", null);
        $auth = Auth::user();
        if (Auth::check()) {
            if ($from_url && $auth->role == "penduduk") {
                return redirect($from_url);
            }
            return redirect("/dashboard");
        } else {
            return view("auth.login");
        }
    }

    public function loginStore(Request $request)
    {
        $from_url = $request->input("from_url", null);
        Session::flash("username", $request->username);
        $request->validate([
            "username" => "required",
            "password" => "required",
        ]);

        $credentials = $request->only("username", "password");
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if ($from_url) {
                return redirect()->intended($from_url);
            } else {
                return redirect()->intended("/dashboard");
            }
        } else {
            return back()->with("error", "Username atau password salah");
        }
    }

    public function logoutStore(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/login")->with("success", "Logout Berhasil");
    }

    public function redirectByRole(Request $request)
    {
        $role = Auth::user()->role;
        switch ($role) {
            case "admin":
                return redirect("/admin/dashboard");
            case "penduduk":
                return redirect("/penduduk/dashboard");
            case "eksekutor":
                return redirect("/eksekutor/dashboard");
            default:
                Auth::logout();
                return redirect("/login")->with("error", "Role tidak dikenali");
        }
    }
}
