<?php

namespace Database\Seeders;

use App\Models\Profesi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfesiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Data yang akan diisi ke tabel profesi
        $profesi = [
            ['nama_profesi' => 'Operator'],
            ['nama_profesi' => 'Paylot'],
            ['nama_profesi' => 'Tongkang'],
            ['nama_profesi' => 'Palka'],
        ];

        // Insert data ke tabel profesi
        foreach ($profesi as $data) {
            Profesi::create($data);
        }
    }
}
