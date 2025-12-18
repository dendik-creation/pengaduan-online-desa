<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaduan;
use App\Models\User;
use App\Models\KategoriPengaduan;
use Carbon\Carbon;

class PengaduanSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh 3 records
        $pelapor = User::where("role", "penduduk")->take(3)->get();
        $kategori = KategoriPengaduan::take(3)->get();
        $data = [
            [
                "lokasi" => "RT 01/RW 02 Dusun Suka Maju",
                "rincian" =>
                    "Jalan berlubang mengganggu akses warga dan kendaraan.",
                "status" => "baru",
            ],
            [
                "lokasi" => "Lapangan Desa",
                "rincian" =>
                    "Sampah menumpuk setelah acara, perlu pembersihan.",
                "status" => "diproses",
            ],
            [
                "lokasi" => "Balai Desa",
                "rincian" =>
                    "Antrian panjang layanan administrasi, mohon penambahan loket.",
                "status" => "diproses",
            ],
        ];

        foreach ($data as $i => $d) {
            $user = $pelapor[$i % max(1, $pelapor->count())] ?? null;
            $kat = $kategori[$i % max(1, $kategori->count())] ?? null;
            Pengaduan::create([
                "lokasi" => $d["lokasi"],
                "rincian" => $d["rincian"],
                "status" => $d["status"],
                "kategori_id" => $kat?->id,
                "pengguna_id" => $user?->id,
                "tanggal_pengaduan" => Carbon::now()->subDays(10 - $i),
            ]);
        }
    }
}
