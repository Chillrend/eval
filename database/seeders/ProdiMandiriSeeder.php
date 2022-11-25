<?php

namespace Database\Seeders;

use App\Models\ProdiMand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdiMandiriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProdiMand::insert([
            ['id_prodi' => 1,   'prodi' => 'Administrasi Bisnis D3',                            'kelompok_bidang' => 'Rekayasa',    'kuota' => 1],
            ['id_prodi' => 2,   'prodi' => 'Administrasi Bisnis D4',                            'kelompok_bidang' => 'Rekayasa',    'kuota' => 1],
            ['id_prodi' => 3,   'prodi' => 'MICE D4',                                           'kelompok_bidang' => 'Rekayasa',    'kuota' => 1],
            ['id_prodi' => 4,   'prodi' => 'BISPRO D4',                                         'kelompok_bidang' => 'Rekayasa',    'kuota' => 1],
            ['id_prodi' => 5,   'prodi' => 'Akuntansi D3',                                      'kelompok_bidang' => 'Rekayasa',    'kuota' => 2],
            ['id_prodi' => 6,   'prodi' => 'Akuntansi D4',                                      'kelompok_bidang' => 'Rekayasa',    'kuota' => 2],
            ['id_prodi' => 7,   'prodi' => 'Keuangan dan Perbankan D3',                         'kelompok_bidang' => 'Rekayasa',    'kuota' => 2],
            ['id_prodi' => 8,   'prodi' => 'Keuangan dan Perbankan D4',                         'kelompok_bidang' => 'Tata Niaga',  'kuota' => 2],
            ['id_prodi' => 9,   'prodi' => 'Manajemen Keuangan D4',                             'kelompok_bidang' => 'Tata Niaga',  'kuota' => 2],
            ['id_prodi' => 10,  'prodi' => 'Manajemen Pemasaran D3 (WNBK)',                     'kelompok_bidang' => 'Tata Niaga',  'kuota' => 2],
            ['id_prodi' => 11,  'prodi' => 'Magister Terapan Rekayasa Teknologi Manufaktur S2', 'kelompok_bidang' => 'Tata Niaga',  'kuota' => 4],
            ['id_prodi' => 12,  'prodi' => 'Magister Terapan Teknik Elektro S2',                'kelompok_bidang' => 'Tata Niaga',  'kuota' => 4],
            ['id_prodi' => 13,  'prodi' => 'Broadband Multimmedia D4',                          'kelompok_bidang' => 'Tata Niaga',  'kuota' => 5],
            ['id_prodi' => 14,  'prodi' => 'Instrumentasi dan Kontrol Industri D4',             'kelompok_bidang' => 'Tata Niaga',  'kuota' => 5],
            ['id_prodi' => 15,  'prodi' => 'Teknik Elektronika Industri D3',                    'kelompok_bidang' => 'Tata Niaga',  'kuota' => 5],
            ['id_prodi' => 16,  'prodi' => 'Teknik Listrik D3',                                 'kelompok_bidang' => 'Tata Niaga',  'kuota' => 5],
            ['id_prodi' => 17,  'prodi' => 'Teknik Otomasi Listrik Industri D4',                'kelompok_bidang' => 'Tata Niaga',  'kuota' => 5],
            ['id_prodi' => 18,  'prodi' => 'Teknik Telekomunikasi D3',                          'kelompok_bidang' => 'Tata Niaga',  'kuota' => 5],
            ['id_prodi' => 19,  'prodi' => 'Desain Grafis D3',                                  'kelompok_bidang' => 'Tata Niaga',  'kuota' => 6],
            ['id_prodi' => 20,  'prodi' => 'Desain Grafis D4',                                  'kelompok_bidang' => 'Tata Niaga',  'kuota' => 6],
            ['id_prodi' => 21,  'prodi' => 'Penerbitan / Jurnalistik D3',                       'kelompok_bidang' => 'Tata Niaga',  'kuota' => 6],
            ['id_prodi' => 22,  'prodi' => 'Teknik Grafika D3',                                 'kelompok_bidang' => 'Tata Niaga',  'kuota' => 6],
            ['id_prodi' => 23,  'prodi' => 'Teknologi Industri Cetak Kemasan D4',               'kelompok_bidang' => 'Tata Niaga',  'kuota' => 6],
            ['id_prodi' => 24,  'prodi' => 'Teknik Informatika D4',                             'kelompok_bidang' => 'Rekayasa',    'kuota' => 7],
            ['id_prodi' => 25,  'prodi' => 'Teknik Komputer Jaringan D1',                       'kelompok_bidang' => 'Rekayasa',    'kuota' => 7],
            ['id_prodi' => 26,  'prodi' => 'Teknik Multimedia dan Jaringan D4',                 'kelompok_bidang' => 'Rekayasa',    'kuota' => 7],
            ['id_prodi' => 27,  'prodi' => 'Teknik Multimedia Digital D4',                      'kelompok_bidang' => 'Rekayasa',    'kuota' => 7],
            ['id_prodi' => 28,  'prodi' => 'Alat Berat D3',                                     'kelompok_bidang' => 'Rekayasa',    'kuota' => 8],
            ['id_prodi' => 29,  'prodi' => 'Konversi Energi D3',                                'kelompok_bidang' => 'Rekayasa',    'kuota' => 8],
            ['id_prodi' => 30,  'prodi' => 'Manufaktur D4',                                     'kelompok_bidang' => 'Rekayasa',    'kuota' => 8],
            ['id_prodi' => 31,  'prodi' => 'Pembangkit Tenaga Listrik D4',                      'kelompok_bidang' => 'Rekayasa',    'kuota' => 8],
            ['id_prodi' => 32,  'prodi' => 'Teknik Mesin D3',                                   'kelompok_bidang' => 'Rekayasa',    'kuota' => 8],
            ['id_prodi' => 33,  'prodi' => 'Konstruksi Gedung D3',                              'kelompok_bidang' => 'Rekayasa',    'kuota' => 9],
            ['id_prodi' => 34,  'prodi' => 'Konstruksi Gedung D4',                              'kelompok_bidang' => 'Rekayasa',    'kuota' => 9],
            ['id_prodi' => 35,  'prodi' => 'Konstruksi Sipil D3',                               'kelompok_bidang' => 'Rekayasa',    'kuota' => 9],
            ['id_prodi' => 36,  'prodi' => 'Teknik Perancangan Jalan Dan Jembatan D4',          'kelompok_bidang' => 'Rekayasa',    'kuota' => 9],
            ['id_prodi' => 37,  'prodi' => 'MICE D4 PSDKU Demak',                               'kelompok_bidang' => 'Rekayasa',    'kuota' => 1],
            ['id_prodi' => 38,  'prodi' => 'Teknik Mesin D3 PSDKU Demak',                       'kelompok_bidang' => 'Rekayasa',    'kuota' => 8],
        ]);
    }
}
