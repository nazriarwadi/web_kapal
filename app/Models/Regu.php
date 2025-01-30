<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regu extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara manual
    protected $table = 'regu';

    protected $fillable = ['nama_regu'];

    public function anggota()
    {
        return $this->hasMany(Anggota::class);
    }
}