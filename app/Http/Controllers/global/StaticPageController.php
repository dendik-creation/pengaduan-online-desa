<?php

namespace App\Http\Controllers\global;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\User;
use App\Models\KategoriPengaduan;

class StaticPageController extends Controller
{
    public function home()
    {
        $pengaduanSelesai = Pengaduan::where('status', 'selesai')->count();
        $totalPengaduan = Pengaduan::count();
        $wargaTerdaftar = User::where('role', 'penduduk')->count();
        $kategori = KategoriPengaduan::limit(4)->get();

        return view("landing.home", compact('pengaduanSelesai', 'totalPengaduan', 'wargaTerdaftar', 'kategori'));
    }

    public function about()
    {
        $pengaduanSelesai = Pengaduan::where('status', 'selesai')->count();
        $totalPengaduan = Pengaduan::count();
        $wargaTerdaftar = User::where('role', 'penduduk')->count();
        $team = User::whereIn('role', ['admin', 'eksekutor'])->limit(3)->get();

        return view("landing.about", compact('pengaduanSelesai', 'totalPengaduan', 'wargaTerdaftar', 'team'));
    }

    public function contact()
    {
        $contactInfo = [
            'address' => 'Jl. Desa Maju No. 123, Kabupaten, Provinsi 12345',
            'phone' => '+62 123 4567 890',
            'email' => 'info@pengaduandesa.id',
            'whatsapp' => '+62 812 3456 7890',
            'emergency' => '+62 811 2345 6789',
            'working_hours' => [
                'weekdays' => '08:00 - 16:00',
                'saturday' => '08:00 - 12:00',
                'sunday' => 'Tutup'
            ]
        ];

        return view("landing.contact", compact('contactInfo'));
    }
}
