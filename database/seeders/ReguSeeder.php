<?php

namespace Database\Seeders;

use App\Models\Regu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReguSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Data yang akan diisi ke tabel regu
        $regu = [
            ['nama_regu' => 'Regu 6'],
            ['nama_regu' => 'Regu 7'],
            ['nama_regu' => 'Regu 8'],
            ['nama_regu' => 'Regu 9'],
            ['nama_regu' => 'Regu 10'],
        ];

        // Insert data ke tabel regu
        foreach ($regu as $data) {
            Regu::create($data);
        }
    }
}
