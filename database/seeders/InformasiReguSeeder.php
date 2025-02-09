<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InformasiReguSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Data yang akan diisi ke tabel informasi_regu
        $informasiRegu = [
            [
                'informasi_id' => 2, // ID informasi
                'regu_id' => 1,      // ID regu
            ],
            [
                'informasi_id' => 2, // ID informasi
                'regu_id' => 2,      // ID regu
            ],
            [
                'informasi_id' => 2, // ID informasi
                'regu_id' => 3,      // ID regu
            ],
            [
                'informasi_id' => 4, // ID informasi
                'regu_id' => 1,      // ID regu
            ],
            [
                'informasi_id' => 4, // ID informasi
                'regu_id' => 4,      // ID regu
            ],
        ];

        // Masukkan data ke tabel informasi_regu
        DB::table('informasi_regu')->insert($informasiRegu);
    }
}