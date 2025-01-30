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
            ['nama_regu' => 'Regu 1'],
            ['nama_regu' => 'Regu 2'],
            ['nama_regu' => 'Regu 3'],
            ['nama_regu' => 'Regu 4'],
            ['nama_regu' => 'Regu 5'],
        ];

        // Insert data ke tabel regu
        foreach ($regu as $data) {
            Regu::create($data);
        }
    }
}
