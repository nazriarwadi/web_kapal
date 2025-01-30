<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara manual
    protected $table = 'informasi';

    protected $fillable = ['gambar', 'bawaan', 'kebarangkatan', 'jam_sampai', 'regu_id'];

    public function regu()
    {
        return $this->belongsTo(Regu::class);
    }
}