<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $title = 'Master User';
        $description = 'Daftar seluruh user yang terdaftar di sistem.';
        $users = User::when($search, function ($query, $search) {
            return $query->where('nama_lengkap', 'like', '%' . $search . '%')
                        ->orWhere('username', 'like', '%' . $search . '%')
                        ->orWhere('no_hp', 'like', '%' . $search . '%');
        })->paginate(config('custom.pagination.size'));
        
        return view('admin.user.index', compact('users', 'search', 'title', 'description'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'no_hp' => 'required|string|max:15',
            'role' => 'required|in:admin,penduduk,eksekutor',
        ]);

        User::create($validatedData);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'no_hp' => 'required|string|max:15',
            'role' => 'required|in:admin,penduduk,eksekutor',
        ]);

        $user->update($validatedData);
        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function updatePassword($id, Request $request)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('users.index')->with('success', 'Password user berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
