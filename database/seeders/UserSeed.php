<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeed extends Seeder
{
    public function run(): void
    {
        // 1 admin + 4 penduduk (total 5)
        $users = [
            [
                'username' => 'admin',
                'nama_lengkap' => 'Administrator Desa',
                'alamat' => 'Kantor Desa',
                'no_hp' => '081200000001',
                'role' => 'admin',
            ],
            [
                'username' => '3201010100000001',
                'nama_lengkap' => 'Andi Pratama',
                'alamat' => 'Jl. Mawar No. 1',
                'no_hp' => '081234560001',
                'role' => 'penduduk',
            ],
            [
                'username' => '3201010100000002',
                'nama_lengkap' => 'Siti Rahma',
                'alamat' => 'Jl. Melati No. 2',
                'no_hp' => '081234560002',
                'role' => 'penduduk',
            ],
            [
                'username' => '3201010100000003',
                'nama_lengkap' => 'Budi Santoso',
                'alamat' => 'Jl. Kenanga No. 3',
                'no_hp' => '081234560003',
                'role' => 'penduduk',
            ],
            [
                'username' => '3201010100000004',
                'nama_lengkap' => 'Dewi Lestari',
                'alamat' => 'Jl. Anggrek No. 4',
                'no_hp' => '081234560004',
                'role' => 'penduduk',
            ],
            [
                'username' => 'bpbd_eksekutor',
                'nama_lengkap' => 'BPBD',
                'alamat' => 'Jl. Anggrek No. 4',
                'no_hp' => '081234560004',
                'role' => 'eksekutor',
            ],
            [
                'username' => 'rt_rw_eksekutor',
                'nama_lengkap' => 'RT/RW',
                'alamat' => 'Kantor Desa',
                'no_hp' => '081200000005',
                'role' => 'eksekutor',
            ],
            [
                'username' => 'karang_taruna_eksekutor',
                'nama_lengkap' => 'Karang Taruna',
                'alamat' => 'Kantor Desa',
                'no_hp' => '081200000006',
                'role' => 'eksekutor',
            ],
            [
                'username' => 'bpd_eksekutor',
                'nama_lengkap' => 'BPD (Badan Permusyawaratan Desa)',
                'alamat' => 'Kantor Desa',
                'no_hp' => '081200000007',
                'role' => 'eksekutor',
            ],
            [
                'username' => 'tpk_eksekutor',
                'nama_lengkap' => 'TPK (Tim Pengelola Kegiatan)',
                'alamat' => 'Kantor Desa',
                'no_hp' => '081200000008',
                'role' => 'eksekutor',
            ],
            [
                'username' => 'lpmd_eksekutor',
                'nama_lengkap' => 'LPMD (Lembaga Pemberdayaan Masyarakat Desa)',
                'alamat' => 'Kantor Desa',
                'no_hp' => '081200000009',
                'role' => 'eksekutor',
            ],
            [
                'username' => 'pkk_eksekutor',
                'nama_lengkap' => 'PKK (Pembinaan Kesejahteraan Keluarga)',
                'alamat' => 'Kantor Desa',
                'no_hp' => '081200000010',
                'role' => 'eksekutor',
            ],
            [
                'username' => 'posyandu_eksekutor',
                'nama_lengkap' => 'Posyandu',
                'alamat' => 'Kantor Desa',
                'no_hp' => '081200000011',
                'role' => 'eksekutor',
            ],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['username' => $u['username']],
                [
                    'nama_lengkap' => $u['nama_lengkap'],
                    'alamat' => $u['alamat'],
                    'no_hp' => $u['no_hp'],
                    'role' => $u['role'],
                    'password' => Hash::make('12345'),
                ],
            );
        }
    }
}
