<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriPengaduan;

class KategoriPengaduanSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nama' => 'Infrastruktur Jalan', 'deskripsi' => 'Kerusakan jalan, jembatan, dan fasilitas umum'],
            ['nama' => 'Kebersihan Lingkungan', 'deskripsi' => 'Sampah, saluran air, dan kebersihan umum'],
            ['nama' => 'Administrasi Desa', 'deskripsi' => 'Layanan administrasi dan dokumen kependudukan'],
            ['nama' => 'Keamanan & Ketertiban', 'deskripsi' => 'Gangguan keamanan, ketertiban, dan kenyamanan warga'],
            ['nama' => 'Bantuan Sosial', 'deskripsi' => 'Penyaluran bantuan dan kelayakan penerima'],
        ];

        foreach ($categories as $cat) {
            KategoriPengaduan::updateOrCreate(
                ['nama' => $cat['nama']],
                ['deskripsi' => $cat['deskripsi']]
            );
        }
    }
}
